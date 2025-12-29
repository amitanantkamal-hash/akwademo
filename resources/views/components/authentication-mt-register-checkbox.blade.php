<div class="fv-row mb-4">
    <label class="form-check form-check-inline form-check-sm">
        <input class="form-check-input" type="checkbox" name="toc" value="1"/>
        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="ms-1 link-primary">'.__('Terms of Service').'</a>',
                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="ms-1 link-primary"">'.__('Privacy Policy').'</a>',
        ]) !!}
        </span>
    </label>
</div>
