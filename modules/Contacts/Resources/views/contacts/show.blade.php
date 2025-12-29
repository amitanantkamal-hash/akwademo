@extends('admin.app', $setup)

@section('admin_title')
    {{__('Contacts')}}
@endsection

@section('owneractions')
    <a href="{{ route('contacts.index', ['report'=>true]) }}" class="btn btn-flex btn-outline btn-active-light-primary h-40px fs-7 fw-bold"><i class="ki-outline ki-exit-up fs-2"></i>{{__('Export')}}</a>
    <a href="{{ route('contacts.import.index') }}" class="btn btn-flex btn-outline btn-active-light-primary h-40px fs-7 fw-bold"><i class="ki-outline ki-exit-down fs-2"></i>{{__('Import')}}</a>
    <a href="{{ route('contacts.create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{__('Add Contact')}}</a>
@endsection

@section('content')
    <div class="row g-7">
        <!--begin::Contact groups-->
        <div class="col-lg-6 col-xl-3">
            <!--begin::Contact group wrapper-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{__('Groups')}}</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5">
                    <!--begin::Contact groups-->
                    <div class="d-flex flex-column gap-5 mb-5">
                        <!--begin::Contact group-->
                        <div class="d-flex flex-stack">
                            <a href="{{ route('contacts.index') }}" class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary @if (Route::currentRouteName() == 'contacts.index' && !request()->has('group')) active @endif">{{__('All Contacts')}}</a>
                            <div class="badge badge-light-info">{{$setup['items']->count()}}</div>
                        </div>
                        <!--begin::Contact group-->
                    </div>
                    <!--end::Contact groups-->
                    @foreach($setup['groups']['contactGroups'] as $group)
                        <!--begin::Contact groups-->
                        <div class="d-flex flex-column gap-5 mb-5">
                            <!--begin::Contact group-->
                            <div class="d-flex flex-stack">
                                <a href="{{ route('contacts.index',['group'=>$group->id]) }}" class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary @if (request()->query('group') == "$group->id") active @endif">{{ $group->name }}</a>
                                <div class="badge badge-light-info">{{ $group->contacts->count() }}</div>
                            </div>
                            <!--begin::Contact group-->
                        </div>
                        <!--end::Contact groups-->
                    @endforeach
                    <!--begin::Separator-->
                    <div class="separator position-static my-7"></div>
                    <!--begin::Separator-->
                    <form method="POST" action="{{ route('contacts.groups.store') }}" class="my-2" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Add contact group-->
                        <label class="fs-6 fw-semibold form-label">{{__('Add new group')}}</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-solid" name="name" placeholder="{{__('Group name')}}">
                            <button type="submit" class="btn btn-icon btn-light">
                                <i class="ki-outline ki-plus-square fs-2"></i>
                            </button>
                        </div>
                        <!--end::Add contact group-->
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contact group wrapper-->
        </div>
        <!--end::Contact groups-->
        <!--begin::Search-->
        <div class="col-lg-6 col-xl-3">
            <!--begin::Contacts-->
            <div class="card card-flush" id="kt_contacts_list">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{__('Contacts')}}</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Form-->
                    <form method="GET" class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                        <!--begin::Icon-->
                        <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid ps-13" name="name" value="{{request()->query('name')}}" placeholder="Search contacts">
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_contacts_list_body">
                    <!--begin::List-->
                    <div class="scroll-y me-n5 pe-5 h-300px h-xl-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header" data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body" data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px" style="max-height: 571px;">
                        @foreach ($setup['items'] as $item)
                            <!--begin::Separator-->
                            <div class="separator separator-dashed d-none"></div>
                            <!--end::Separator-->
                            <!--begin::User-->
                            <div class="d-flex flex-stack py-4">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <a href="{{ route('contacts.show', ['contact'=>$item->id]) }}" class="symbol symbol-40px symbol-circle">
                                        <img alt="Pic" src="{{ $item->avatar }}">
                                    </a>
                                    <!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-4">
                                        <a href="{{ route('contacts.show',['contact'=>$item->id]) }}" class="fs-6 fw-bold text-gray-900 text-hover-primary mb-2">{{$item->name}}</a>
                                        <div class="fw-semibold fs-7 text-muted">
                                            <a title="{{ __('Call Contact')}}" href="tel:+{{$item->phone}}">{{$item->phone}}</a>
                                        </div>
                                    </div>
                                    <!--end::Details-->

                                    <div class="ms-4">
                                        <button class="btn"></button>
                                    </div>
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::User-->
                        @endforeach
                    </div>
                    <!--end::List-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Contacts-->
        </div>
        <!--end::Search-->
        <!--begin::Content-->
        <div class="col-xl-6">
            <!--begin::Card-->
            <div class="card card-flush h-lg-100" id="kt_contacts_main">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <i class="ki-outline ki-badge fs-1 me-2"></i>
                        <h2>{{__('Contact Details')}}</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar gap-3">
                        <!--begin::Chat-->
                        <a target="_blank" title="{{__('Contact on Messenger')}}" href="https://m.me/+{{$setup['contact']->phone}}" class="btn btn-sm btn-light btn-active-light-primary"><i class="ki-outline ki-facebook fs-2"></i></a>
                        <a target="_blank" title="{{__('Contact on Telegram')}}" href="https://t.me/+{{$setup['contact']->phone}}" class="btn btn-sm btn-light btn-active-light-primary"><i class="ki-outline ki-send fs-2"></i></a>
                        <a target="_blank" title="{{__('Contact on Whatsapp')}}" href="https://wa.me/+{{$setup['contact']->phone}}" class="btn btn-sm btn-light btn-active-light-success"><i class="ki-outline ki-whatsapp fs-2"></i></a>
                        <!--end::Chat-->
                        <!--begin::Chat-->
                        <a href="{{ route('campaigns.create',['contact_id'=>$item->id]) }}" class="btn btn-sm btn-light btn-active-light-primary">
                            <i class="ki-outline ki-message-text-2 fs-2"></i>{{__('Chat')}}
                        </a>
                        <!--end::Chat-->
                        <!--begin::Action menu-->
                        <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-dots-square fs-2"></i>
                        </a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('contacts.edit',['contact'=>$item->id]) }}" class="menu-link px-3">Edit</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ route('contacts.delete',['contact'=>$item->id]) }}" class="menu-link px-3" id="kt_contact_delete" data-kt-redirect="apps/contacts/getting-started.html">Delete</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Action menu-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5">
                    <!--begin::Profile-->
                    <div class="d-flex gap-7 align-items-center">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-circle symbol-100px">
                            <img src="{{$setup['contact']->avatar}}" alt="image">
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Contact details-->
                        <div class="d-flex flex-column gap-2">
                            <!--begin::Name-->
                            <h3 class="mb-0">{{$setup['contact']->name}}</h3>
                            <!--end::Name-->
                            <!--begin::Email-->
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-outline ki-sms fs-2"></i>
                                <a href="mailto:{{$setup['contact']->email}}" class="text-muted text-hover-primary">{{$setup['contact']->email}}</a>
                            </div>
                            <!--end::Email-->
                            <!--begin::Phone-->
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-outline ki-phone fs-2"></i>
                                <a href="tel:+{{$setup['contact']->phone}}" class="text-muted text-hover-primary">{{$setup['contact']->phone}}</a>
                            </div>
                            <!--end::Phone-->
                            <!--begin::Website-->
                            <div class="d-flex align-items-center gap-2">
                                <i class="ki-outline ki-wifi-square fs-2"></i>
                                <a target="_blank" href="{{$setup['contact']->website}}" class="text-muted text-hover-primary">{{$setup['contact']->website}}</a>
                            </div>
                            <!--end::Website-->
                        </div>
                        <!--end::Contact details-->
                    </div>
                    <!--end::Profile-->
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8 gap-2" role="tablist">
                        <!--begin:::Tab item-->
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary d-flex align-items-center pb-4 active" data-bs-toggle="tab" href="#kt_contact_view_general" aria-selected="true" role="tab">
                            <i class="ki-outline ki-home fs-4 me-1"></i>General</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content" id="">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_contact_view_general" role="tabpanel">
                            <!--begin::Additional details-->
                            <div class="d-flex flex-column gap-5 mt-7">
                                <!--begin::Company name-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Company Name')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->company_id ? App\Models\Company::find($setup['contact']->company_id)->name : ''}}</div>
                                </div>
                                <!--end::Company name-->
                                <!--begin::Title-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Title')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->title}}</div>
                                </div>
                                <!--end::Title-->
                                <!--begin::Position-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Position')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->position}}</div>
                                </div>
                                <!--end::Position-->
                                <!--begin::Gender-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Gender')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->gender}}</div>
                                </div>
                                <!--end::Gender-->
                                <!--begin::Address-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Address')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->address}}</div>
                                </div>
                                <!--end::Address-->
                                <!--begin::City-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('City')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->city}}</div>
                                </div>
                                <!--end::City-->
                                <!--begin::Country-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Country')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->country ? $setup['contact']->country->name : ''}}</div>
                                </div>
                                <!--end::Country-->
                                <!--begin::Notes-->
                                <div class="d-flex flex-column gap-1">
                                    <div class="fw-bold text-muted">{{__('Notes')}}</div>
                                    <div class="fw-bold fs-5">{{$setup['contact']->notes}}</div>
                                </div>
                                <!--end::Notes-->
                            </div>
                            <!--end::Additional details-->
                        </div>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->
    </div>
@endsection
