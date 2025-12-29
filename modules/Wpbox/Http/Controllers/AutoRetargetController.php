<?php

namespace Modules\Wpbox\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Wpbox\Models\AutoRetargetCampaign;
use Modules\Wpbox\Models\AutoRetargetMessage;
use Modules\Wpbox\Models\Campaign;

class AutoRetargetController extends Controller
{
    public function index()
    {
        $query = AutoRetargetCampaign::orderBy('id', 'desc');
        
       // ::with('messages')->get();

        $autoretargetCampaigns = $query->paginate(10);
        return view('wpbox::autoretarget.index', compact('autoretargetCampaigns'));
    }

    public function create()
    {
        // Get only API campaigns for selection
        $whatsappCampaigns = Campaign::where('is_api', true)->get();

        return view('wpbox::autoretarget.create', compact('whatsappCampaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        \Log::debug('AutoRetarget store request data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'messages' => 'required|array|min:1',
            'messages.*.campaign_id' => 'required|exists:wa_campaings,id',
            'messages.*.delay_days' => 'required|integer|min:0',
            'messages.*.send_time' => 'required|date_format:H:i',
            'messages.*.order' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            $autoretargetCampaign = AutoRetargetCampaign::create([
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => true,
            ]);

            \Log::debug('AutoRetarget campaign created:', $autoretargetCampaign->toArray());

            foreach ($request->messages as $messageData) {
                $message = $autoretargetCampaign->messages()->create([
                    'campaign_id' => $messageData['campaign_id'],
                    'delay_days' => $messageData['delay_days'],
                    'send_time' => $messageData['send_time'],
                    'order' => $messageData['order'],
                    'is_active' => true,
                ]);

                \Log::debug('AutoRetarget message created:', $message->toArray());
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'AutoRetarget campaign created successfully',
                    'redirect' => route('autoretarget.index'),
                ]);
            }

            return redirect()->route('autoretarget.index')->with('success', 'AutoRetarget campaign created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Failed to create AutoRetarget campaign:', ['error' => $e->getMessage()]);

            if ($request->ajax()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Failed to create AutoRetarget campaign: ' . $e->getMessage(),
                    ],
                    500,
                );
            }

            return back()
                ->with('error', 'Failed to create AutoRetarget campaign: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Similarly update the edit and update methods
    public function edit(AutoRetargetCampaign $autoretargetCampaign)
    {
        $autoretargetCampaign->load('messages');
        $whatsappCampaigns = Campaign::where('is_api', true)->get();

        return view('wpbox::autoretarget.edit', compact('autoretargetCampaign', 'whatsappCampaigns'));
    }
    /**
     * Display the specified resource.
     */
    public function show(AutoRetargetCampaign $autoretargetCampaign)
    {
        $autoretargetCampaign->load('messages.campaign', 'logs.contact', 'logs.campaign');

        return view('wpbox::autoretarget.show', compact('autoretargetCampaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, AutoRetargetCampaign $autoretargetCampaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'messages' => 'required|array|min:1',
            'messages.*.campaign_id' => 'required|exists:wa_campaings,id',
            'messages.*.delay_days' => 'required|integer|min:0',
            'messages.*.send_time' => 'required|date_format:H:i',
            'messages.*.order' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            $autoretargetCampaign->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Remove existing messages
            $autoretargetCampaign->messages()->delete();

            // Add new messages
            foreach ($request->messages as $messageData) {
                AutoRetargetMessage::create([
                    'autoretarget_campaign_id' => $autoretargetCampaign->id,
                    'campaign_id' => $messageData['campaign_id'],
                    'delay_days' => $messageData['delay_days'],
                    'send_time' => $messageData['send_time'],
                    'order' => $messageData['order'],
                    'is_active' => true,
                ]);
            }

            DB::commit();

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'AutoRetarget campaign updated successfully',
                    'redirect' => route('autoretarget.index'),
                ]);
            }

            return redirect()->route('autoretarget.index')->with('success', 'AutoRetarget campaign updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Failed to update AutoRetarget campaign: ' . $e->getMessage(),
                    ],
                    500,
                );
            }

            return back()
                ->with('error', 'Failed to update AutoRetarget campaign: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AutoRetargetCampaign $autoretargetCampaign)
    {
        try {
            $autoretargetCampaign->delete();
            return redirect()->route('autoretarget.index')->with('success', 'AutoRetarget campaign deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete AutoRetarget campaign: ' . $e->getMessage());
        }
    }

    /**
     * Toggle AutoRetarget status for a campaign
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'autoretarget_campaign_id' => 'required_if:enabled,true|exists:autoretarget_campaigns,id',
        ]);

        try {
            $campaign = AutoRetargetCampaign::findOrFail($request->autoretarget_campaign_id);

            $campaign->update([
                'is_active' => $request->enabled,
                'id' => $request->enabled ? $request->autoretarget_campaign_id : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'AutoRetarget ' . ($request->enabled ? 'enabled' : 'disabled'),
                'enabled' => $campaign->autoretarget_enabled,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update AutoRetarget status: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    // public function toggleStatus(Request $request, $id)
    // {
    //     $campaign = AutoRetargetCampaign::findOrFail($id);
    //     $campaign->is_active = !$campaign->is_active; // toggle status
    //     $campaign->save();

    //     return response()->json([
    //         'success' => true,
    //         'status' => $campaign->is_active ? 'Active' : 'Inactive',
    //     ]);
    // }
}
