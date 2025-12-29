@extends('layouts.app-client')

@section('topcss')
    <!-- Add any additional top CSS if needed -->
@endsection

@section('content')
    @if (auth()->user()->hasrole('owner') || auth()->user()->hasrole('staff'))
        <div class="row d-flex justify-content-between mb-4">
            <div class="col-12 col-lg-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <h1 class="mb-3 mt--3">{{ auth()->user()->company->name }} : {{ __('Partner dashboard') }}</h1>
                    </div>
                </div>
            </div>
            {{-- 
            <div class="col-12 col-lg-6 text-lg-end">
                @if (auth()->user()->hasrole('owner'))
                    <a href="{{ route('admin.companies.create') }}"
                        class="btn btn-info btn-sm fs-7">{{ __('Add new company') }}</a>
                @endif
            </div> --}}
        </div>
    @endif

    {{-- <div class="header pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <h1 class="mb-3 mt--3">🏢 {{ __('Companies') }}</h1>
                <div class="row align-items-center pt-2">
                    <!-- Additional content like search filters can be added here if needed -->
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card card-flush">
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <div class="card-title">
                                <div class="d-flex align-items-center position-relative my-1">
                                    {{ __('Companies records') }}
                                </div>
                            </div>
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                @if ($companies)
                                    <button class="btn btn-sm btn-info" id="exportBtn">{{ __('Export data') }}</button>
                                @endif
                                @if (\App\Models\Partner::where('user_id', auth()->user()->id)->where('is_active', 1)->where('allowed_customer_creation', 1)->exists())
                                    <a href="{{ route('partner.add.company') }}" class="btn btn-sm btn-info">
                                        {{ __('Add new') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>

                    <div class="card-body pt-0">
                        <div class="mb-3 mt-4">
                            <input type="text" id="searchInput" class="form-control form-control-solid w-25"
                                placeholder="{{ __('Search...') }}">
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dataTables">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-20px">{{ __('Sr.No.') }}</th>
                                        <th class="min-w-200px">{{ __('Company Name') }}</th>
                                        @if (config('settings.show_company_logo'))
                                            <th scope="col" class="min-w-100px">{{ __('Logo') }}</th>
                                        @endif
                                        <th scope="col" class="min-w-150px">{{ __('Owner') }}</th>
                                        <th scope="col" class="min-w-200px">{{ __('Owner email') }}</th>
                                        <th scope="col" class="min-w-150px">{{ __('Phone') }}</th>
                                        <th scope="col" class="min-w-200px">{{ __('Creation Date') }}</th>
                                        <th scope="col" class="min-w-200px">{{ __('Subscription End') }}</th>
                                        <th scope="col" class="min-w-100px">{{ __('Active') }}</th>
                                        <th scope="col" class="min-w-50px text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $userTypes = [
                                            1 => 'Admin',
                                            2 => 'User',
                                            3 => 'Partner',
                                        ];
                                    @endphp
                                    @foreach ($companies as $company)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td><a
                                                    href="{{ route('admin.companies.edit', $company) }}">{{ $company->name }}</a>
                                            </td>

                                            @if (config('settings.show_company_logo'))
                                                <td><img class="rounded" src="{{ $company->icon }}" width="50px"
                                                        height="50px" alt="{{ $company->name }}"></td>
                                            @endif

                                            <td>{{ $company->user ? $company->user->name : __('Deleted') }}</td>
                                            <td>
                                                <a
                                                    href="mailto:{{ $company->user ? $company->user->email : '' }}">{{ $company->user ? $company->user->email : __('Deleted') }}</a>
                                            </td>
                                            <td>
                                                <a href="tel:{{ $company->phone }}">{{ $company->phone }}</a>
                                            </td>
                                            <td>{{ $company->created_at->locale(Config::get('app.locale'))->isoFormat('LLLL') }}
                                            </td>
                                            <td>
                                                @php
                                                    $companyActiveSubscription = \App\Models\Subscription_Info::where(
                                                        'company_id',
                                                        $company->id,
                                                    )
                                                        ->where('status', 1)
                                                        ->first();
                                                @endphp
                                                @if ($companyActiveSubscription)
                                                    {{ $companyActiveSubscription->expire_date ? \Carbon\Carbon::parse($companyActiveSubscription->expire_date)->format('l, F j, Y') : 'No active subscription' }}
                                                @else
                                                    {{ __('No active subscription') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($company->active == 1)
                                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ __('Not active') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only" href="#" role="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.companies.edit', $company) }}">{{ __('Edit') }}</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.companies.loginas', $company) }}">{{ __('Login as') }}</a>
                                                        <form action="{{ route('admin.companies.destroy', $company) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            @if ($company->active == 0)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('admin.company.activate', $company) }}">{{ __('Activate') }}</a>
                                                            @else
                                                                <button type="button" class="dropdown-item"
                                                                    onclick="confirm('{{ __('Are you sure you want to deactivate this company?') }}') ? this.parentElement.submit() : ''">{{ __('Deactivate') }}</button>
                                                            @endif
                                                        </form>
                                                        <a class="dropdown-item text-danger"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this company from the database?') }}')"
                                                            href="{{ route('admin.company.remove', $company) }}">{{ __('Delete') }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $companies->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var resUrl = "{{ route('admin.companies.edit', 0) }}";
    </script>

    @push('js')
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/46876576.js"></script>
        <!-- End of HubSpot Embed Code -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function copyWhatsAppLink() {
                var phoneNumber = "{{ $user->phone ?? '11111111' }}";
                var waLink = `https://wa.me/${phoneNumber}`;
                var tempInput = document.createElement("input");
                document.body.appendChild(tempInput);
                tempInput.value = waLink;
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Enlace de WhatsApp copiado: " + waLink);
            }
        </script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script>
            const phoneInputField = document.querySelector("#billing_phone");
            const phoneInput = window.intlTelInput(phoneInputField, {
                preferredCountries: ["do", "mx", "ar", "es"], // Lista de paÃ­ses preferidos
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
        </script> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const currentUrl = window.location.href; // Obtiene la URL actual
                const targetUrl = "{{ route('contacts.index', ['type' => 'create']) }}"; // Ruta objetivo
                const baseUrl = "{{ route('contacts.index') }}"; // Ruta base
                document.getElementById('createContactDash').addEventListener('click', function() {
                    if (currentUrl === targetUrl || currentUrl.startsWith(baseUrl)) {
                        // Si estamos en la ruta correcta, abrir el modal
                        console.log('abre el modal');
                        $('#kt_modal_create').modal('show');
                        // No es necesario llamar a openModal() ya que Bootstrap lo maneja
                    } else {
                        // Si no estamos en la ruta correcta, redirigir a la ruta correcta
                        window.location.href = targetUrl;
                    }
                });
                // Código para abrir el modal si ya estás en la ruta correcta
                setTimeout(() => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const type = urlParams.get('type');
                    if (type === 'create') {
                        // Abre el modal usando Bootstrap
                        $('#kt_modal_create').modal('show');
                    }
                }, 1000); // Ajusta el tiempo según sea necesario
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

        <script>
            $(document).ready(function() {

                var table = $('#dataTables').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthChange": false
                });
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });

                document.getElementById('exportBtn').addEventListener('click', function() {
                    let table = document.getElementById('dataTables');
                    let wb = XLSX.utils.book_new();
                    let ws = XLSX.utils.table_to_sheet(table);
                    XLSX.utils.book_append_sheet(wb, ws, 'WhatsApp Flows Data');
                    XLSX.writeFile(wb, 'companies_data.xlsx');
                });
            });
        </script>
    @endpush
@endsection
