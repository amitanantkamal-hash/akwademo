<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        preferredCountries: ["do", "mx", "ar", "es"], // Lista de países preferidos
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
</script> --}}

<script>
    function preventClose(event) {
        event.stopPropagation();
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Editar Grupo
        var editGroupModal = document.getElementById('editGroupModal');
        editGroupModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Botón que disparó el modal
            var groupId = button.getAttribute('data-group-id');
            var groupName = button.getAttribute('data-group-name');
            // Rellenar los campos del modal
            var modalInputName = editGroupModal.querySelector('#group_name');
            var modalInputId = editGroupModal.querySelector('#group_id');
            modalInputName.value = groupName;
            modalInputId.value = groupId;
        });
        // Eliminar Grupo
        var deleteGroupModal = document.getElementById('deleteGroupModal');
        deleteGroupModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Botón que disparó el modal
            var groupId = button.getAttribute('data-group-id');
            // Rellenar el campo del ID del grupo a eliminar
            var modalInputId = deleteGroupModal.querySelector('#delete_group_id');
            modalInputId.value = groupId;
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar el modal de edición
        $('#editFields').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var fieldId = button.data('field-id'); // Extraer el ID del campo
            var fieldName = button.closest('tr').find('td:first').text(); // Obtener el nombre del campo
            var fieldType = button.closest('tr').find('td:nth-child(2)')
                .text(); // Obtener el tipo del campo
            // Actualizar el campo oculto y los campos de texto
            var modal = $(this);
            modal.find('#field_id').val(fieldId);
            modal.find('#field_name').val(fieldName);
            modal.find('#field_type').val(fieldType); // Configurar el tipo en el selector
        });
        // Configurar el modal de eliminación
        $('#deleteFields').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var fieldId = button.data('field-id'); // Extraer el ID del campo
            // Actualizar el campo oculto
            var modal = $(this);
            modal.find('#delete_field_id').val(fieldId);
        });
    });
</script>
<script>
    function previewImage(event) {
        const input = event.target;
        const inputRemove = document.getElementById('avatar_remove');
        const wrapper = document.querySelector('.image-input-wrapper');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                wrapper.style.backgroundImage = `url(${e.target.result})`;
            }
            reader.readAsDataURL(input.files[0]);
        }
        inputRemove.value = '';
    }

    function cancelImage() {
        const input = document.querySelector('input[name="avatar"]');
        const wrapper = document.querySelector('.image-input-wrapper');
        input.value = '';
        wrapper.style.backgroundImage = `url('{{ asset('Metronic/assets/media/avatars/blank.png') }}')`;
    }

    function removeImage() {
        const input = document.querySelector('input[name="avatar"]');
        const inputRemove = document.getElementById('avatar_remove');
        const wrapper = document.querySelector('.image-input-wrapper');
        input.value = '';
        inputRemove.value = 1;
        wrapper.style.backgroundImage = `url('{{ asset('Metronic/assets/media/avatars/blank.png') }}')`;
    }
</script>

<script defer type="text/javascript">
    function select2() {
        setTimeout(() => {
            var inputElm = document.querySelector('#kt_tagify_users');
            const usersList = @json(
                $groups->map(function ($group) {
                    return ['value' => $group->id, 'name' => $group->name];
                }));

            function tagTemplate(tagData) {
                return `
        <tag title="${tagData.name}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class=" p-2 me-2 mb-2 ${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn p-1 ms-2' role='button' aria-label='remove tag'></x>
            <span class='tagify__tag-text'>${tagData.name}</span>
        </tag>
    `;
            }

            function suggestionItemTemplate(tagData) {
                return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
            </div>
        </div>
    `;
            }
            // Inicializar Tagify en el select
            var tagify = new Tagify(inputElm, {
                tagTextProp: 'name',
                enforceWhitelist: true,
                skipInvalid: true,
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name']
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: usersList
            });
            // Manejar eventos
            tagify.on('dropdown:show dropdown:updated', onDropdownShow);
            tagify.on('dropdown:select', onSelectSuggestion);
            var addAllSuggestionsElm;

            function onDropdownShow(e) {
                var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
                if (tagify.suggestedListItems.length > 1) {
                    addAllSuggestionsElm = getAddAllSuggestionsElm();
                    dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild);
                }
            }

            function onSelectSuggestion(e) {
                if (e.detail.elm == addAllSuggestionsElm)
                    tagify.dropdown.selectAll.call(tagify);
            }

            function getAddAllSuggestionsElm() {
                return tagify.parseTemplate('dropdownItem', [{
                    class: "addAll",
                    name: "Add all",
                    email: tagify.settings.whitelist.reduce(function(remainingSuggestions, item) {
                        return tagify.isTagDuplicate(item.value) ? remainingSuggestions :
                            remainingSuggestions + 1;
                    }, 0) + " Members"
                }]);
            }
        }, 1000);
        console.log('listo tagi for create');
    }

    document.addEventListener('livewire:load', function() {
        select2();
    });
    document.addEventListener('livewire:update', function() {
        select2();
    });
    document.getElementById('addContactButton').addEventListener('click', function() {
        select2();
    });
</script>

<script defer type="text/javascript">
    function select2edit(groupsSelected) {
        setTimeout(() => {
            var inputElm = document.querySelector('#kt_tagify_users_edit');
            const usersList = @json(
                $groups->map(function ($group) {
                    return ['value' => $group->id, 'name' => $group->name];
                }));

            function tagTemplate(tagData) {
                return `
        <tag title="${tagData.name}"
            contenteditable='false'
            spellcheck='false'
            tabIndex="-1"
            class=" p-2 me-2 mb-2 ${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
            ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn p-1 ms-2' role='button' aria-label='remove tag'></x>
            <span class='tagify__tag-text'>${tagData.name}</span>
        </tag>
    `;
            }

            function suggestionItemTemplate(tagData) {
                return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
            </div>
        </div>
    `;
            }
            // Inicializar Tagify en el select
            var tagify = new Tagify(inputElm, {
                tagTextProp: 'name',
                enforceWhitelist: true,
                skipInvalid: true,
                dropdown: {
                    closeOnSelect: false,
                    enabled: 0,
                    classname: 'users-list',
                    searchKeys: ['name']
                },
                templates: {
                    tag: tagTemplate,
                    dropdownItem: suggestionItemTemplate
                },
                whitelist: usersList
            });
            tagify.removeAllTags();
            const groupIds = groupsSelected.map(group => group.id); 
           
            groupIds.forEach(groupId => {
                const group = usersList.find(user => user.value == groupId);
                if (group) {
                    tagify.addTags([group]);
                }
            });
            // Manejar eventos
            tagify.on('dropdown:show dropdown:updated', onDropdownShow);
            tagify.on('dropdown:select', onSelectSuggestion);
            var addAllSuggestionsElm;

            function onDropdownShow(e) {
                var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
                if (tagify.suggestedListItems.length > 1) {
                    addAllSuggestionsElm = getAddAllSuggestionsElm();
                    dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild);
                }
            }

            function onSelectSuggestion(e) {
                if (e.detail.elm == addAllSuggestionsElm)
                    tagify.dropdown.selectAll.call(tagify);
            }

            function getAddAllSuggestionsElm() {
                return tagify.parseTemplate('dropdownItem', [{
                    class: "addAll",
                    name: "Add all",
                    email: tagify.settings.whitelist.reduce(function(remainingSuggestions, item) {
                        return tagify.isTagDuplicate(item.value) ? remainingSuggestions :
                            remainingSuggestions + 1;
                    }, 0) + " Members"
                }]);
            }
        }, 1000);
        console.log('listo tagi for edit');
    }
    document.addEventListener('livewire:load', function() {
        select2edit([]);
    });
    document.addEventListener('livewire:update', function(event) {
        select2edit();
    });
    document.getElementById('editContactButton').addEventListener('click', function() {
        select2edit();
    });
</script>
