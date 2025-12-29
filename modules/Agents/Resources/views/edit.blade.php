@extends('layouts.app-client')

@section('title', __('Edit Agent'))

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
                    {{ __('Edit Agent') }}
                </h1>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('agent.index') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2"></i>
                    {{ __('Back to Agents') }}
                </a>
            </div>
        </div>

        <!-- Edit Agent Form -->
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Edit Agent Information') }}</h3>
                        <div class="card-toolbar">
                            <span class="badge badge-light-primary fs-8">{{ __('Required fields are marked with *') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('agent.update', ['agent' => $agent->id]) }}" method="POST" id="edit-agent-form">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

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
                                            id="name" name="name" 
                                            value="{{ old('name', $agent->name) }}"
                                            placeholder="{{ __('Enter agent full name') }}" 
                                            required 
                                            autocomplete="name"
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
                                                id="mobile" name="mobile" 
                                                value="{{ old('mobile', ltrim($agent->phone, '+')) }}"
                                                placeholder="{{ __('1234567890') }}" 
                                                autocomplete="tel">
                                        </div>
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('Optional: Include country code if international') }}</div>
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
                                            id="email" name="email" 
                                            value="{{ old('email', $agent->email) }}"
                                            placeholder="{{ __('agent@company.com') }}" 
                                            required 
                                            autocomplete="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @else
                                            <div class="form-text">{{ __('This will be used for login and notifications') }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status Toggle -->
                                    {{-- <div class="col-md-6">
                                        <label class="form-label">{{ __('Account Status') }}</label>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="is_active" 
                                                       id="is_active" 
                                                       value="1"
                                                       {{ old('is_active', $agent->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    {{ $agent->is_active ? __('Active') : __('Inactive') }}
                                                </label>
                                            </div>
                                            <span class="badge badge-light-{{ $agent->is_active ? 'success' : 'danger' }}" id="status-badge">
                                                {{ $agent->is_active ? __('Active') : __('Inactive') }}
                                            </span>
                                        </div>
                                        <div class="form-text">{{ __('Toggle to activate or deactivate this agent account') }}</div>
                                    </div> --}}
                                </div>

                                <!-- Password Section -->
                                <div class="row g-5 mt-5">
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="ki-duotone ki-information fs-2hx text-info me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <div class="flex-grow-1">
                                                <h5 class="text-info">{{ __('Password Update') }}</h5>
                                                <p class="mb-0">{{ __('Leave password fields blank if you don\'t want to change the password.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-5 mt-2">
                                    <!-- New Password -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">
                                            {{ __('New Password') }}
                                        </label>
                                        <div class="position-relative">
                                            <input type="password"
                                                class="form-control form-control-solid @error('password') is-invalid @enderror"
                                                id="password" 
                                                name="password"
                                                placeholder="{{ __('Enter new password') }}"
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

                                    <!-- Confirm New Password -->
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">
                                            {{ __('Confirm New Password') }}
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   class="form-control form-control-solid"
                                                   id="password_confirmation" 
                                                   name="password_confirmation"
                                                   placeholder="{{ __('Confirm new password') }}"
                                                   autocomplete="new-password">
                                            <button type="button"
                                                class="btn btn-icon btn-sm btn-transparent btn-active-light-primary position-absolute top-50 end-0 translate-middle-y me-3 toggle-password"
                                                data-target="password_confirmation">
                                                <i class="ki-duotone ki-eye fs-2 toggle-icon"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">{{ __('Re-enter the new password for verification') }}</div>
                                    </div>
                                </div>

                                <!-- Password Strength Meter (Only show when typing) -->
                                <div class="row g-5 mt-2 d-none" id="password-strength-section">
                                    <div class="col-md-6"></div>
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

                            <!-- Agent Information Section -->
                            <div class="mb-5">
                                <h4 class="text-dark fw-bolder mb-6">
                                    <i class="ki-duotone ki-information fs-2 text-primary me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('Agent Details') }}
                                </h4>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="bg-light rounded p-4">
                                            <h6 class="text-muted mb-3">{{ __('Account Information') }}</h6>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">{{ __('Agent ID:') }}</span>
                                                    <span class="fw-bold">{{ $agent->id }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">{{ __('Created:') }}</span>
                                                    <span class="fw-bold">{{ $agent->created_at->format('M j, Y') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">{{ __('Last Updated:') }}</span>
                                                    <span class="fw-bold">{{ $agent->updated_at->format('M j, Y') }}</span>
                                                </div>
                                                @if($agent->last_logged_in_on)
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">{{ __('Last Login:') }}</span>
                                                    <span class="fw-bold">{{ $agent->last_logged_in_on->format('M j, Y g:i A') }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-light rounded p-4">
                                            <h6 class="text-muted mb-3">{{ __('Current Permissions') }}</h6>
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="ki-duotone ki-shield-tick fs-2 text-success me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div>
                                                    <div class="fw-bold">{{ __('Staff Role') }}</div>
                                                    <small class="text-muted">{{ __('Standard agent permissions') }}</small>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-light-primary">
                                                <i class="ki-duotone ki-setting fs-2 me-2"></i>
                                                {{ __('Manage Permissions') }}
                                            </a>
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
                                    {{ __('Reset Changes') }}
                                </button> --}}
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="ki-duotone ki-check fs-2"></i>
                                    {{ __('Update Agent') }}
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
                        <h4 class="card-title">{{ __('Editing Tips') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <i class="ki-duotone ki-security-user fs-2hx text-success me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Password Update') }}</span>
                                <p class="text-muted fs-7 mb-0">{{ __('Leave blank to keep current password') }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-5">
                            <i class="ki-duotone ki-sms fs-2hx text-info me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Status Management') }}</span>
                                <p class="text-muted fs-7 mb-0">{{ __('Deactivate to temporarily disable access') }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ki-duotone ki-notification-status fs-2hx text-warning me-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6">{{ __('Mobile Updates') }}</span>
                                <p class="text-muted fs-7 mb-0">{{ __('Update contact info for notifications') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Agent Activity') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px symbol-circle me-4">
                                <div class="symbol-label bg-light-{{ $agent->is_active ? 'success' : 'danger' }}">
                                    <span class="fs-6 text-{{ $agent->is_active ? 'success' : 'danger' }} fw-bolder">{{ substr($agent->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="text-gray-800 fw-semibold fs-6 d-block">{{ $agent->name }}</span>
                                <span class="text-muted fs-7">{{ $agent->email }}</span>
                            </div>
                            <span class="badge badge-light-{{ $agent->is_active ? 'success' : 'danger' }}">{{ $agent->is_active ? __('Active') : __('Inactive') }}</span>
                        </div>
                        
                        <div class="separator separator-dashed my-4"></div>
                        
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-2 text-primary me-3"></i>
                                <div class="flex-grow-1">
                                    <span class="text-muted fs-7">{{ __('Member since') }}</span>
                                    <div class="fw-bold fs-6">{{ $agent->created_at->format('M j, Y') }}</div>
                                </div>
                            </div>
                            
                            @if($agent->last_logged_in_on)
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-clock fs-2 text-success me-3"></i>
                                <div class="flex-grow-1">
                                    <span class="text-muted fs-7">{{ __('Last login') }}</span>
                                    <div class="fw-bold fs-6">{{ $agent->last_logged_in_on->diffForHumans() }}</div>
                                </div>
                            </div>
                            @else
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-cross-circle fs-2 text-danger me-3"></i>
                                <div class="flex-grow-1">
                                    <span class="text-muted fs-7">{{ __('Last login') }}</span>
                                    <div class="fw-bold fs-6">{{ __('Never logged in') }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Agents (Optional) -->
                {{-- @if(isset($recentAgents) && $recentAgents->count() > 0)
                    <div class="card mt-6">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Other Agents') }}</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($recentAgents as $recentAgent)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-35px symbol-circle me-3">
                                        <div class="symbol-label bg-light-primary">
                                            <span class="fs-7 text-primary fw-bolder">{{ substr($recentAgent->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-gray-800 fw-semibold fs-7 d-block">{{ $recentAgent->name }}</span>
                                        <span class="text-muted fs-8">{{ $recentAgent->email }}</span>
                                    </div>
                                    <span class="badge badge-light-{{ $recentAgent->is_active ? 'success' : 'danger' }} fs-8">
                                        {{ $recentAgent->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edit-agent-form');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const lengthCheck = document.getElementById('length-check');
            const complexityCheck = document.getElementById('complexity-check');
            const passwordStrengthSection = document.getElementById('password-strength-section');
            const submitBtn = document.getElementById('submit-btn');
            const statusToggle = document.getElementById('is_active');
            const statusLabel = statusToggle.nextElementSibling;
            const statusBadge = document.getElementById('status-badge');

            // Update status label when toggle changes
            statusToggle.addEventListener('change', function() {
                if (this.checked) {
                    statusLabel.textContent = '{{ __("Active") }}';
                    statusBadge.className = 'badge badge-light-success';
                    statusBadge.textContent = '{{ __("Active") }}';
                } else {
                    statusLabel.textContent = '{{ __("Inactive") }}';
                    statusBadge.className = 'badge badge-light-danger';
                    statusBadge.textContent = '{{ __("Inactive") }}';
                }
            });

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

            // Password strength checker (only when password field has value)
            passwordInput.addEventListener('input', function() {
                if (this.value.length > 0) {
                    passwordStrengthSection.classList.remove('d-none');
                    checkPasswordStrength(this.value);
                    validatePasswordMatch();
                } else {
                    passwordStrengthSection.classList.add('d-none');
                    validatePasswordMatch();
                }
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
                } else if (confirmPassword && password === confirmPassword) {
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

                // Only validate password if it's being changed
                if (password.length > 0) {
                    if (password.length < 6) {
                        e.preventDefault();
                        Swal.fire({
                            title: '{{ __("Password Too Short") }}',
                            text: '{{ __("Password must be at least 6 characters long.") }}',
                            icon: 'error',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                        return;
                    }

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        Swal.fire({
                            title: '{{ __("Passwords Don\'t Match") }}',
                            text: '{{ __("Please make sure both passwords match.") }}',
                            icon: 'error',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                        return;
                    }
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    {{ __("Updating Agent...") }}
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
            if (confirm('{{ __("Are you sure you want to reset all changes?") }}')) {
                // Reload the page to reset form to original values
                location.reload();
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

        .form-check-input:checked {
            background-color: #50cd89;
            border-color: #50cd89;
        }

        .separator.separator-dashed {
            border-top: 1px dashed #e4e6ef;
        }

        .alert {
            border: none;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: #50cd89;
            background-color: #f8fff8;
        }

        .alert-danger {
            border-left-color: #f1416c;
            background-color: #fff5f8;
        }

        .alert-info {
            border-left-color: #3699ff;
            background-color: #f8faff;
        }

        @media (max-width: 991px) {
            .col-xl-8, .col-xl-4 {
                max-width: 100%;
                flex: 0 0 100%;
            }
            
            .col-xl-4 {
                margin-top: 2rem;
            }
        }
    </style>
@endpush