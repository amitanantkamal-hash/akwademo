@extends('layouts.app', ['title' => __('Embedded SignUp Whatsapp Setup')])
@section('content')
    <div class="header pb-8 pt-2 pt-md-7">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3">💬 {{ __('Embedded SignUp Whatsapp Setup') }}</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-12">
                @include('partials.flash')
            </div>

            {{-- WhatsApp Setup Card --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow max-height-vh-70 overflow-auto overflow-x-hidden">
                    <div class="card-header shadow-lg">
                        <b>{{ __('Step 1: WhatsApp Webhook Setup') }}</b>
                    </div>
                    <div class="card-body">
                        <p>
                            First, set up the Webhooks product for your app:
                        </p>
                        <ol>
                            <li>Load your app in the <a target="_blank" href="https://developers.facebook.com/apps">App
                                    Dashboard</a> and add the Webhooks product if you have not already added it.</li>
                            <li>Click the Webhooks product in the menu on the left.</li>
                            <li>Select WhatsApp Business Account from the drop-down menu and then click Subscribe to this
                                object.</li>
                            <li>Add your Webhooks callback URL and verification token, verify, and save your changes.</li>
                        </ol>

                        <div class="mb-3">
                            <b>{{ __('WhatsApp Callback URL') }}</b>
                            <div class="d-flex align-items-center mt-1">
                                <code id="wpboxUrl" class="mr-2 text-success font-weight-bold">
                                    {{ rtrim(config('app.url'), '/') }}/webhook/wpbox/receive/{{ $token }}
                                </code>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="copyToClipboard('wpboxUrl')">Copy</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <b>{{ __('WhatsApp Verify Token') }}</b><br>
                            <code id="token" class="text-success font-weight-bold">{{ $token }}</code>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="copyToClipboard('token')">Copy</button>
                        </div>


                        <p>5. {{ __('Click on Webhook fields -> Manage and select the Messages') }}</p>

                    </div>
                </div>
            </div>

            {{-- Facebook Setup Card --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow max-height-vh-70 overflow-auto overflow-x-hidden">
                    <div class="card-header shadow-lg">
                        <b>{{ __('Step 2: Facebook Webhook Setup for Leads Sync') }}</b>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <b>{{ __('Facebook Callback URL') }}</b>
                            <div class="d-flex align-items-center mt-1">
                                <code id="facebookUrl" class="mr-2 text-primary font-weight-bold">
                                    {{ rtrim(config('app.url'), '/') }}/webhooks/meta/lead
                                </code>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="copyToClipboard('facebookUrl')">Copy</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <b>{{ __('Facebook Verify Token') }}</b><br>
                            <code id="fbtoken" class="text-primary font-weight-bold">{{ $token }}</code>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="copyToClipboard('fbtoken')">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyToClipboard(id) {
            const el = document.getElementById(id);
            const text = el.innerText;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                // Modern approach
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Copied to clipboard!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }).catch(err => {
                    showErrorToast();
                });
            } else {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Copied to clipboard!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } catch (err) {
                    showErrorToast();
                }
                document.body.removeChild(textarea);
            }

            function showErrorToast() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Failed to copy!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        }
    </script>
@endsection
