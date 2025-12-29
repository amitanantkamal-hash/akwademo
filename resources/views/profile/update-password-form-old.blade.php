


<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>
    <x-slot name="form">
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Current Password') }}</label>
        <div class="row">
            <div class=" fv-row fv-plugins-icon-container">
                <input id="current_password" type="password"
                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    wire:model.live="state.current_password" autocomplete="current-password">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    <x-input-error for="current_password" class="mt-2" />
                </div>
            </div>
        </div>
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('New Password') }}</label>
        <div class="row">
            <div class=" fv-row fv-plugins-icon-container">
                <input id="password" type="password"
                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    wire:model.live="state.password" autocomplete="new-password">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    <x-input-error for="password" class="mt-2" />
                </div>
            </div>
        </div>
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Confirm Password') }}</label>
        <div class="row">
            <div class=" fv-row fv-plugins-icon-container">
                <input id="password_confirmation" type="password"
                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    wire:model.live="state.password_confirmation" autocomplete="new-password">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="actions">
        <div class="d-flex">
            <button wire:loading.attr="disabled" wire:target="photo" type="submit" class="btn btn-info"
                id="kt_account_profile_details_submit"> {{ __('Save') }}</button>
            <x-action-message class="m-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </x-slot>
</x-form-section>
