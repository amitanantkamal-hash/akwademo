<?php

namespace Modules\CTWAMeta\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\CTWAMeta\Models\MetaLeads;
use Modules\CTWAMeta\Models\MetaPage;
use Modules\CTWAMeta\Models\MetaBusinessAccount;
use Modules\CTWAMeta\Jobs\ProcessCTWALead;
use App\Models\User;
use Modules\CTWAMeta\Models\FacebookForm;

class MetaWebhookController extends Controller
{
    /**
     * Handle incoming Meta webhook for leads.
     */
    public function handleLead(Request $request)
    {
        // Log raw payload
        Log::info('Meta Webhook payload received', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'body' => $request->getContent(),
            'parsed' => $request->all(),
        ]);

        // Webhook verification
        if ($request->isMethod('get')) {
            return $this->verifyWebhook($request);
        }

        // Validate X-Hub-Signature
        if ($request->header('X-Hub-Signature')) {
            $signature = $request->header('X-Hub-Signature');
            $expected = 'sha1=' . hash_hmac('sha1', $request->getContent(), config('services.facebook.ad_client_secret'));

            if (!hash_equals($expected, $signature)) {
                Log::warning('Invalid payload signature', ['received' => $signature, 'expected' => $expected]);
                return response('Invalid signature', 403);
            }
        }

        $entry = $request->input('entry.0');
        $change = $entry['changes'][0]['value'] ?? null;

        if (!$change || !isset($change['leadgen_id'])) {
            Log::error('Invalid webhook payload', ['payload' => $request->all()]);
            return response()->json(['success' => false, 'message' => 'Invalid payload']);
        }

        $leadgenId = $change['leadgen_id'];

        // Skip duplicates early
        if (MetaLeads::where('leadgen_id', $leadgenId)->exists()) {
            return response()->json(['success' => true, 'message' => 'Lead already exists']);
        }

        $pageId = $change['page_id'] ?? null;
        $formId = $change['form_id'] ?? null;
        $adgroupId = $change['adgroup_id'] ?? null;
        $adId = $change['ad_id'] ?? null;

        try {
            // Fetch Meta Page and Business Account efficiently
            $metaPage = MetaPage::firstWhere('page_id', $pageId);
            if (!$metaPage?->access_token) {
                return $this->logError('Meta page not found or no access token', $leadgenId, $pageId);
            }

            $businessAccount = MetaBusinessAccount::firstWhere('business_id', $metaPage->business_id);
            if (!$businessAccount) {
                return $this->logError('Meta business account not found', $leadgenId, $metaPage->business_id);
            }

            // Fetch lead details
            $leadDetails = Http::get("https://graph.facebook.com/v20.0/{$leadgenId}", [
                'access_token' => $metaPage->access_token,
                'fields' => 'created_time,ad_id,form_id,field_data',
            ])
                ->throw()
                ->json();

            // Optional: fetch form/ad name only if form_id exists
            $adName = null;
            // Normalize field_data
            $normalizedFields = collect($leadDetails['field_data'] ?? [])
                ->mapWithKeys(fn($field) => [$field['name'] => $field['values'][0] ?? null])
                ->all();

            if ($formId) {
                $facebookForm = FacebookForm::where('form_id', $formId)->first();

                if ($facebookForm) {
                    // Use local form name
                    $adName = $facebookForm->name;

                    // Forward to webhook if available
                    if ($facebookForm->webhook_url) {
                        try {
                            // Http::post($facebookForm->webhook_url, [
                            //     'form_id' => $formId,
                            //     'form_name' => $facebookForm->name,
                            //     'page_id' => $pageId,
                            //     'leadgen_id' => $leadgenId,
                            //     'leadDetails' => $leadDetails,
                            //     'leadinfo' => $normalizedFields,
                            // ]);

                            Http::post($facebookForm->webhook_url, [
                                'form_id' => $formId,
                                'form_name' => $facebookForm->name,
                                'page_id' => $pageId,
                                'leadinfo' => $normalizedFields,
                            ]);

                            Log::info('Forwarded lead to custom webhook', [
                                'form_id' => $formId,
                                'url' => $facebookForm->webhook_url,
                            ]);
                        } catch (\Exception $ex) {
                            Log::error('Failed to forward lead to webhook', [
                                'form_id' => $formId,
                                'url' => $facebookForm->webhook_url,
                                'error' => $ex->getMessage(),
                            ]);
                        }
                    }
                } else {
                    // Fallback to Graph API lookup if form not found locally
                    try {
                        $adName = Http::get("https://graph.facebook.com/v20.0/{$formId}", [
                            'access_token' => $metaPage->access_token,
                            'fields' => 'id,name',
                        ])
                            ->throw()
                            ->json('name');
                    } catch (\Exception $ex) {
                        Log::warning('Failed to fetch form name from Graph API', [
                            'form_id' => $formId,
                            'error' => $ex->getMessage(),
                        ]);
                    }
                }
            }

            // Create lead
            $lead = MetaLeads::create([
                'company_id' => $metaPage->company_id,
                'meta_page_id' => $metaPage->id,
                'business_id' => $businessAccount->id,
                'ad_id' => $leadDetails['ad_id'] ?? $adId,
                'ad_name' => $adName,
                'form_id' => $leadDetails['form_id'] ?? $formId,
                'page_id' => $pageId,
                'adgroup_id' => $adgroupId,
                'leadgen_id' => $leadgenId,
                'field_data' => $normalizedFields,
                'received_at' => Carbon::parse($leadDetails['created_time'] ?? now()),
                'processed' => false,
            ]);

            ProcessCTWALead::dispatch($lead);

            Log::info('Lead captured and job dispatched', ['leadgen_id' => $leadgenId]);

            return response()->json(['success' => true, 'message' => 'Lead processed successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to process Meta lead webhook', ['error' => $e->getMessage(), 'payload' => $request->all()]);
            return response()->json(['success' => false, 'message' => 'Error occurred while processing lead']);
        }
    }

    private function verifyWebhook(Request $request)
    {
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');
        $mode = $request->query('hub_mode');

        if (!$token) {
            return response('Missing verification token', 403);
        }

        $personalToken = PersonalAccessToken::findToken($token);
        if ($personalToken && $mode === 'subscribe') {
            $user = User::findOrFail($personalToken->tokenable_id);
            Auth::login($user);
            Log::info('Webhook verified successfully.');
            return response($challenge, 200);
        }

        return response('Invalid verification token or mode', 403);
    }

    private function logError(string $message, string $leadgenId, $id)
    {
        Log::error($message, ['leadgen_id' => $leadgenId, 'id' => $id]);
        return response()->json(['success' => false, 'message' => $message]);
    }
}
