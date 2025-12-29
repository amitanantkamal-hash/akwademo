<x-form-section-custom submit="updateProfileInformation">
    <x-slot name="form">
        <div class="row">
            <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New
                Email Address</label>
            <div class="fv-row fv-plugins-icon-container">
                <input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    wire:model.live="state.email">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="actions">
        <div class="d-flex">
            <button id="kt_signin_submit"class="btn btn-info  me-2 px-6" wire:loading.attr="disabled"
                wire:target="photo" type="submit">Update
                Email</button>
            <button id="kt_signin_cancel" type="button"
                class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
            <x-action-message class="m-3" on="saved">
                {{ __('Updated.') }}
            </x-action-message>
        </div>
    </x-slot>
</x-form-section-custom>
