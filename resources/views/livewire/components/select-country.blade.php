<select id="kt_ecommerce_select2_country" class="form-select form-select-solid" name="country_id" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a country">
    @foreach ($countries as $country)
    <option value="{{ $country->id }}">{{ $country->name }}</option>
    @endforeach
</select>
