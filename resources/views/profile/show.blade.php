@extends('client.app')

@section('content')
    <div>
        <div id="kt_app_content_container" class="container-fluid ">
            <div class="col-12">
                @include('partials.flash-client')
            </div>
            <div class="card mb-6">
                @include('profile.components.card-header')
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="kt_tab_pane_1" role="tabpanel">
                    @include('profile.components.sub.tab1')
                </div>
            </div>
            {{-- @include('profile.components.card-body') --}}
            <div class="card-footer">
                @include('profile.components.card-footer')
            </div>
            {{-- Modals --}}
            <div class="modal fade" tabindex="-1" id="kt_modal_enable_factor">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h2 class="modal-title">{{ __('Two Factor Authentication') }}</h3>
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                        </div>
                        <div class="modal-body scroll-y pt-0">
                            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                @livewire('profile.two-factor-authentication-form')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="kt_modal_deactive_account">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h2 class="modal-title">{{ __('Deactivate Account') }}</h3>
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="ki-outline ki-cross fs-1"></i>
                                </div>
                        </div>
                        <div class="modal-body scroll-y pt-0">
                            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                @livewire('profile.delete-user-form')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('common.delete-script')
    @include('profile.components.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('updatePasswordForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;

                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                    el.style.display = 'none';
                });

                fetch("{{ route('frontend.password.update') }}", {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: new FormData(form)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Password updated successfully',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        if (error.errors) {
                            Object.keys(error.errors).forEach(key => {
                                const errorElement = document.querySelector(`.${key}_error`);
                                if (errorElement) {
                                    errorElement.textContent = error.errors[key][0];
                                    errorElement.style.display = 'block';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: error.message || 'An error occurred. Please try again.'
                            });
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                    });
            });
        });
    </script>
@endsection
