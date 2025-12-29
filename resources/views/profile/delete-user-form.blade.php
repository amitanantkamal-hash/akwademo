<x-action-section-custom>
    <x-slot name="content">

        <div class="card-body border-top p-9">
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                <i class="ki-outline ki-information fs-2tx text-warning me-4"></i> <!--end::Icon-->
                <div class="d-flex flex-stack flex-grow-1 ">
                    <div class=" fw-semibold">
                        <h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>
                        <div class="fs-6 text-gray-700 ">For extra security, this requires you to confirm your
                            password. <br><a class="fw-bold" href="#">Learn more</a></div>
                    </div>
                </div>
            </div>
            <div class="max-w-xl fw-semibold text-gray-600 mt-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </div>
        
            <div class="mt-4 d-flex justify-content-end">
                <x-danger-button-custom-padding wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
                </x-danger-button-custom-padding>
            </div>

            <!-- Delete User Confirmation Modal -->
            <x-dialog-modal-custom wire:model.live="confirmingUserDeletion">
                <x-slot name="title">
                    {{ __('Delete Account') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                    <div class="mt-4" x-data="{}"
                        x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-input type="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                            wire:model.live="password" wire:keydown.enter="deleteUser" />

                        <x-input-error for="password" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button-custom wire:click="$toggle('confirmingUserDeletion')"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button-custom>

                    <x-danger-button-custom class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                        {{ __('Delete Account Definitely') }}
                    </x-danger-button-custom>
                </x-slot>
            </x-dialog-modal-custom>
        </div>
    </x-slot>
</x-action-section-custom>
