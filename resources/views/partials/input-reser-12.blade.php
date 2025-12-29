@if ($id != 'name')
    @isset($separator)
        <!--begin::Separator-->
        <div class="separator separator-dashed border-primary my-6"></div>
        
        <!--begin::Heading-->
        <div class="d-flex align-items-center mb-5">
            <span class="svg-icon svg-icon-primary svg-icon-2x me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"/>
                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"/>
                </svg>
            </span>
            <h3 class="fw-bolder text-gray-900 mb-0">{{ __($separator) }}</h3>
        </div>
        <!--end::Heading-->
    @endisset
    
    <!--begin::Input group-->
    <div class="col-md-6 fv-row">
        <div id="form-group-{{ $id }}" class="@if($errors->has($id)) has-danger @endif">
            @if (!(isset($type) && $type == 'hidden'))
                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label mb-2" for="{{ $id }}">
                    {{ __($name) }}
                    @isset($link)
                        <a target="_blank" href="{{ $link }}" class="ms-2">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 7H13V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V7H3C2.4 7 2 7.4 2 8C2 8.6 2.4 9 3 9H11V13C11 13.6 11.4 14 12 14C12.6 14 13 13.6 13 13V9H21C21.6 9 22 8.6 22 8C22 7.4 21.6 7 21 7Z" fill="black"/>
                                </svg>
                            </span>
                            {{ $linkName }}
                        </a>
                    @endisset
                </label>
                <!--end::Label-->
            @endif
            
            <!--begin::Input-->
            <div class="input-group input-group-solid">
                @isset($prepend)
                    <span class="input-group-text">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                                <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                            </svg>
                        </span>
                        {{ $prepend }}
                    </span>
                @endisset
                
                <input 
                    @isset($changevue) @change="{{ $changevue }}" ref="{{ $id }}" @endisset
                    @isset($onvuechange) @input="{{ $onvuechange }}" ref="{{ $id }}" @endisset
                    @isset($accept) accept="{{ $accept }}" @endisset
                    step="{{ isset($step) ? $step : '.01' }}"
                    @isset($min) min="{{ $min }}" @endisset
                    @isset($max) max="{{ $max }}" @endisset
                    type="{{ isset($type) ? $type : 'text' }}" 
                    name="{{ $id }}" 
                    id="{{ $id }}"
                    class="form-control form-control-solid @isset($editclass) {{ $editclass }} @endisset @if($errors->has($id)) is-invalid @endif"
                    placeholder="{{ __($placeholder) }}"
                    value="{{ old($id) ? old($id) : (isset($value) ? $value : (app('request')->input($id) ? app('request')->input($id) : null)) }}"
                    @if($required) required @endif
                />
            </div>
            <!--end::Input-->
            
            @isset($additionalInfo)
                <div class="text-muted fs-7 mt-2">
                    <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(90 11 17)" fill="black"/>
                            <rect x="11" y="11" width="2" height="6" rx="1" transform="rotate(90 11 11)" fill="black"/>
                        </svg>
                    </span>
                    {{ __($additionalInfo) }}
                </div>
            @endisset
            
            @if($errors->has($id))
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    <div data-field="{{ $id }}" data-validator="notEmpty">
                        <span class="svg-icon svg-icon-3 me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                                <rect x="11" y="14" width="2" height="2" rx="1" transform="rotate(90 11 14)" fill="black"/>
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(90 11 17)" fill="black"/>
                                <rect x="11" y="11" width="2" height="2" rx="1" transform="rotate(90 11 11)" fill="black"/>
                            </svg>
                        </span>
                        {{ $errors->first($id) }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!--end::Input group-->
@else
    <!--begin::Name fields-->
    <div class="col-md-6 fv-row">
        <!--begin::Input group-->
        <div class="form-group">
            <!--begin::Label-->
            <label class="fs-6 fw-bold form-label mb-2" for="name">
                <span class="svg-icon svg-icon-2 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black"/>
                        <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black"/>
                    </svg>
                </span>
                {{ __('Name') }}
            </label>
            <!--end::Label-->
            
            <!--begin::Input-->
            <input 
                type="text" 
                name="name" 
                id="name"
                class="form-control form-control-solid"
                placeholder="{{ __('First name') }}"
                required
                step=".01"
            />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    
    <div class="col-md-6 fv-row">
        <!--begin::Input group-->
        <div class="form-group">
            <!--begin::Label-->
            <label class="fs-6 fw-bold form-label mb-2" for="lastname">
                <span class="svg-icon svg-icon-2 me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black"/>
                        <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black"/>
                    </svg>
                </span>
                {{ __('Last Name') }}
            </label>
            <!--end::Label-->
            
            <!--begin::Input-->
            <input 
                type="text" 
                name="lastname" 
                id="lastname"
                class="form-control form-control-solid"
                placeholder="{{ __('Last name') }}"
                required
                step=".02"
            />
            <!--end::Input-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Name fields-->
@endif