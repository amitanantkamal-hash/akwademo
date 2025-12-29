<?php

namespace Modules\BotFlow\Http\Livewire\FlowBot;

use Modules\BotFlow\Models\BotFlow;
use App\Rules\PurifiedInput;
use Livewire\Component;
use Livewire\WithPagination;

class FlowList extends Component
{
    use WithPagination;

    //public BotFlow $botFlow;

    public $botFlow = [
        'id' => null,
        'name' => '',
        'description' => '',
        'flow_data' => null,
        'is_active' => 1,
    ];

    public $showFlowModal = false;

    public $confirmingDeletion = false;

    protected $featureLimitChecker;

    public $botFlowId = null;

    protected $listeners = [
        'editFlow' => 'editFlow',
        'confirmDelete' => 'confirmDelete',
        'editRedirect' => 'editRedirect',
    ];

    public $company_id;

    public function mount()
    {

        $this->resetForm();
        //$this->botFlow = new BotFlow;
        $this->company_id = auth()->user()->company->id;
    }

    // public function boot(FeatureService $featureLimitChecker)
    // {
    //     $this->featureLimitChecker = $featureLimitChecker;
    // }

    public function boot() {}

    protected function rules()
    {
        return [
            'botFlow.name' => [
                'required',
                'unique:bot_flows,name,' . ($this->botFlow->id ?? 'NULL'),

                'max:150',
            ],
            'botFlow.description' => [
                'nullable',

                'max:150',
            ],
        ];
    }

    public function createBotFlow()
    {
        $this->resetForm();
        $this->showFlowModal = true;
    }

    // public function save()
    // {
    //     $this->validate();

    //     $isNew = ! $this->botFlow->exists;

    //     // For new records, check if creating one more would exceed the limit
    //     // if ($isNew) {
    //     //     $limit = $this->featureLimitChecker->getLimit('bot_flow');

    //     //     // Skip limit check if unlimited (-1) or no limit set (null)
    //     //     if ($limit !== null && $limit !== -1) {
    //     //         $currentCount = BotFlow::where('company_id', auth()->user()->company->id)->count();

    //     //         if ($currentCount >= $limit) {
    //     //             $this->showFlowModal = false;
    //     //             // Show upgrade notification
    //     //             $this->notify([
    //     //                 'type' => 'warning',
    //     //                 'message' => __('bot_flow_limit_reached_message'),
    //     //             ]);

    //     //             return;
    //     //         }
    //     //     }
    //     // }

    //     if ($this->botFlow->isDirty()) {
    //         $this->botFlow->company_id = auth()->user()->company->id;
    //         if ($isNew) {
    //             // Only set flow_data to null for completely new flows
    //             // This ensures new flows start with empty flow data
    //             $this->botFlow->flow_data = null;
    //         }
    //         // For existing flows, preserve the existing flow_data
    //         $this->botFlow->save();

    //         if ($isNew) {
    //             $this->featureLimitChecker->trackUsage('bot_flow');
    //         }

    //         $this->showFlowModal = false;

    //         $message = $this->botFlow->wasRecentlyCreated
    //             ? __('bot_flow_saved_successfully')
    //             : __('bot_flow_update_successfully');

    //         $this->notify(['type' => 'success', 'message' => $message]);
    //         $this->dispatch('flow-bot-table-refresh');
    //     } else {
    //         $this->showFlowModal = false;
    //     }
    // }

    public function save()
    {
        $this->validate();

        $isNew = empty($this->botFlow['id']);

        // 🔐 Feature limit check (only for create)
        /*
        if ($isNew) {
            $limit = $this->featureLimitChecker->getLimit('bot_flow');

            if ($limit !== null && $limit !== -1) {
                $currentCount = BotFlow::where('company_id', $this->company_id)->count();

                if ($currentCount >= $limit) {
                    $this->showFlowModal = false;

                    $this->notify([
                        'type' => 'warning',
                        'message' => __('bot_flow_limit_reached_message'),
                    ]);

                    return;
                }
            }
        }
        */

        $flow = BotFlow::updateOrCreate(
            [
                'company_id' => $this->company_id,
                'name' => $this->botFlow['name'],
                'description' => $this->botFlow['description'],
                'is_active' => true,
            ]
        );

        if ($isNew) {
            //$this->featureLimitChecker->trackUsage('bot_flow');
        }

        $this->showFlowModal = false;
        $this->resetForm();

        $message = $isNew
            ? __('bot_flow_saved_successfully')
            : __('bot_flow_update_successfully');

        // $this->notify([
        //     'type' => 'success',
        //     'message' => $message,
        // ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message,
        ]);

        $this->dispatch('flow-bot-table-refresh');
    }

    public function confirmDelete($flowId)
    {
        $this->botFlowId = $flowId;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $botFlow = BotFlow::find($this->botFlowId);

        if ($botFlow) {
            $botFlow->delete();
        }

        $this->confirmingDeletion = false;
        $this->resetForm();
        $this->botFlowId = null;
        $this->resetPage();

        //$this->notify(['type' => 'success', 'message' => __('flow_delete_successfully')]);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('flow_delete_successfully'),
        ]);

        $this->dispatch('flow-bot-table-refresh');
    }

    public function editRedirect($flowId)
    {
        return redirect()->to(route('bot-flows.edit', [
            'id' => $flowId,
        ]));
    }

    public function editFlow($flowId)
    {
        $source = BotFlow::findOrFail($flowId);
        //$this->botFlow = $source;
        $this->botFlow = [
            'id' => $source->id,
            'name' => $source->name,
            'description' => $source->description,
        ];
        $this->resetValidation();
        $this->showFlowModal = true;
    }

    private function resetForm()
    {
        //$this->reset();
        $this->resetValidation();
        //$this->botFlow = new BotFlow;
        $this->botFlow = [
            'name' => '',
            'description' => '',
        ];
    }

    public function getRemainingLimitProperty()
    {
        //return $this->featureLimitChecker->getRemainingLimit('bot_flow', BotFlow::class);
    }

    public function getIsUnlimitedProperty()
    {
        //return $this->remainingLimit === null;
    }

    public function getHasReachedLimitProperty()
    {
        // /return $this->featureLimitChecker->hasReachedLimit('bot_flow', BotFlow::class);
    }

    public function getTotalLimitProperty()
    {
        //return $this->featureLimitChecker->getLimit('bot_flow');
    }

    public function render()
    {
        return view('bot-flow::livewire.flow-bot.flow-list')->layout('layouts.app-client');
    }
}
