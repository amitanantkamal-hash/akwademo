<form id="updatePasswordForm" method="POST" action="/update-password">
    <div class="row">
        <div class="col-lg-4">
            <div class="mb-3">
                <label for="current_password" class="form-label fs-6 fw-bold">Current Password</label>
                <input id="current_password" type="password" class="form-control form-control-lg form-control-solid" required>
                <div class="invalid-feedback" id="currentPasswordError"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label for="password" class="form-label fs-6 fw-bold">New Password</label>
                <input id="password" type="password" class="form-control form-control-lg form-control-solid" required>
                <div class="invalid-feedback" id="newPasswordError"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fs-6 fw-bold">Confirm New Password</label>
                <input id="password_confirmation" type="password" class="form-control form-control-lg form-control-solid" required>
                <div class="invalid-feedback" id="confirmPasswordError"></div>
            </div>
        </div>
    </div>
    <div class="form-text mb-5">Password must be at least 8 characters and contain symbols.</div>
    <div class="d-flex">
        <button type="submit" class="btn btn-info me-2">Update Password</button>
        <button  id="kt_password_cancel" type="button" class="btn btn-color-gray-500" onclick="cancelUpdate()">Cancel</button>
    </div>
</form>
