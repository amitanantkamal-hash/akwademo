
<div class="modal fade" tabindex="-1" id="kt_modal_edit">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title">{{ __('Edit Group') }}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
            </div>
            <div id="modal-form-content" class="mx-4"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.edit-button').on('click', function() {
            let groupId = $(this).data('id');
            console.log('boton edit');
            $.ajax({ //contacts.groups.edit
                url: `groups/${groupId}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#modal-form-content').html(data);
                },
                error: function(xhr) {
                    console.error('Error al cargar el formulario:', xhr.responseText);
                }
            });
        });
    });
</script>