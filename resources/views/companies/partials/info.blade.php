<div class="pl-lg-4">
    <form id="company-form" method="post" action="{{ route('admin.companies.update', $company) }}" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" id="rid" value="{{ $company->id }}" />
                @include('partials.fields', [
                    'fields' => [
                        [
                            'ftype' => 'input',
                            'name' => 'Organization Name',
                            'id' => 'name',
                            'placeholder' => 'Name',
                            'required' => true,
                            'value' => $company->name,
                        ],
                        [
                            'ftype' => 'input',
                            'name' => 'Description',
                            'id' => 'description',
                            'placeholder' => 'Description',
                            'required' => true,
                            'value' => $company->description,
                        ],
                        [
                            'ftype' => 'input',
                            'name' => 'Address',
                            'id' => 'address',
                            'placeholder' => 'Address',
                            'required' => true,
                            'value' => $company->address,
                        ],
                        [
                            'ftype' => 'input',
                            'name' => 'WhatsApp number',
                            'id' => 'phone',
                            'placeholder' => 'WhatsApp number',
                            'required' => true,
                            'value' => $company->phone,
                        ],
                    ],
                ])

                @if (auth()->user()->hasRole('admin'))
                    <br />
                    <div class="form-group">
                        <label class="form-control-label" for="item_price">{{ __('Is Featured') }}</label>
                        <label class="custom-toggle" style="float: right">
                            <input type="checkbox" name="is_featured" <?php if ($company->is_featured == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="custom-toggle-slider rounded-circle"></span>
                        </label>
                    </div>
                    <br />
                @endif
                <br>
                <div class="form-group">
                    <label class="form-control-label">WhatsApp Sending Speed</label>
                    <div>
                        <label>
                            <input type="radio" name="sending_speed" value="enterprise"
                                {{ $company->is_enterprise == 1 ? 'checked' : '' }}>
                            High speed
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="sending_speed" value="premium"
                                {{ $company->is_premium == 1 ? 'checked' : '' }}>
                            Medium speed
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="sending_speed" value="default"
                                {{ $company->is_enterprise == 0 && $company->is_premium == 0 ? 'checked' : '' }}>
                            Default speed
                        </label>
                    </div>
                </div>

                <br />
                <div class="row">
                    <?php
                    $images = [];
                    if (config('settings.show_company_logo')) {
                        $images = [['name' => 'company_logo', 'label' => __('Company Image'), 'value' => $company->logom, 'style' => 'width: 295px; height: 200px;', 'help' => 'JPEG 590 x 400 recomended'], ['name' => 'company_cover', 'label' => __('Company Cover Image'), 'value' => $company->coverm, 'style' => 'width: 200px; height: 100px;', 'help' => 'JPEG 2000 x 1000 recomended']];
                    }
                    ?>
                    @foreach ($images as $image)
                        <div class="col-md-6">
                            @include('partials.images', $image)
                        </div>
                    @endforeach

                </div>



            </div>
            <div class="col-md-6">
                @include('companies.partials.localisation')
            </div>

        </div>


        <div class="text-left">
            <button type="submit" class="btn btn-info mt-4">{{ __('Update record') }}</button>
        </div>

    </form>
</div>
