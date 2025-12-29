<?php

namespace Modules\BotFlow\Http\Livewire\Tables\Filament;

use Modules\BotFlow\Models\BotFlow;
//use App\Services\FeatureService;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class FlowBotFilamentTable extends BaseFilamentTable
{
    protected bool $hasBulkActions = false;

    protected ?string $defaultSortColumn = 'created_at';

    protected string $defaultSortDirection = 'desc';

    //protected FeatureService $featureLimitChecker;

    // public function boot(FeatureService $featureLimitChecker): void
    // {
    //     $this->featureLimitChecker = $featureLimitChecker;
    // }

    public function boot()
    {
        //
    }

    protected function getTableQuery(): Builder
    {
        $company_id = auth()->user()->company->id;

        return BotFlow::query()
            ->selectRaw('bot_flows.*, (SELECT COUNT(*) FROM bot_flows i2 WHERE i2.id <= bot_flows.id AND i2.company_id = ?) as row_num', [$company_id])
            ->where('company_id', $company_id);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('row_num')
                ->label(__('SR.NO'))
                ->sortable()
                ->toggleable(),

            TextColumn::make('name')
                ->label(__('name'))
                ->toggleable()
                ->searchable()
                ->sortable(),

            TextColumn::make('description')
                ->label('Description')
                ->toggleable()
                ->searchable()
                ->sortable()
                ->limit(100)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();

                    return strlen($state) > 100 ? $state : null;
                }),

            ToggleColumn::make('is_active')
                ->label(__('active'))
                ->toggleable()
                ->inline(false)
                ->extraAttributes(fn($record) => [
                    'style' => 'transform: scale(0.7); transform-origin: left center;',
                ])
                ->afterStateUpdated(function ($record, $state) {
                    // if (! checkPermission('bot_flow.edit')) {
                    //     return;
                    // }

                    $record->is_active = $state ? 1 : 0;
                    $record->save();

                    $statusMessage = __('status_updated_successfully');

                    $this->notify([
                        'message' => $statusMessage,
                        'type' => 'success',
                    ]);
                }),

        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('flow')
                ->label(__('flow'))
                ->extraAttributes([
                    'class' => 'inline-flex items-center gap-2 px-3 py-1 text-sm font-medium text-white bg-success-600  shadow-sm hover:bg-success-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success-600 justify-center',
                ])
                ->action(fn(BotFlow $record) => $this->dispatch('editRedirect', flowId: $record->id)),

            Action::make('edit')
                ->label(__('edit'))
                ->extraAttributes([
                    'class' => 'inline-flex items-center gap-2 px-3 py-1 text-sm font-medium text-white bg-primary-600  shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 justify-center',
                ])
                ->action(fn(BotFlow $record) => $this->dispatch('editFlow', flowId: $record->id)),

            Action::make('delete')
                ->label(__('delete'))
                ->extraAttributes([
                    'class' => 'inline-flex items-center gap-2 px-3 py-1 text-sm font-medium text-white bg-danger-600  shadow-sm hover:bg-danger-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger-600 justify-center',
                ])
                ->extraAttributes([
                    'class' => 'inline-flex items-center gap-2 px-3 py-1 text-sm font-medium text-white bg-danger-600  shadow-sm hover:bg-danger-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger-600 justify-center',
                ])
                ->action(fn(BotFlow $record) => $this->dispatch('confirmDelete', flowId: $record->id)),

        ];
    }

    #[On('edit')]
    public function edit($rowId): void
    {
        $this->redirect(route('bot_flows.edit', ['id' => $rowId]));
    }

    #[On('flow-bot-table-refresh')]
    public function refresh(): void
    {
        $this->resetTable();
    }
}
