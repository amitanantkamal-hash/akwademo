<?php
$availableLanguagesENV = config('settings.front_languages');
$exploded = explode(',', $availableLanguagesENV);
$availableLanguages = [];
for ($i = 0; $i < count($exploded); $i += 2) {
    $availableLanguages[$exploded[$i]] = $exploded[$i + 1];
}
$locale =isset($locale)?$locale:(Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale'));
?>


@if(isset($availableLanguages)&&count($availableLanguages)>1&&isset($locale))
    <!--begin::Toggle-->
    <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
        @foreach ($availableLanguages as $short => $lang)
        @if(strtolower($short) == strtolower($locale))
            @if($short == 'EN')
                <img  data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="/Metronic/assets/media/flags/united-states.svg" alt=""/>
            @else
                <img  data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="/Metronic/assets/media/flags/spain.svg" alt=""/>
            @endif
            <span data-kt-element="current-lang-name" class="me-1">{{ __($lang) }}</span>
            <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
        @endif
        @endforeach
    </button>
    <!--end::Toggle-->

    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
        @foreach ($availableLanguages as $short => $lang)
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ route('home',$short)}}" class="menu-link d-flex px-5" data-kt-lang="{{ $lang }}">
                    <span class="symbol symbol-20px me-4">
                        @if($short == 'EN')
                            <img data-kt-element="lang-flag" class="rounded-1" src="Metronic/assets/media/flags/united-states.svg" alt="" />
                        @else
                            <img data-kt-element="lang-flag" class="rounded-1" src="Metronic/assets/media/flags/spain.svg" alt="" />
                        @endif
                    </span>
                    <span data-kt-element="lang-name">{{ __($lang) }}</span>
                </a>
            </div>
            <!--end::Menu item-->
        @endforeach
    </div>
    <!--end::Menu-->
@endif
