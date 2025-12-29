<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-0 px-sm-8 py-sm-4 me-lg-20">
    <div class="bg-body d-flex flex-column flex-center rounded rounded-md-4 py-6 w-100">
        <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 px-10 px-sm-20 px-md-20 w-100">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                {{ $slot }}
            </div>
            <div class=" d-flex flex-stack">
                <div class="me-10">
                    {{ $languages }}
                </div>
                @isset($links)
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        {{ $links }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
