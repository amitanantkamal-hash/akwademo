<?php

namespace Modules\LeadManager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Field;
use Modules\Contacts\Models\Group;
use Modules\LeadManager\Exports\LeadsExport;
use Modules\LeadManager\Models\Lead;
use Modules\LeadManager\Models\LeadFollowup;
use Modules\LeadManager\Models\LeadNote;
use Modules\LeadManager\Models\LeadSource;
use Illuminate\Database\QueryException;

class LeadManagerController extends Controller
{

    /**
     * Provide class.
     */
    private $provider = Lead::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'leads.';

    /**
     * View path.
     */
    private $view_path = 'lead-manager::';

    /**
     * Parameter name.
     */
    private $parameter_name = 'lead';

    /**
     * Title of this crud.
     */
    private $title = 'lead';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'leads';

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $companyId = $user->company_id;

        $baseQuery = Lead::forCompany($companyId)
            ->with(['contact', 'agent'])
            ->whereHas('contact');

        // Restrict only staff users
        if ($user->hasRole('staff')) {
            $baseQuery->whereHas('contact', function ($q) use ($user) {
                $q->where('user_id', $user->id); // only assigned contacts
            });
        }

        // Clone query for filters
        $query = clone $baseQuery;

        // Filters
        if ($request->filled('name')) {
            $query->whereHas('contact', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->whereHas('contact', function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('contact', function ($q) use ($request) {
                $q->whereJsonContains('tags', $request->tag);
            });
        }

        if ($request->filled('group')) {
            $query->whereHas('contact.groups', function ($q) use ($request) {
                $q->where('groups.id', $request->group);
            });
        }

        if ($request->filled('agent_id')) {
            $query->whereHas('contact.user', function ($q) use ($request) {
                $q->where('id', $request->agent_id);
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Stats based on filtered query
        $statsQuery = clone $query;

        $totalLeads     = (clone $statsQuery)->count();
        $wonLeads       = (clone $statsQuery)->where('stage', 'Won')->count();
        $lostLeads      = (clone $statsQuery)->where('stage', 'Lost')->count();
        $inProgressLeads = (clone $statsQuery)->where('stage', 'In Progress')->count();
        $newLeads       = (clone $statsQuery)->where('stage', 'New')->count();
        $totalValue     =  0;

        if ($request->has('stage')) {
            if ($request->stage === '_default') {
                $query->whereIn('stage', ['New', 'Follow-up', 'In Progress']);
            } elseif ($request->stage === 'all') {
                // Show all
            } elseif ($request->filled('stage')) {
                $query->where('stage', $request->stage);
            }
        } else {
            $query->whereIn('stage', ['New', 'Follow-up', 'In Progress']);
        }

        // Paginated leads
        $leads = $query->latest()
            ->paginate(config('settings.paginate'))
            ->appends($request->except('page'));

        // Dropdown data
        $agents = User::where('company_id', $companyId)->get();
        $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'];
        $sources = LeadSource::forCompany($companyId)->active()->get();
        $filter_groups = Group::select('id', 'name')->get();

        $existingTags = Contact::where('company_id', $companyId)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->map(fn($tags) => json_decode($tags, true))
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        return view($this->view_path . 'index', compact(
            'leads',
            'agents',
            'stages',
            'sources',
            'filter_groups',
            'existingTags',
            'totalLeads',
            'wonLeads',
            'lostLeads',
            'inProgressLeads',
            'newLeads',
            'totalValue'
        ));
    }


    private function getFields($class = 'col-md-4', $getCustom = true)
    {
        $fields = [];

        // Add custom fields
        if ($getCustom) {
            $customFields = Field::get()->toArray();
            $i = 5;
            foreach ($customFields as $filedkey => $customField) {
                $i++;
                $fields[$i] = ['class' => $class, 'ftype' => 'input', 'type' => $customField['type'], 'name' => __($customField['name']), 'id' => 'custom[' . $customField['id'] . ']', 'placeholder' => __($customField['name']), 'required' => false];
            }
        }

        return $fields;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();

        $companyId = auth()->user()->company_id;
        // Get available stages
        $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'];

        $agents = User::where('company_id', $companyId)->get();
        // Get available lead sources
        $sources = LeadSource::forCompany($companyId)->active()->get();

        $groups = Group::where('company_id', $companyId)->get();
        $setup = [
            'title' => __('crud.new_item', ['item' => __($this->title)]),
            'action_link' => route($this->webroute_path . 'index'),
            'action_name' => __('crud.back'),
            'iscontent' => true,
            'action' => route($this->webroute_path . 'store'),
        ];

        $existingTags = Contact::where('company_id', $companyId)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->map(fn($tags) => json_decode($tags, true))
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();


        return view($this->view_path . 'create', [
            'setup' => $setup,
            'fields' => $this->getFields(),
            'stages' => $stages,
            'sources' => $sources,
            'existingTags' => $existingTags,
            'agents' => $agents,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->authChecker();

        $validated = $request->validate([
            'phone' => 'required|string',
            'name' => 'required|string',
            'source_id' => 'nullable|exists:lead_sources,id',
            'stage' => 'nullable|in:New,In Progress,Follow-up,Won,Lost,Closed',
            'agent_id' => 'nullable|exists:users,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'custom' => 'nullable|array',
        ]);

        $companyId = auth()->user()->company_id;

        // Determine agent for lead and contact
        $agentId = $validated['agent_id'];

        try {
            // Check if contact exists
            $contact = Contact::where('company_id', $companyId)
                ->where('phone', $validated['phone'])
                ->first();

            if (!$contact) {
                // Create new contact
                $contactData = [
                    'company_id' => $companyId,
                    'phone' => $validated['phone'],
                    'name' => $validated['name'] ?? null,
                    'tags' => !empty($validated['tags'] ?? null) ? json_encode($validated['tags']) : null,
                    'user_id' => $agentId,
                ];

                $contact = Contact::create($contactData);

                if (isset($validated['custom'])) {
                    $this->syncCustomFieldsToContact($validated['custom'], $contact);
                }
            } else {
                // Update existing contact
                $contact->update([
                    'name' => $validated['name'] ?? $contact->name,
                    'tags' => !empty($validated['tags'] ?? null) ? json_encode($validated['tags']) : $contact->tags,
                    'user_id' => $agentId, // update agent_id
                ]);
            }

            // Create lead
            $lead = Lead::create([
                'company_id' => $companyId,
                'contact_id' => $contact->id,
                'agent_id' => $contact->user_id ?? $agentId,
                'source_id' => $validated['source_id'] ?? null,
                'stage' => $validated['stage'] ?? 'New'
            ]);

            // Handle groups
            if (!empty($validated['groups'])) {
                $contact->groups()->sync($validated['groups']);
            }

            // Return JSON if AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lead created successfully',
                    'data' => [
                        'lead_id' => $lead->id,
                        'contact_id' => $contact->id,
                    ]
                ]);
            }

            return redirect()->route($this->webroute_path . 'index')
                ->with('success', 'Lead created successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // Detect unique constraint violation
            if ($e->getCode() === '23000') {
                $errorMessage = 'Phone number already exists!';
            } else {
                $errorMessage = 'Something went wrong! Please try again.';
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 422);
            }

            return redirect()->back()->withErrors($errorMessage)->withInput();
        }
    }

    /**
     * Sync custom fields to contact
     */
    private function syncCustomFieldsToContact($fields, $contact)
    {
        $contact->fields()->sync([]);
        foreach ($fields as $key => $value) {
            if ($value) {
                $contact->fields()->attach($key, ['value' => $value]);
            }
        }
        $contact->update();
    }


    public function show($id)
    {
        $user = auth()->user();
        $companyId = $user->company_id;

        // Load the current lead with relations
        $leadQuery = Lead::forCompany($companyId)
            ->with([
                'contact.groups',
                'contact.user', // agent
                'notes.agent',
                'followups',
                'source'
            ])
            ->whereHas('contact');

        // Staff can only view their assigned leads
        if ($user->hasRole('staff')) {
            $leadQuery->whereHas('contact', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $lead = $leadQuery->findOrFail($id);
        $lead->source_name = $lead->source?->name;

        // Navigation
        $allowedStages = ['New', 'In Progress', 'Follow-up'];
        $navQuery = Lead::forCompany($companyId)
            ->whereHas('contact')
            ->whereIn('stage', $allowedStages);

        if ($user->hasRole('staff')) {
            $navQuery->whereHas('contact', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $leadIds = $navQuery->orderBy('created_at', 'desc')->pluck('id')->toArray();
        $currentIndex = array_search($lead->id, $leadIds);
        $previousId = $leadIds[$currentIndex - 1] ?? null;
        $nextId = $leadIds[$currentIndex + 1] ?? null;

        $existingTags = Contact::where('company_id', $companyId)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->map(fn($tags) => json_decode($tags, true))
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();


        $groups = Group::where('company_id', $companyId)->get();

        $agents = User::where('company_id', $companyId)->get();

        $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost'];

        return view('lead-manager::show', compact(
            'lead',
            'previousId',
            'nextId',
            'existingTags',
            'groups',
            'agents',
            'stages'
        ));
    }



    // public function edit($id)
    // {
    //     $companyId = auth()->user()->company_id;
    //     $lead = Lead::forCompany($companyId)
    //         ->with(['contact', 'agent', 'notes', 'followups'])
    //         ->findOrFail($id);

    //     $agents = User::where('company_id', $companyId)->get();
    //     $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'];

    //     return view('lead-manager::edit', compact('lead', 'agents', 'stages'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $companyId = auth()->user()->company_id;
    //     $lead = Lead::forCompany($companyId)->findOrFail($id);

    //     $validated = $request->validate([
    //         'stage' => 'sometimes|in:New,In Progress,Follow-up,Won,Lost,Closed',
    //         'agent_id' => 'nullable|exists:users,id',
    //         'source' => 'nullable|string',
    //         'next_followup_at' => 'nullable|date'
    //     ]);

    //     $lead->update($validated);

    //     // Handle status change automation
    //     if ($request->has('stage') && in_array($request->stage, ['Won', 'Lost', 'Closed'])) {
    //         $this->handleStatusChange($lead, $request->stage);
    //     }

    //     return redirect()->route('leads.show', $lead->id)->with('success', 'Lead updated successfully');
    // }

    public function destroy($id)
    {
        $companyId = auth()->user()->company_id;
        $lead = Lead::forCompany($companyId)->findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully');
    }

    public function kanban()
    {
        $user = auth()->user();
        $companyId = $user->company_id;
        $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'];

        $leadsByStage = [];

        foreach ($stages as $stage) {
            $query = Lead::forCompany($companyId)
                ->where('stage', $stage)
                ->with(['contact', 'agent'])
                ->whereHas('contact');

            // Restrict to assigned leads for staff
            if ($user->hasRole('staff')) {
                $query->whereHas('contact', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }

            $leadsByStage[$stage] = $query->orderBy('updated_at', 'desc')->get();
        }

        return view('lead-manager::kanban', compact('leadsByStage', 'stages'));
    }


    // ... (keep the rest of your methods as they are for API functionality)

    // Add this method for the kanban view
    public function kanbanView()
    {
        return $this->kanban();
    }

    // Add these methods to your LeadManagerController

    public function addNote(Request $request, $id)
    {
        $companyId = auth()->user()->company_id;
        $lead = Lead::forCompany($companyId)->findOrFail($id);

        $validated = $request->validate([
            'note' => 'required|string'
        ]);

        $note = LeadNote::create([
            'lead_id' => $lead->id,
            'agent_id' => auth()->id(),
            'note' => $validated['note']
        ]);

        return redirect()->back()->with('success', 'Note added successfully');
    }

    public function scheduleFollowup(Request $request, $id)
    {
        $companyId = auth()->user()->company_id;
        $lead = Lead::forCompany($companyId)->findOrFail($id);

        $validated = $request->validate([
            'scheduled_at' => 'required|date',
            'notes' => 'required|string'
        ]);

        $followup = LeadFollowup::create([
            'lead_id' => $lead->id,
            'scheduled_at' => $validated['scheduled_at'],
            'notes' => $validated['notes']
        ]);

        // Update lead's next followup date
        $lead->update(['next_followup_at' => $validated['scheduled_at']]);

        // Respond with JSON
        return response()->json([
            'success' => true,
            'message' => 'Follow-up scheduled successfully',
            'followup' => $followup
        ]);
    }



    public function updateStage(Request $request, $id)
    {
        try {
            $companyId = auth()->user()->company_id;
            $lead = Lead::forCompany($companyId)->findOrFail($id);

            $validated = $request->validate([
                'stage' => 'required|in:New,In Progress,Follow-up,Won,Lost,Closed'
            ]);

            $lead->update($validated);

            // Handle status change automation
            $this->handleStatusChange($lead, $validated['stage']);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            \Log::error('Failed to update lead stage: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update lead stage',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $companyId = auth()->user()->company_id;

        // Load lead with contact, agent, groups, and custom fields
        $lead = Lead::forCompany($companyId)
            ->with(['contact.groups', 'contact.fields', 'agent'])
            ->findOrFail($id);

        $fields = $this->getFields();

        // Pre-fill custom fields
        $customFieldValues = $lead->contact->fields->pluck('pivot.value', 'id')->toArray();
        foreach ($fields as &$field) {
            if (isset($field['id'])) {
                // Custom field
                if (str_starts_with($field['id'], 'custom[')) {
                    preg_match('/custom\[(\d+)\]/', $field['id'], $matches);
                    $fieldId = $matches[1] ?? null;
                    $field['value'] = $customFieldValues[$fieldId] ?? null;
                }
            }
        }

        // Load agents, sources, groups, tags for form dropdowns
        $agents = User::where('company_id', $companyId)->get();
        $stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'];
        $sources = LeadSource::forCompany($companyId)->active()->get();
        $groups = Group::where('company_id', $companyId)->get();
        $existingTags = Contact::where('company_id', $companyId)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->map(fn($tags) => json_decode($tags, true))
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $setup = [
            'title' => __('Edit Lead') . ' - ' . $lead->contact->name,
            'action_link' => route($this->webroute_path . 'index'),
            'action_name' => __('Back to Leads'),
            'iscontent' => true,
            'isupdate' => true,
            'action' => route($this->webroute_path . 'update', $lead->id),
        ];

        return view($this->view_path . 'edit', compact(
            'setup',
            'fields',
            'lead',
            'agents',
            'stages',
            'sources',
            'groups',
            'existingTags'
        ));
    }

    public function update(Request $request, $id)
    {
        $companyId = auth()->user()->company_id;
        $lead = Lead::forCompany($companyId)->findOrFail($id);

        $validated = $request->validate([
            'source_id' => 'nullable|exists:lead_sources,id',
            'stage' => 'nullable|in:New,In Progress,Follow-up,Won,Lost,Closed',
            'agent_id' => 'nullable|exists:users,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'custom' => 'nullable|array',
        ]);

        $agentId = $validated['agent_id'];
        // Update contact info
        $contact = $lead->contact;
        $contact->update([
            // Update other contact fields if needed, e.g., name or phone
            // 'name' => $request->name ?? $contact->name,
            // 'phone' => $request->phone ?? $contact->phone,
            'user_id' => $agentId, // assign agent_id
            'tags' => !empty($validated['tags'] ?? null) ? json_encode($validated['tags']) : $contact->tags,
        ]);

        //      $sourceId = null;
        // if (!empty($validated['source_id'])) {
        //     if (is_numeric($validated['source_id'])) {
        //         $sourceId = $validated['source_id']; // existing source
        //     } else {
        //         // Create new lead source
        //         $newSource = LeadSource::create([
        //             'company_id' => $companyId,
        //             'name' => $validated['source_id'],
        //             'is_active' => 1
        //         ]);
        //         $sourceId = $newSource->id;
        //     }
        // }

        // Update lead info
        $lead->update([
            'source_id' => $validated['source_id'] ?? null,
            'stage' => $validated['stage'] ?? 'New',
        ]);

        // Sync groups
        if (!empty($validated['groups'])) {
            $contact->groups()->sync($validated['groups']);
        } else {
            $contact->groups()->detach();
        }

        // Sync custom fields
        if (isset($request->custom)) {
            $this->syncCustomFieldsToContact($request->custom, $contact);
        }

        return redirect()->route($this->webroute_path . 'show', $lead->id)
            ->with('success', 'Lead updated successfully');
    }


    public function storeLeadSource(Request $request)
    {
        $companyId = auth()->user()->company_id;

        $request->validate([
            'name' => 'required|string|unique:lead_sources,name,NULL,id,company_id,' . $companyId,
        ]);

        $source = LeadSource::create([
            'company_id' => $companyId,
            'name' => $request->name,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => $source
        ]);
    }

    // Bulk Add Tag
    // Bulk Add Tag
    public function bulkAddTag(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'tags' => 'required|array'
        ]);

        $companyId = auth()->user()->company_id;
        foreach ($request->contacts as $contactId) {
            $contact = Contact::where('id', $contactId)
                ->where('company_id', $companyId)
                ->first();


            if (!$contact) continue;

            // Parse existing tags safely
            $currentTags = [];
            if ($contact->tags) {
                $decoded = json_decode($contact->tags, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $currentTags = array_map('trim', $decoded);
                } else {
                    $cleaned = trim($contact->tags, '[]"');
                    $currentTags = array_filter(array_map('trim', explode(',', $cleaned)));
                }
            }

            // Merge new tags safely
            $newTags = array_map('trim', $request->tags);
            $merged = array_unique(array_merge($currentTags, $newTags));

            // Only save if changed
            if (count($merged) !== count($currentTags)) {
                $contact->tags = json_encode(array_values($merged));
                $contact->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tags added successfully'
        ]);
    }

    public function bulkRemoveTag(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'tags' => 'required|array'
        ]);

        $user = auth()->user();

        foreach ($request->contacts as $contactId) {
            $contact = Contact::where('id', $contactId)
                ->where('company_id', $user->company_id)
                ->first();

            if (!$contact) continue;

            // Parse existing tags safely
            $currentTags = [];
            if ($contact->tags) {
                $decoded = json_decode($contact->tags, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $currentTags = array_map('trim', $decoded);
                } else {
                    $cleaned = trim($contact->tags, '[]"');
                    $currentTags = array_filter(array_map('trim', explode(',', $cleaned)));
                }
            }

            // Remove selected tags
            $tagsToRemove = array_map('trim', $request->tags);
            $updated = array_values(array_diff($currentTags, $tagsToRemove));

            if (count($updated) !== count($currentTags)) {
                $contact->tags = json_encode($updated);
                $contact->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Tags removed successfully'
        ]);
    }

    // Bulk Add Group
    public function bulkAddGroup(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'groups' => 'required|array',
        ]);

        $groupIds = array_map('intval', $request->groups); // ensure numeric IDs

        foreach ($request->contacts as $contactId) {
            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->groups()->syncWithoutDetaching($groupIds);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function bulkRemoveGroup(Request $request)
    {
        $request->validate([
            'contacts' => 'required|array',
            'groups' => 'required|array',
        ]);

        $groupIds = array_map('intval', $request->groups); // ensure numeric IDs

        foreach ($request->contacts as $contactId) {
            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->groups()->detach($groupIds);
            }
        }

        return response()->json(['status' => 'success']);
    }

    // Delete a note
    public function destroyNotes($leadId, $noteId)
    {
        $note = LeadNote::where('lead_id', $leadId)->findOrFail($noteId);
        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully.');
    }

    // Delete a follow-up
    public function destroyFollowup($leadId, $followupId)
    {
        $followup = LeadFollowup::where('lead_id', $leadId)->findOrFail($followupId);
        $followup->delete();

        return redirect()->back()->with('success', 'Follow-up deleted successfully.');
    }

    public function updateLeadSource(Request $request)
    {
        $source = LeadSource::findOrFail($request->id);
        $source->name = $request->name;
        $source->save();

        return response()->json([
            'success' => true,
            'message' => 'Lead source updated successfully',
            'id' => $source->id,
            'name' => $source->name
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $source = LeadSource::findOrFail($request->id);
        $source->status = !$source->status;
        $source->save();

        return response()->json([
            'success' => true,
            'status' => $source->status
        ]);
    }

    public function storeLeadSourceViaModal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $source = LeadSource::create([
            'name' => $request->name,
            'status' => 1, // default enabled
        ]);

        return response()->json([
            'success' => true,
            'id' => $source->id,
            'name' => $source->name,
        ]);
    }

    public function inlineUpdate(Request $request, $lead)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        // Fetch the Lead model by ID
        $lead = Lead::find($lead);

        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'Lead not found',
            ], 404);
        }

        $field = $request->input('field');
        $value = $request->input('value');

        try {
            switch ($field) {
                case 'stage':
                    $lead->stage = $value;
                    break;

                case 'agent':
                    if ($lead->contact) {
                        $lead->contact->user_id = $value;
                        $lead->contact->save();
                    }
                    break;

                case 'tags':
                    if ($lead->contact) {
                        $tags = is_array($value) ? $value : explode(',', $value);
                        $lead->contact->tags = $tags;
                        $lead->contact->save();
                    }
                    break;

                case 'groups':
                    if ($lead->contact) {
                        $groupIds = is_array($value) ? $value : [$value];
                        $lead->contact->groups()->sync($groupIds);
                    }
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid field'
                    ]);
            }

            $lead->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst($field) . ' updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
