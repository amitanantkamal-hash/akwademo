<div>
    <x-slot:title>
        {{ __('bot_flow') }}
    </x-slot:title>

    <x-breadcrumb :items="[
            ['label' => __('dashboard'), 'route' => route('dashboard')],
            ['label' => __('bot_flow')],
        ]" />

    <div class="flex flex-col sm:flex-row gap-2 justify-between mb-4">
        <x-bot-flow::button.primary wire:click="createBotFlow" wire:loading.attr="disabled">
            <x-heroicon-m-plus class="w-4 h-4 mr-1" />{{ __('bot_flow') }}
        </x-bot-flow::button.primary>
    </div>

    <div class="mt-8 lg:mt-0">
        <livewire:bot-flow.tables.filament.flow-bot-filament-table />
    </div>

    <x-bot-flow::modal.custom-modal :id="'source-modal'" :maxWidth="'2xl'" wire:model.defer="showFlowModal">
        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-500/30 ">
            <h1 class="text-xl font-medium text-slate-800 dark:text-slate-300">
                {{ __('bot_flow') }}
            </h1>
        </div>
        <!-- Feature Limit Warning  -->

        <form wire:submit.prevent="save" class="mt-4">
            <div class="px-6 space-y-3">
                <div>
                    <div class="flex item-centar justify-start gap-1">
                        <span class="text-danger-500">*</span>
                        <x-label class="dark:text-gray-300 block text-sm font-medium text-gray-700">
                            {{ __('name') }}
                        </x-label>
                    </div>
                    <x-input wire:model.defer="botFlow.name" type="text" id="name" name="name" class="w-full" />
                    <x-input-error for="botFlow.name" class="mt-2" />
                </div>

                <div>
                    <div class="flex item-centar justify-start gap-1">
                        <x-label for="page.description"
                            class="dark:text-gray-300 block text-sm font-medium text-gray-700">
                            {{ __('description') }}
                        </x-label>
                    </div>
                    <x-bot-flow::textarea wire:model.defer="botFlow.description" name="description" rows="4"></x-bot-flow::textarea>
                    <x-input-error for="botFlow.description" class="mt-2" />
                </div>

            </div>

            <div
                class="py-4 flex justify-end space-x-3 border-t border-neutral-200 dark:border-neutral-500/30  mt-5 px-6">
                <x-bot-flow::button.secondary wire:click="$set('showFlowModal', false)">
                    {{ __('cancel') }}
                </x-bot-flow::button.secondary>
                <x-bot-flow::button.loading-button type="submit" target="save">
                    {{ __('submit') }}
                </x-bot-flow::button.loading-button>
            </div>
        </form>
    </x-bot-flow::modal.custom-modal>

    <!-- Delete Confirmation Modal -->
    <x-bot-flow::modal.confirm-box :maxWidth="'lg'" :id="'delete-source-modal'" title="{{ __('delete_bot_flow') }}"
        wire:model.defer="confirmingDeletion" description="{{ __('delete_message') }} ">
        <div
            class="border-neutral-200 border-neutral-500/30 flex justify-end items-center sm:block space-x-3 bg-gray-100 dark:bg-gray-700 ">
            <x-bot-flow::button.cancel-button wire:click="$set('confirmingDeletion', false)">
                {{ __('cancel') }}
            </x-bot-flow::button.cancel-button>
            <x-bot-flow::button.delete-button wire:click="delete" wire:loading.attr="disabled" class="mt-3 sm:mt-0">
                {{ __('delete') }}
            </x-bot-flow::button.delete-button>

        </div>
    </x-bot-flow::modal.confirm-box>


    <script>
        document.addEventListener('livewire:load', function() {
            window.addEventListener('notify', function(event) {
                Swal.fire({
                    icon: event.detail.type,
                    title: event.detail.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        });
    </script>
</div>