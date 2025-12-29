@extends('layouts.app-client')

@section('title', __('Create New Agent'))

@section('content')
    <div class="container-xxl">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-7">
            <div class="d-flex align-items-center">
                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                    <i class="ki-duotone ki-profile-user fs-2hx me-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    {{ __('Create New Agent') }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('agent.index') }}" class="btn btn-primary">
                    <i class="ki-duotone ki-arrow-left fs-2"></i>
                    {{ __('Back to Agents') }}
                </a>
            </div>
        </div>

        <!-- Create Agent Form -->
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Agent Information') }}</h3>
                        <div class="card-toolbar">
                            <span
                                class="badge badge-light-primary fs-8">{{ __('Required fields are marked with *') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('agent.store') }}" method="POST" id="create-agent-form">
                        @csrf

                        <div class="card-body">
                            <!-- Personal Information Section -->
                            <div class="mb-10">
                                <h4 class="text-dark fw-bolder mb-6">
                                    <i class="ki-duotone ki-user fs-2 text-primary me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('Personal Information') }}
                                </h4>

                                <div class="row g-5">
                                    <!-- Full Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label required">
                                            {{ __('Full Name') }}
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-solid @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="{{ __('Enter agent full name') }}" required autocomplete="name"
                                            autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('Enter the agent\'s first and last name') }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="col-md-6">
                                        <label for="mobile" class="form-label">
                                            {{ __('Mobile Number') }}
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">+</span>
                                            <input type="tel"
                                                class="form-control form-control-solid @error('mobile') is-invalid @enderror"
                                                id="mobile" name="mobile" value="{{ old('mobile') }}"
                                                placeholder="{{ __('1234567890') }}" autocomplete="tel">
                                        </div>
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('Optional: Include country code if international') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div class="mb-10">
                                <h4 class="text-dark fw-bolder mb-6">
                                    <i class="ki-duotone ki-sms fs-2 text-primary me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('Account Information') }}
                                </h4>

                                <div class="row g-5">
                                    <!-- Email Address -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label required">
                                            {{ __('Email Address') }}
                                        </label>
                                        <input type="email"
                                            class="form-control form-control-solid @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="{{ __('agent@company.com') }}" required autocomplete="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('This will be used for login and notifications') }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label required">
                                            {{ __('Password') }}
                                        </label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control form-control-solid @error('password') is-invalid @enderror"
                                                id="password" name="password"
                                                placeholder="{{ __('Enter secure password') }}" required
                                                autocomplete="new-password">
                                            <button type="button"
                                                class="btn btn-icon btn-sm btn-transparent btn-active-light-primary position-absolute top-50 end-0 translate-middle-y me-3 toggle-password"
                                                data-target="password">
                                                <i class="ki-duotone ki-eye fs-2 toggle-icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('Minimum 6 characters') }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="row g-5 mt-2">
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label required">
                                            {{ __('Confirm Password') }}
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control form-control-solid"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="{{ __('Confirm your password') }}" required
                                                autocomplete="new-password">
                                            <button type="button"
                                                class="btn btn-icon btn-sm btn-transparent btn-active-light-primary position-absolute top-50 end-0 translate-middle-y me-3 toggle-password"
                                                data-target="password_confirmation">
                                                <i class="ki-duotone ki-eye fs-2 toggle-icon"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">{{ __('Re-enter the password for verification') }}</div>
                                    </div>

                                    <!-- Password Strength Meter -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Password Strength') }}</label>
                                        <div class="password-strength-meter">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="progress w-100 me-3" style="height: 6px;">
                                                    <div class="progress-bar bg-danger" id="password-strength-bar"
                                                        style="width: 0%"></div>
                                                </div>
                                                <span class="text-muted fs-7" id="password-strength-text">Weak</span>
                                            </div>
                                            <div class="password-requirements">
                                                <small class="text-muted d-block" id="length-check">
                                                    <i class="ki-duotone ki-cross fs-5 text-danger me-1"></i>
                                                    {{ __('At least 6 characters') }}
                                                </small>
                                                <small class="text-muted d-block" id="complexity-check">
                                                    <i class="ki-duotone ki-cross fs-5 text-danger me-1"></i>
                                                    {{ __('Letters, numbers, and symbols') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Agent Permissions Section -->
                            <div class="mb-5">
                                <h4 class="text-dark fw-bolder mb-6">
                                    <i class="ki-duotone ki-shield-tick fs-2 text-primary me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('Agent Permissions') }}
                                </h4>

                                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-information fs-2hx text-primary me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="flex-grow-1">
                                            <h5 class="text-primary">{{ __('Default Permissions') }}</h5>
                                            <p class="text-gray-700">
                                                {{ __('This agent will be assigned the "Staff" role with standard permissions to manage customer conversations and handle support tickets.') }}
                                            </p>
                                            <a href="#"
                                                class="btn btn-sm btn-light-primary">{{ __('View Role Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('agent.index') }}" class="btn btn-light">
                                    <i class="ki-duotone ki-arrow-left fs-2"></i>
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                            <div class="d-flex gap-3">
                                {{-- <button type="button" class="btn btn-light-primary" onclick="resetForm()">
                                    <i class="ki-duotone ki-reset fs-2"></i>
                                    {{ __('Reset Form') }}
                                </button> --}}
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="ki-duotone ki-check fs-2"></i>
                                    {{ __('Create Agent') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Help Section -->
            <div class="col-xl-4">
                <!-- Quick Tips -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Quick Tips') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <i class="ki-duotone ki-security-user fs-2hx text-success me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Strong Passwords') }}</span>
                                <p class="text-muted fs-7 mb-0">{{ __('Use a mix of letters, numbers, and symbols') }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-5">
                            <i class="ki-duotone ki-sms fs-2hx text-info me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Email Verification') }}</span>
                                <p class="text-muted fs-7 mb-0">
                                    {{ __('Agent will receive welcome email with instructions') }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-notification-status fs-2hx text-warning me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Mobile Notifications') }}</span>
                                <p class="text-muted fs-7 mb-0">{{ __('Optional for SMS alerts and 2FA') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Agents -->
                @if ($recentAgents && $recentAgents->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Recently Added Agents') }}</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($recentAgents as $recentAgent)
                                <div class="d-flex align-items-center mb-4">
                                    <div class="symbol symbol-40px symbol-circle me-4">
                                        <div class="symbol-label bg-light-success">
                                            <span
                                                class="fs-6 text-success fw-bolder">{{ substr($recentAgent->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span
                                            class="text-gray-800 fw-semibold fs-6 d-block">{{ $recentAgent->name }}</span>
                                        <span class="text-muted fs-7">{{ $recentAgent->email }}</span>
                                    </div>
                                    <span class="badge badge-light-success">{{ __('Active') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('create-agent-form');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const lengthCheck = document.getElementById('length-check');
            const complexityCheck = document.getElementById('complexity-check');
            const submitBtn = document.getElementById('submit-btn');

            // Password visibility toggle
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('.toggle-icon');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('ki-eye');
                        icon.classList.add('ki-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('ki-eye-slash');
                        icon.classList.add('ki-eye');
                    }
                });
            });

            // Password strength checker
            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                validatePasswordMatch();
            });

            confirmPasswordInput.addEventListener('input', validatePasswordMatch);

            function checkPasswordStrength(password) {
                let strength = 0;
                const requirements = {
                    length: password.length >= 6,
                    lower: /[a-z]/.test(password),
                    upper: /[A-Z]/.test(password),
                    numbers: /\d/.test(password),
                    symbols: /[!@#$%^&*(),.?":{}|<>]/.test(password)
                };

                // Update requirements display
                updateRequirementIcon(lengthCheck, requirements.length);
                updateRequirementIcon(complexityCheck,
                    (requirements.lower || requirements.upper) && requirements.numbers);

                // Calculate strength
                if (requirements.length) strength += 25;
                if (requirements.lower && requirements.upper) strength += 25;
                if (requirements.numbers) strength += 25;
                if (requirements.symbols) strength += 25;

                // Update strength meter
                strengthBar.style.width = strength + '%';

                // Update strength text and color
                if (strength === 0) {
                    strengthBar.className = 'progress-bar bg-danger';
                    strengthText.textContent = 'Weak';
                    strengthText.className = 'text-muted fs-7';
                } else if (strength <= 50) {
                    strengthBar.className = 'progress-bar bg-warning';
                    strengthText.textContent = 'Fair';
                    strengthText.className = 'text-warning fs-7 fw-bold';
                } else if (strength <= 75) {
                    strengthBar.className = 'progress-bar bg-info';
                    strengthText.textContent = 'Good';
                    strengthText.className = 'text-info fs-7 fw-bold';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    strengthText.textContent = 'Strong';
                    strengthText.className = 'text-success fs-7 fw-bold';
                }
            }

            function updateRequirementIcon(element, meetsRequirement) {
                const icon = element.querySelector('i');
                if (meetsRequirement) {
                    icon.className = 'ki-duotone ki-check fs-5 text-success me-1';
                } else {
                    icon.className = 'ki-duotone ki-cross fs-5 text-danger me-1';
                }
            }

            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword && password !== confirmPassword) {
                    confirmPasswordInput.classList.add('is-invalid');
                    confirmPasswordInput.classList.remove('is-valid');
                } else if (confirmPassword) {
                    confirmPasswordInput.classList.remove('is-invalid');
                    confirmPasswordInput.classList.add('is-valid');
                } else {
                    confirmPasswordInput.classList.remove('is-invalid', 'is-valid');
                }
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Basic validation
                if (password.length < 6) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ __('Password Too Short') }}',
                        text: '{{ __('Password must be at least 6 characters long.') }}',
                        icon: 'error',
                        confirmButtonText: '{{ __('OK') }}'
                    });
                    return;
                }

                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ __("Passwords Don't Match") }}',
                        text: '{{ __('Please make sure both passwords match.') }}',
                        icon: 'error',
                        confirmButtonText: '{{ __('OK') }}'
                    });
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
            {{ __('Creating Agent...') }}
        `;
            });

            // Mobile number formatting
            const mobileInput = document.getElementById('mobile');
            if (mobileInput) {
                mobileInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 15) {
                        value = value.substring(0, 15);
                    }
                    e.target.value = value;
                });
            }
        });

        function resetForm() {
            if (confirm('{{ __('Are you sure you want to reset the form? All entered data will be lost.') }}')) {
                document.getElementById('create-agent-form').reset();
                document.getElementById('password-strength-bar').style.width = '0%';
                document.getElementById('password-strength-text').textContent = 'Weak';
                document.getElementById('password-strength-text').className = 'text-muted fs-7';

                // Reset requirement icons
                document.querySelectorAll('.password-requirements i').forEach(icon => {
                    icon.className = 'ki-duotone ki-cross fs-5 text-danger me-1';
                });

                // Remove validation classes
                document.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                    el.classList.remove('is-invalid', 'is-valid');
                });
            }
        }
    </script>
@endpush

@push('css')
    <style>
        .required:after {
            content: " *";
            color: #f1416c;
        }

        .form-control-solid {
            background-color: #fafafa;
            border-color: #e4e6ef;
            transition: all 0.3s ease;
        }

        .form-control-solid:focus {
            background-color: #ffffff;
            border-color: #3699ff;
            box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.1);
        }

        .password-strength-meter .progress {
            background-color: #e4e6ef;
        }

        .toggle-password {
            border: none;
            background: transparent;
            outline: none;
        }

        .toggle-password:hover {
            background-color: rgba(54, 153, 255, 0.1);
        }

        .notice {
            border-left: 4px solid #3699ff;
        }

        .symbol.symbol-circle .symbol-label {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991px) {

            .col-xl-8,
            .col-xl-4 {
                max-width: 100%;
                flex: 0 0 100%;
            }

            .col-xl-4 {
                margin-top: 2rem;
            }
        }
    </style>
@endpush
