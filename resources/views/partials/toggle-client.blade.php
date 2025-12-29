<div class="form-group{{ $errors->has($id) ? ' has-danger' : '' }} d-flex flex-stack">
    <div class="d-flex">
        <label class="fs-6 fw-semibold form-label mt-3" for="{{ $id }}">{{ __($name) }}</label>
    </div>

    <div class="d-flex justify-content-end">
        <!--begin::Switch-->
        <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox"  name="{{ $id }}" id="{{ $id }}" <?php if($checked){echo "checked";}?>>
            <span class="form-check-label fw-semibold text-muted" @isset($dlo)  data-label-off="{{ __($dlo) }}" @endisset   @isset($dloff)  data-label-off="{{ __($dloff) }}" @endisset @isset($dlon) data-label-on="{{ __($dlon) }}"  @endisset  ></span>
        </label>
        <!--end::Switch-->
    </div>

    @isset($additionalInfo)
        <br /><small class="text-muted"><strong>{{ __($additionalInfo) }}</strong></small>
    @endisset
    @if ($errors->has($id))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($id) }}</strong>
        </span>
    @endif
</div>
