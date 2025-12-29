<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Plans;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Coupon as StripeCoupon;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return view('coupons.index', compact('coupons'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('coupons.edit', compact('coupon'));
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        // Delete from Stripe
        try {
            \Stripe\Stripe::setApiKey(config('settings.stripe_secret'));
            \Stripe\Coupon::retrieve($coupon->stripe_coupon_id)->delete();
        } catch (\Exception $e) {
            return redirect()->route('coupons.index')->with('error', 'Error deleting coupon from Stripe: ' . $e->getMessage());
        }

        // Delete from local database
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon deleted successfully');
    }


    public function showCreateCouponForm(Plans $plans)
    {

        return view('coupons.create_coupon', ['plans' => $plans->paginate(100)]);
    }

    public function createCoupon(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:coupons',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|integer|min:1',
            'expiration_date' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
            'applicable_plan_ids' => 'nullable|array'
        ]);

        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->duration_type = $request->duration_type;
        $coupon->duration_in_months = $request->duration_in_months;
        $coupon->expiration_date = $request->expiration_date;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->applicable_plan_ids = json_encode($request->applicable_plan_ids);
        $coupon->save();

        Stripe::setApiKey(config('settings.stripe_secret'));

        $stripeparams = [
            'name' => $coupon->name,
            'percent_off' => $coupon->discount_type === 'percentage' ? $coupon->discount_value : null,
            'amount_off' => $coupon->discount_type === 'fixed' ? $coupon->discount_value * 100 : null,
            'currency' => 'usd',
            'duration' => $coupon->duration_type === 'repeating' ? 'repeating' : 'once',
            'duration_in_months' => $coupon->duration_type === 'repeating' ? $coupon->duration_in_months : null,
            'redeem_by' => $coupon->expiration_date ? strtotime($coupon->expiration_date) : null,
            'max_redemptions' => $coupon->usage_limit,
        ];

        //dd($stripeparams);

        $stripeCoupon = StripeCoupon::create($stripeparams);

        $coupon->stripe_coupon_id = $stripeCoupon->id;
        $coupon->save();

        return redirect()->route('admin.coupons.index')->with('status', 'Coupon created successfully');
    }

    public function applyCouponToSubscription(Request $request)
    {
        $user = auth()->user();
        $planId = $request->plan_id;
        $couponCode = $request->coupon_code;

        $coupon = Coupon::where('name', $couponCode)
            ->whereDate('expiration_date', '>=', now())
            ->first();

        if (!$coupon || ($coupon->applicable_plan_ids && !in_array($planId, json_decode($coupon->applicable_plan_ids)))) {
            return response()->json(['error' => 'Invalid or expired coupon'], 422);
        }

        Stripe::setApiKey(config('settings.stripe_secret'));

        $customer = \Stripe\Customer::create(['email' => $user->email]);
        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['price' => $planId]],
            'coupon' => $coupon->stripe_coupon_id,
        ]);

        return response()->json(['subscription' => $subscription]);
    }
    public function validateCoupon(Request $request)
    {
        session(['coupon_validation' => false]);
        session(['coupon' => null]);
        session(['coupon_id' => null]);

        $request->validate([
            'coupon_code' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        Stripe::setApiKey(config('settings.stripe_secret'));

        try {
            $stripeCouponCode = Coupon::where('name', $request->input('coupon_code'))->get(['stripe_coupon_id', 'applicable_plan_ids'])->first();

            if ($stripeCouponCode) {

                $applicablePlanIds = json_decode($stripeCouponCode->applicable_plan_ids, true); 

                $priceIdToFind = $request->input('plan_id');
                if (is_array($applicablePlanIds) && in_array($priceIdToFind, $applicablePlanIds)) {
                    $coupon = StripeCoupon::retrieve($stripeCouponCode->stripe_coupon_id);
                    if ($coupon->valid) {
                        $discountAmount = 0;

                        if ($coupon->percent_off) {
                            $discountAmount = ($request->input('amount') * $coupon->percent_off) / 100;
                        } elseif ($coupon->amount_off) {
                            $discountAmount = $coupon->amount_off;
                        }

                        $finalAmount = max(0, $request->input('amount') - $discountAmount);

                        session(['coupon_validation' => true]);
                        session(['coupon' => $request->input('coupon_code')]);
                        session(['coupon_id' => $stripeCouponCode->stripe_coupon_id]);

                        return response()->json([
                            'valid' => true,
                            'message' => __('coupon_applied_successfully'),
                            'discount_amount' => $discountAmount,
                            'final_amount' => $finalAmount,
                        ]);
                    } else {
                        return response()->json(['valid' => false, 'message' => __('invalid_coupon_code')], 400);
                    }
                } else {
                    return response()->json(['valid' => false, 'message' => __('invalid_coupon_code')], 400);
                }
            } else {
                return response()->json(['valid' => false, 'message' => __('invalid_coupon_code')], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['valid' => false, 'message' => __('error_validating_coupon:') . $e->getMessage()], 500);
        }
    }
}
