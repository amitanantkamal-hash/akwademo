<form id="updatePasswordForm" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-4">
            <div class="fv-row mb-0">
                <label for="current_password" class="form-label fs-6 fw-bold mb-3">{{ __('Current Password') }}</label>
                <div class="position-relative mb-3">
                    <input id="current_password" name="current_password" type="password"
                        class="form-control form-control-lg form-control-solid" autocomplete="current-password">
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 password-toggle">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="invalid-feedback current_password_error"></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="fv-row mb-0">
                <label for="password" class="form-label fs-6 fw-bold mb-3">{{ __('New Password') }}</label>
                <div class="position-relative mb-3">
                    <input id="password" name="password" type="password"
                        class="form-control form-control-lg form-control-solid" autocomplete="new-password">
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 password-toggle">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="invalid-feedback password_error"></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="fv-row mb-0">
                <label for="password_confirmation"
                    class="form-label fs-6 fw-bold mb-3">{{ __('Confirm New Password') }}</label>
                <div class="position-relative mb-3">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="form-control form-control-lg form-control-solid" autocomplete="new-password">
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 password-toggle">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="invalid-feedback password_confirmation_error"></div>
            </div>
        </div>
        <div class="form-text mb-5">{{ __('Password must be at least 8 characters and contain symbols') }}</div>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-info me-2 px-6" id="submitBtn">{{ __('Update Password') }}</button>
        <button id="kt_password_cancel" type="button"
            class="btn btn-color-gray-500 btn-active-light-primary px-6">{{ __('Cancel') }}</button>
        <div id="successMessage" class="m-3 text-success" style="display:none;"></div>
    </div>
</form>

<script>
document.querySelectorAll('.password-toggle').forEach((toggle) => {
    toggle.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        const eyeSlash = this.querySelector('.bi-eye-slash');
        const eye = this.querySelector('.bi-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeSlash.classList.add('d-none');
            eye.classList.remove('d-none');
        } else {
            input.type = 'password';
            eyeSlash.classList.remove('d-none');
            eye.classList.add('d-none');
        }
    });
});
</script>