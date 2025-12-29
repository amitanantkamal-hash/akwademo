<?php

namespace Modules\CTWAMeta\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\CTWAMeta\Models\FacebookForm;
use Modules\CTWAMeta\Models\MetaPage;

class FacebookFormController extends Controller
{
    /**
     * Display a listing of saved forms for a Page
     */
    public function index($pageId)
    {
        $user = Auth::user();
        $company = $user->resolveCurrentCompany();

        $page = MetaPage::where('page_id', $pageId)->firstOrFail();

        // Change from get() to paginate()
        $forms = FacebookForm::where('meta_page_id', $pageId)
            ->orderBy('created_time', 'desc') // latest first
            ->paginate(10);

        $companyId = $company->id;

        return view('c-t-w-a-meta::facebook.leads-form', compact('forms', 'pageId', 'companyId', 'page'));
    }

    /**
     * Fetch forms from Meta API and save only new ones
     */
    public function fetchForms($pageId, $companyId)
    {
        $page = MetaPage::where('page_id', $pageId)->firstOrFail();

        $response = Http::get("https://graph.facebook.com/v20.0/{$pageId}/leadgen_forms", [
            'access_token' => $page->access_token,
            'fields' => 'id,name,created_time,questions',
        ]);

        $forms = $response->json()['data'] ?? [];
        $newCount = 0;

        foreach ($forms as $form) {
            if (!FacebookForm::where('form_id', $form['id'])->exists()) {
                FacebookForm::create([
                    'form_id' => $form['id'],
                    'meta_page_id' => $pageId, // ✅ FK to meta_pages
                    'company_id' => $companyId, // ✅ FK to companies
                    'name' => $form['name'] ?? null,
                    'created_time' => $form['created_time'] ?? null,
                    'questions' => $form['questions'] ?? [],
                ]);
                $newCount++;
            }
        }

        return back()->with('success', "$newCount new form(s) fetched.");
    }

    /**
     * Update the webhook URL for a form
     */
    public function setWebhook(Request $request, $formId)
    {
        $request->validate([
            'webhook_url' => 'required|url',
        ]);

        $form = FacebookForm::where('form_id', $formId)->firstOrFail();

        $form->update([
            'webhook_url' => $request->input('webhook_url'),
        ]);

        return back()->with('success', 'Webhook URL saved successfully.');
    }

    public function removeWebhook($formId)
    {
        $form = FacebookForm::where('form_id', $formId)->firstOrFail();

        $form->update([
            'webhook_url' => null,
        ]);

        return back()->with('success', 'Webhook URL removed successfully.');
    }
}
