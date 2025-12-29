<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <label class="col-form-label required fw-semibold fs-6">Name</label>
        <div class="row">
            <div class="fv-row fv-plugins-icon-container">
                <input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                    wire:model.live="state.name">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
        </div>
        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
        <div class="row">
            <div class="fv-row fv-plugins-icon-container">
                <input type="text" name="fname"
                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" wire:model.live="state.email">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
        </div>
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">{{ __('Nombre completo') }}</label>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                            <input type="text" name="fname"
                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                placeholder="First name" value="Max">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                            <input type="text" name="lname" class="form-control form-control-lg form-control-solid"
                                placeholder="Last name" value="Smith">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model.live="photo" x-ref="photo"
                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                !$this->user->hasVerifiedEmail())
            <p class="text-sm mt-2">
                {{ __('Your email address is unverified.') }}

                <button type="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    wire:click.prevent="sendEmailVerification">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if ($this->verificationLinkSent)
                <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            @endif
        @endif

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
