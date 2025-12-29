<x-action-section-custom>
    <x-slot name="content">
        <div class="card-body border-top p-0">
            <div class="max-w-xl fw-semibold text-gray-600 p-8">
                {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
            </div>
            <div class="table-responsive m-0">
                <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9 border-top">
                    <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                        <tr>
                            <th class="min-w-150px">Device</th>
                            <th class="min-w-150px text-center">IP Address</th>
                            <th class="min-w-150px text-center">Last Active</th>
                        </tr>
                    </thead>
                    <tbody class="fw-6 fw-semibold text-gray-600">
                        @if (count($this->sessions) > 0)
                            @foreach ($this->sessions as $session)
                                <tr class="border-0">
                                    <td class="d-flex align-items-center flex-row text-center border-0">
                                        <div class="h-20px w-20px me-2">
                                            @if ($session->agent->isDesktop())
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-8 h-8 text-gray-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-8 h-8 text-gray-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                </svg>
                                            @endif
                                        </div>
                                        {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }}
                                        -
                                        {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                    </td>
                                    <td class="text-center">{{ $session->ip_address }}</td>
                                    <td class="text-center">
                                        @if ($session->is_current_device)

                                        <span class="badge badge-light-info fs-7 fw-bold">
                                            {{ __('This device') }}
                                        </span>
                                        @else
                                        <span class="badge badge-light-success fs-7 fw-bold">
                                            {{ __('Last active') }} {{ $session->last_active }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer pt-2">
            {{-- @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <div class="h-100px w-100px">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                    </svg>
                                </div>
                            @else
                                <div class="h-100px w-100px">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="ml-3">
                            <div class="text-sm text-gray-600">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} -
                                {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif --}}
            <div class="flex items-center mt-5">
                <x-button-custom wire:click="confirmLogout" wire:loading.attr="disabled">
                    {{ __('Log Out Other Browser Sessions') }}
                </x-button-custom>

                <x-action-message class="ml-3" on="loggedOut">
                    {{ __('Done.') }}
                </x-action-message>
            </div>

            <!-- Log Out Other Devices Confirmation Modal -->
            <x-dialog-modal-custom wire:model.live="confirmingLogout">
                <x-slot name="title">
                    {{ __('Log Out Other Browser Sessions') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                    <div class="mt-4" x-data="{}"
                        x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-input type="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                            autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                            wire:model.live="password" wire:keydown.enter="logoutOtherBrowserSessions" />

                        <x-input-error for="password" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button-custom wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button-custom>

                    <x-button-custom class="ml-3" wire:click="logoutOtherBrowserSessions"
                        wire:loading.attr="disabled">
                        {{ __('Log Out Other Browser Sessions') }}
                    </x-button-custom>
                </x-slot>
            </x-dialog-modal-custom>
        </div>
    </x-slot>
</x-action-section-custom>
