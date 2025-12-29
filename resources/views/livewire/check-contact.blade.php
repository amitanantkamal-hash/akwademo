<div x-data="{ isVisible: @entangle('showContacts') }" x-show="isVisible" @closeCheckContact.window="isVisible"
    class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
    <div class="card card-flush h-100" id="kt_contacts_list">
        <div class="card-header pt-7" id="kt_contacts_list_header">
            <div class="d-flex align-items-center position-relative w-100">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                <input type="text" id="searchInputContact" class="form-control form-control-lg ps-12 me-2 w-100"
                    placeholder="Search...">
            </div>
        </div>
        <div class="card-body pt-5" id="kt_contacts_list_body">
            <div class="scroll-y me-n5 pe-5 h-375px h-xl-800px" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_contacts_list_header"
                data-kt-scroll-wrappers="#kt_content, #kt_contacts_list_body"
                data-kt-scroll-stretch="#kt_contacts_list, #kt_contacts_main" data-kt-scroll-offset="5px">
                @foreach ($contacts as $item)
                    <div class="contenedor" data-name="{{ $item->name }}">
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px symbol-circle">
                                    @if (!empty($item->avatar))
                                        <img alt="Picture Avatar" src="{{ $item->avatar }}"class="avatar shadow" />
                                    @else
                                        <span
                                            class="symbol-label bg-light-primary text-primary fs-5 fw-bolder">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="ms-4">
                                    {{-- <a href="{{ route('contact.info', ['contact' => $item->id]) }}" class="fs-6 fw-bold text-gray-900 text-hover-primary mb-2">{{ $item->name }}</a> --}}
                                    <a wire:click="$dispatch('checkContact', {contact: {{ json_encode($item) }}, fields: {{ json_encode($item->fields) }}, contactGroup: {{ $item->groups }}})"
                                        class="fs-6 fw-bold text-gray-900 text-hover-primary mb-2"
                                        style="cursor: pointer;">{{ $item->name }}</a>
                                    <div class="fw-semibold fs-7 text-muted">
                                        {{ $item->email ?? 'No email' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed d-none"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        //filtrar
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInputContact');
            const appCards = document.querySelectorAll('.contenedor');
            searchInput.addEventListener('keyup', function() {
                console.log('teclado');
                const searchTerm = searchInput.value.toLowerCase();
                appCards.forEach(card => {
                    const appName = card.getAttribute('data-name').toLowerCase();
                    if (appName.includes(searchTerm)) {
                        card.style.display = ''; // Mostrar tarjeta
                    } else {
                        card.style.display = 'none'; // Ocultar tarjeta
                    }
                });
            });
        });
    </script>
</div>
