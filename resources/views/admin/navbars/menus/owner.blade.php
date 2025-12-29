@php /*
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() == 'dashboard') active @endif"
            href="{{ route('dashboard') }}">
            <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
        </a>
    </li>

    @include('admin.navbars.menus.extra')

    @if (!config('settings.hide_company_profile',false))
        <li class="nav-item">
            {{-- <a class="nav-link @if (Route::currentRouteName() == 'admin.companies.edit') active @endif"
                href="{{ route('admin.companies.edit', auth()->user()->company->id) }}"> --}}
                <a class="nav-link @if (Route::currentRouteName() == 'admin.companies.edit') active @endif"
                href="{{ route('admin.companies.edit', auth()->user()->resolveCurrentCompany()->id) }}">
                <i class="ni ni-shop text-primary"></i> {{ __('Company') }}
            </a>
        </li>
    @endif

    @if(config('settings.enable_leads'))
        <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == 'pay_meta.pay_meta') active @endif"
                href="https://business.facebook.com/billing_hub/accounts/details/?asset_id=410443552149991&business_id=1728068524239304&external_flow_id=SU-1754652354562--2037419559-2209991327&placement=whatsapp_ads&payment_account_id=1436753670278013">
                <i class="ni ni-credit-card text-red"></i> {{ __('Pay Meta') }}
            </a>
        </li>
    @endif

    @if (!config('settings.hide_company_apps',false))
        <li class="nav-item">
            <a class="nav-link @if (Route::currentRouteName() == 'admin.apps.company') active @endif"
                href="{{ route('admin.apps.company') }}">
                <i class="ni ni-spaceship text-red"></i> {{ __('Apps') }}
            </a>
        </li>
    @endif
    
    

   

    @if(config('settings.enable_pricing'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('subscription.info') }}">
                <i class="ni ni-credit-card text-orange"></i> {{ __('Plan') }}
            </a>
        </li>
    @endif

    @if (!config('settings.hide_share_link',false))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.share') }}">
                <i class="ni ni-send text-green"></i> {{ __('Share') }}
            </a>
        </li>
        
    @endif
    

       
    

</ul>
@if (config('vendorlinks.enable',false))
<hr class="my-3">
<h6 class="navbar-heading p-0 text-muted">
    <span class="docs-normal">{{__(config('vendorlinks.name',""))}}</span>
</h6>
<ul class="navbar-nav mb-md-3">
    @if (strlen(config('vendorlinks.link1link',""))>4)
        <li class="nav-item">
            <a class="nav-link" href="{{config('vendorlinks.link1link',"")}}" target="_blank">
                <span class="nav-link-text">{{__(config('vendorlinks.link1name',""))}}</span>
            </a>
        </li>
    @endif

    @if (strlen(config('vendorlinks.link2link',""))>4)
        <li class="nav-item">
            <a class="nav-link" href="{{config('vendorlinks.link2link',"")}}" target="_blank">
                <span class="nav-link-text">{{__(config('vendorlinks.link2name',""))}}</span>
            </a>
        </li>
    @endif

    @if (strlen(config('vendorlinks.link3link',""))>4)
        <li class="nav-item">
            <a class="nav-link" href="{{config('vendorlinks.link3link',"")}}" target="_blank">
                <span class="nav-link-text">{{__(config('vendorlinks.link3name',""))}}</span>
            </a>
        </li>
    @endif
    
</ul>
@endif
*/ @endphp
