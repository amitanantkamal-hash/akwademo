<x-action-section-custom>
    <x-slot name="content">
        <h3 class="fs-6 fw-bold mb-1">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                <input type="radio" class="btn-check" name="auth_option" value="apps" checked="checked"
                    id="kt_modal_two_factor_authentication_option_1">
                <label
                    class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                    for="kt_modal_two_factor_authentication_option_1">
                    <i class="ki-outline ki-setting-2 fs-4x me-4"></i>
                    <span class="d-block fw-semibold text-start">
                        <span class="text-gray-900 fw-bold d-block fs-3">Authenticator Apps</span>
                        <span class="text-muted fw-semibold fs-6">
                            Get codes from an app like Google Authenticator, Microsoft Authenticator, Authy or
                            1Password.
                        </span>
                    </span>
                </label>
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>

        <div class="fw-semibold text-gray-600">
            <p>
                {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="fw-semibold text-gray-600">
                        @if ($showingConfirmation)
                            {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                        @else
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 text-center">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}" />
                        <x-input id="code" type="text" name="code" inputmode="numeric" autofocus
                            autocomplete="one-time-code" wire:model.live="code"
                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />
                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm text-center bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5 d-flex flex-column justify-content-center">
            @if (!$this->enabled)
                <x-confirms-password-custom wire:then="enableTwoFactorAuthentication">
                    <x-button-custom type="button" wire:loading.attr="disabled">
                        {{ __('Enable') }}
                    </x-button-custom>
                </x-confirms-password-custom>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password-custom wire:then="regenerateRecoveryCodes">
                        <x-secondary-button-custom-100>
                            {{ __('Regenerate Recovery Codes') }}
                        </x-secondary-button-custom-100>
                    </x-confirms-password-custom>
                @elseif ($showingConfirmation)
                    <x-confirms-password-custom wire:then="confirmTwoFactorAuthentication">
                        <x-button-custom-100 type="button" class="mr-3" wire:loading.attr="disabled">
                            {{ __('Confirm') }}
                        </x-button-custom-100>
                    </x-confirms-password-custom>
                @else
                    <x-confirms-password-custom wire:then="showRecoveryCodes">
                        <x-secondary-button-custom-100>
                            {{ __('Show Recovery Codes') }}
                        </x-secondary-button-custom-100>
                    </x-confirms-password-custom>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password-custom wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button-custom-100 wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button-custom-100>
                    </x-confirms-password-custom>
                @else
                    <x-confirms-password-custom wire:then="disableTwoFactorAuthentication">
                        <x-danger-button-custom-100 wire:loading.attr="disabled">
                            {{ __('Disable') }}
                        </x-danger-button-custom-100>
                    </x-confirms-password-custom>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section-custom>
