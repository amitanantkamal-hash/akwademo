<?php

namespace Modules\AbandonedCart\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Wpbox\Models\Campaign;
use Illuminate\Http\Request;
use Modules\AbandonedCart\Models\AbandonedCartSetting;
use Modules\AbandonedCart\Models\AbandonedCart;

class AbandonedCartController extends Controller
{
    public function settings()
    {
        $companyId = auth()->user()->company_id;
        $settings = AbandonedCartSetting::firstOrNew(['company_id' => $companyId]);
        $campaigns = Campaign::where('is_api', true)->get();

        return view('abandoned-cart::settings', compact('settings', 'campaigns'));
    }

    public function updateSettings(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $validated = $request->validate([
            'enabled' => 'boolean',
            'campaign_ids' => 'required_if:enabled,true|array',
            'campaign_ids.*' => 'exists:wa_campaings,id',
            'schedule_days' => 'required_if:enabled,true|array',
            'schedule_days.*' => 'integer|min:0|max:30',
            'schedule_times' => 'required_if:enabled,true|array',
            'schedule_times.*' => 'date_format:H:i',
            'max_reminders' => 'required_if:enabled,true|integer|min:1|max:10',
        ]);

        // Ensure all arrays have the same length
        if (count($validated['campaign_ids'] ?? []) !== count($validated['schedule_days'] ?? []) || count($validated['campaign_ids'] ?? []) !== count($validated['schedule_times'] ?? [])) {
            return redirect()->back()->withErrors('Campaign IDs, days, and times must have the same number of items')->withInput();
        }

        $settings = AbandonedCartSetting::firstOrNew(['company_id' => $companyId]);
        $settings->fill($validated);
        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function index()
    {
        $companyId = auth()->user()->company_id;
        $carts = AbandonedCart::where('company_id', $companyId)->with('messages')->orderBy('created_at', 'desc')->paginate(20);

        return view('abandoned-cart::index', compact('carts'));
    }

    public function show($id)
    {
        $companyId = auth()->user()->company_id;
        $cart = AbandonedCart::where('company_id', $companyId)->with('messages')->findOrFail($id);

        return view('abandoned-cart::show', compact('cart'));
    }

    /**
     * Create a test abandoned cart via Postman
     */
    public function createTestAbandonedCart(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'platform' => 'required|in:shopify,woocommerce',
            'cart_id' => 'required|string',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'nullable|email',
            'cart_contents' => 'required|array',
            'cart_total' => 'required|numeric',
            'abandoned_at' => 'nullable|date',
        ]);

        try {
            // Set abandoned_at to now if not provided
            $abandonedAt = $validated['abandoned_at'] ?? now()->toDateTimeString();

            // Create the abandoned cart
            $abandonedCart = AbandonedCart::create([
                'company_id' => $validated['company_id'],
                'platform' => $validated['platform'],
                'cart_id' => $validated['cart_id'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'cart_contents' => json_encode($validated['cart_contents']),
                'cart_total' => $validated['cart_total'],
                'status' => 'active',
                'abandoned_at' => $abandonedAt,
            ]);

            // Process the abandoned cart to schedule messages
            $settings = AbandonedCartSetting::where('company_id', $validated['company_id'])->where('enabled', true)->first();

            if ($settings) {
                $this->abandonedCartService->scheduleMessages($abandonedCart, $settings);
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Test abandoned cart created successfully',
                    'data' => $abandonedCart,
                    'scheduled_messages' => $abandonedCart->messages->count(),
                ],
                201,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to create test abandoned cart',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
