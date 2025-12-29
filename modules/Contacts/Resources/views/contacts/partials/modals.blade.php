<div class="modal fade" id="move-to-group-modal" tabindex="-1" role="dialog" aria-labelledby="moveToGroupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="ki-duotone ki-people fs-2 me-2">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>
                    {{ __('Add to Group') }}
                </h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                </div>
            </div>

            <div class="modal-body py-6 px-8">
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-8">
                    <i class="ki-duotone ki-information-5 fs-2tx text-warning me-4">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-gray-900 fw-bold">{{ __('We need your attention!') }}</h4>
                        <span
                            class="fs-6 text-gray-700">{{ __('Select a group to add from the selected contacts.') }}</span>
                    </div>
                </div>

                <div class="position-relative mb-8">
                    <i class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    <input type="text" class="form-control form-control-solid ps-12" placeholder="Search groups..."
                        id="group-add-search">
                </div>

                <div class="scroll-y me-n6 pe-6" style="max-height: 350px;" id="group-add-list">
                    <div class="row g-6" id="group-add-container">
                        @isset($setup['groups'])
                            @foreach ($setup['groups'] as $group)
                                <div class="col-md-6 group-item-container">
                                    <div class="d-flex align-items-center mb-6 group-item"
                                        data-group-name="{{ strtolower($group->name) }}">
                                        <div class="form-check form-check-custom form-check-solid me-6">
                                            <input class="form-check-input h-20px w-20px" type="checkbox" name="groupAdd"
                                                id="group-{{ $group->id }}" value="{{ $group->id }}">
                                        </div>
                                        <label class="form-check-label cursor-pointer d-flex align-items-center flex-grow-1"
                                            for="group-{{ $group->id }}">
                                            <i class="ki-duotone ki-abstract-26 fs-2 me-3 text-primary">
                                                <i class="path1"></i>
                                                <i class="path2"></i>
                                            </i>
                                            <span class="fw-semibold group-name">{{ $group->name }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>

            <div class="modal-footer flex-center">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2 me-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    {{ __('Close') }}
                </button>
                <button type="button" class="btn btn-primary" id="move-to-group-confirm">
                    <i class="ki-duotone ki-check fs-2 me-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    {{ __('Add Selected') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="remove-from-group-modal" tabindex="-1" role="dialog"
    aria-labelledby="removeFromGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="ki-duotone ki-people-cross fs-2 me-2">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>
                    {{ __('Remove from Group') }}
                </h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                </div>
            </div>

            <div class="modal-body py-6 px-8">
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6 mb-8">
                    <i class="ki-duotone ki-information-5 fs-2tx text-danger me-4">
                        <i class="path1"></i>
                        <i class="path2"></i>
                        <i class="path3"></i>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-gray-900 fw-bold">{{ __('Important Action!') }}</h4>
                        <span
                            class="fs-6 text-gray-700">{{ __('Select a group to remove the selected contacts from.') }}</span>
                    </div>
                </div>

                <div class="position-relative mb-8">
                    <i class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    <input type="text" class="form-control form-control-solid ps-12"
                        placeholder="Search groups..." id="group-remove-search">
                </div>

                <div class="scroll-y me-n6 pe-6" style="max-height: 350px;" id="group-remove-list">
                    <div class="row g-6" id="group-remove-container">
                        @isset($setup['groups'])
                            @foreach ($setup['groups'] as $group)
                                <div class="col-md-6 group-item-container">
                                    <div class="d-flex align-items-center mb-6 group-item"
                                        data-group-name="{{ strtolower($group->name) }}">
                                        <div class="form-check form-check-custom form-check-solid me-6">
                                            <input class="form-check-input h-20px w-20px" type="checkbox"
                                                name="groupremove" id="remove-group-{{ $group->id }}"
                                                value="{{ $group->id }}">
                                        </div>
                                        <label
                                            class="form-check-label cursor-pointer d-flex align-items-center flex-grow-1"
                                            for="remove-group-{{ $group->id }}">
                                            <i class="ki-duotone ki-abstract-26 fs-2 me-3 text-danger">
                                                <i class="path1"></i>
                                                <i class="path2"></i>
                                            </i>
                                            <span class="fw-semibold group-name">{{ $group->name }}</span>
                                            {{-- <span
                                                class="badge badge-light-danger ms-auto">{{ $group->contacts_count ?? 0 }}</span> --}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>

            <div class="modal-footer flex-center">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2 me-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    {{ __('Cancel') }}
                </button>
                <button type="button" class="btn btn-danger" id="remove-from-group-confirm">
                    <i class="ki-duotone ki-trash fs-2 me-1">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    {{ __('Remove Selected') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('group-remove-search');
        const groupContainer = document.getElementById('group-remove-container');
        const originalItems = groupContainer.innerHTML;

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();

            if (searchTerm === '') {
                groupContainer.innerHTML = originalItems;
                return;
            }

            const groupItems = groupContainer.querySelectorAll('.group-item');
            let hasMatches = false;

            groupItems.forEach(item => {
                const groupName = item.getAttribute('data-group-name');
                const nameElement = item.querySelector('.group-name');
                const originalName = nameElement.textContent;

                if (groupName.includes(searchTerm)) {
                    item.closest('.group-item-container').style.display = 'block';
                    nameElement.innerHTML = originalName.replace(
                        new RegExp(searchTerm, 'gi'),
                        match => `<span class="text-danger fw-bold">${match}</span>`
                    );
                    hasMatches = true;
                } else {
                    item.closest('.group-item-container').style.display = 'none';
                }
            });

            if (!hasMatches) {
                groupContainer.innerHTML =
                    '<div class="col-12 text-center py-10">No matching groups found</div>';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('group-add-search');
        const groupContainer = document.getElementById('group-add-container');
        const originalItems = groupContainer.innerHTML;

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();

            if (searchTerm === '') {
                groupContainer.innerHTML = originalItems;
                return;
            }

            const groupItems = groupContainer.querySelectorAll('.group-item');
            let hasMatches = false;

            groupItems.forEach(item => {
                const groupName = item.getAttribute('data-group-name');
                const nameElement = item.querySelector('.group-name');
                const originalName = nameElement.textContent;

                if (groupName.includes(searchTerm)) {
                    item.closest('.group-item-container').style.display = 'block';
                    nameElement.innerHTML = originalName.replace(
                        new RegExp(searchTerm, 'gi'),
                        match => `<span class="text-primary fw-bold">${match}</span>`
                    );
                    hasMatches = true;
                } else {
                    item.closest('.group-item-container').style.display = 'none';
                }
            });

            if (!hasMatches) {
                groupContainer.innerHTML =
                    '<div class="col-12 text-center py-10">No matching groups found</div>';
            }
        });
    });
</script>
