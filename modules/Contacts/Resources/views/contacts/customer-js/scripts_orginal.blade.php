<script type="text/javascript">
    $(document).ready(function() {
        //  $('#bulk-action-button').hide();
        var loadedData = {};
        var model = [];
        // Handle "Select All" checkbox
        $('#select-all').change(function() {
            $('.select-item').prop('checked', $(this).is(':checked'));
            updateSelectedCount();
            toggleBulkActionButton();
        });

        $('.button-danger').click(function(event) {
            event.preventDefault();
        });

        $('.reloadButton').click(function() {
            location.reload();
        });

        $('#modal-errores-carga').on('hidden.bs.modal', function(e) {
            location.reload();
        });

        // Handle individual checkbox change
        $(document).on('change', '.select-item', function() {
            console.log('Checkbox clicked'); // Debugging log
            updateSelectedCount();
            toggleBulkActionButton();
        });

        // Update the number of selected items
        function updateSelectedCount() {
            var count = $('.select-item:checked').length;
            console.log(count);
            $('#selected-count').text(count === 0 ? 'No records selected' : `${count} records selected`);
        }

        // Handle "Move to group" action
        $('#move-to-group').click(function(e) {
            e.preventDefault();
            $('#move-to-group-modal').modal('show');
        });

        $(document).on('click', '#move-to-group-confirm', function() {
            let selectedContacts = getSelectedIds();

            // Get selected groups
            let selectedGroups = [];
            $('input[name="groupAdd"]:checked').each(function() {
                selectedGroups.push($(this).val());
            });
            console.log("Selected Groups: ", selectedGroups);

            // Validation: Ensure contacts and groups are selected
            if (selectedContacts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Contacts Selected!',
                    text: 'Please select at least one contact to proceed.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            if (selectedGroups.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Group Selected!',
                    text: 'Please select at least one group to proceed.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Confirmation before proceeding
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to add ${selectedContacts.length} contacts to selected groups.`,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Add!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show progress overlay
                    showProgressOverlay();

                    // Disable button during process
                    $('#move-to-group-confirm').prop('disabled', true).text('Processing...');

                    // Send AJAX request
                    $.ajax({
                        url: "{{ route('contacts.assign-to-group') }}", // Update with actual route
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedContacts,
                            group_ids: selectedGroups, // Send all selected groups
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                            }).then(() => {
                                $('#move-to-group-modal').modal('hide');
                                location.reload(); // Reload to update UI
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                .message : "Something went wrong!";
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: errorMsg,
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        complete: function() {
                            hideProgressOverlay();
                            $('#move-to-group-confirm').prop('disabled', false)
                                .text('Add Selected');
                        }
                    });
                }
            });
        });



        // Function to show progress overlay
        function showProgressOverlay() {
            $('body').append(`
        <div id="progress-overlay" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;">
            <div style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
                <span style="font-size: 18px; font-weight: bold;">Processing...</span><br>
                <img src="https://i.gifer.com/ZZ5H.gif" width="50">
            </div>
        </div>
    `);
        }

        // Function to hide progress overlay
        function hideProgressOverlay() {
            $('#progress-overlay').remove();
        }



        // Handle "Remove from group" action
        $('#remove-from-group').click(function(e) {
            e.preventDefault();
            if ($('.select-item:checked').length === 0) {
                alert(
                    'No items selected');
                return;
            }
            $('#remove-from-group-modal').modal('show');
        });

        $(document).on('click', '#remove-from-group-confirm', function() {
            let selectedContacts = getSelectedIds(); // Function to get selected contacts
            let selectedGroups = [];

            // Get selected groups from checkboxes
            $('input[name="groupremove"]:checked').each(function() {
                selectedGroups.push($(this).val());
            });

            // Validation: Ensure contacts and groups are selected
            if (selectedContacts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Contacts Selected!',
                    text: 'Please select at least one contact to proceed.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            if (selectedGroups.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Group Selected!',
                    text: 'Please select at least one group to proceed.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Confirmation before removing contacts
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to remove ${selectedContacts.length} contacts from the selected groups.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show processing overlay to prevent user interaction

                    // Show progress overlay
                    showProgressOverlay();

                    // Disable button and change text
                    $('#remove-from-group-confirm').prop('disabled', true).text(
                        'Processing...');

                    // AJAX request to remove contacts from multiple groups
                    $.ajax({
                        url: "{{ route('contacts.remove-from-group') }}", // Update with your route
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedContacts, // Array of contact IDs
                            group_ids: selectedGroups // Array of group IDs
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                            }).then(() => {
                                $('#move-to-group-modal').modal('hide');
                                location
                                    .reload(); // Reload to reflect changes
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                .message : "Something went wrong!";
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: errorMsg,
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        complete: function() {
                            // Remove processing overlay
                            hideProgressOverlay();
                            // Re-enable button
                            $('#remove-from-group-confirm').prop('disabled', false)
                                .text('Remove Selected');
                        }
                    });
                }
            });
        });

        $(document).on('click', '#subscribe-contact', function() {
            let selectedContacts = getSelectedIds(); // Function to get selected contacts

            // Validation: Ensure contacts are selected
            if (selectedContacts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Contacts Selected!',
                    text: 'Please select at least one contact to proceed.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Confirmation before subscribing contacts
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to subscribe ${selectedContacts.length} contacts.`,
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Subscribe!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show processing state

                    // Show progress overlay
                    showProgressOverlay();

                    // AJAX request to subscribe contacts
                    $.ajax({
                        url: "{{ route('contacts.bulk.subscribe') }}", // Update with your actual route
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedContacts
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                            }).then(() => {
                                location
                                    .reload(); // Reload to reflect changes
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                .message : "Something went wrong!";
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: errorMsg,
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        complete: function() {

                            hideProgressOverlay();

                        }
                    });
                }
            });
        });

        $(document).on('click', '#unsubscribe-contact', function() {
            let selectedContacts = getSelectedIds(); // Function to get selected contacts

            // Validation: Ensure contacts are selected
            if (selectedContacts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Contacts Selected!',
                    text: 'Please select at least one contact to unsubscribe.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Confirmation before unsubscribing
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to unsubscribe ${selectedContacts.length} contacts.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Unsubscribe!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show processing indicator
                    // Show progress overlay
                    showProgressOverlay();

                    // AJAX request to unsubscribe contacts
                    $.ajax({
                        url: "{{ route('contacts.bulk.unsubscribe') }}", // Update with actual route
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedContacts,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                            }).then(() => {
                                location
                                    .reload(); // Reload to reflect changes
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                .message : "Something went wrong!";
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: errorMsg,
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        complete: function() {
                            hideProgressOverlay();
                        }
                    });
                }
            });
        });

        $(document).on('click', '#delete-selected', function() {
            let selectedContacts = getSelectedIds(); // Function to get selected contact IDs

            // Validate: Ensure at least one contact is selected
            if (selectedContacts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Contacts Selected!',
                    text: 'Please select at least one contact to remove.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Confirmation before deleting contacts
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to permanently remove ${selectedContacts.length} contacts.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show processing indicator
                    showProgressOverlay();

                    // AJAX request to remove contacts
                    $.ajax({
                        url: "{{ route('contacts.bulk.remove') }}", // Update with your route
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedContacts,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                            }).then(() => {
                                location
                                    .reload(); // Reload the page to reflect changes
                            });
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseJSON ? xhr.responseJSON
                                .message : "Something went wrong!";
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: errorMsg,
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        complete: function() {
                            hideProgressOverlay();
                        }
                    });
                }
            });
        });


        // Show or hide bulk action button
        function toggleBulkActionButton() {
            if ($('.select-item:checked').length > 0) {
                $('#bulk-action-button').show();
            } else {
                $('#bulk-action-button').hide();
            }
        }

        // Get IDs of all selected items
        function getSelectedIds() {
            return $('.select-item:checked').map(function() {
                return $(this).val();
            }).get();
        }
    });
    $('#kt_modal_import').on('show.bs.modal', function() {
        $("#barra-progress").hide(0)
    })

    function handleLoadedData() {
        $('#kt_modal_import').modal('hide');
        $('#StepTwoModal').modal('show');
        var contactModel = [
            'phone',
            'name',
            'lastname',
            'email',
            'country',
            'company',
            'address',
        ];
        console.log(loadedData);

        // Loop through the array and append the values to the .field elements
        $.each(loadedData.headers, function(index, value) {
            var contactDiv = $(
                '<div class="align-items-center contact d-flex  justify-content-between w-100"></div>');
            var fieldDiv = $('<div class="field fs-6 form-label fw-bold text-gray-900"></div>').text(value);
            var selectDiv = $(`<select name="field" data-control="select2" data-placeholder="Select a reference" id="select-header-fields-${index}" class="form-select w-50 select">
        <option selected hidden value="">Select a reference</option>
        </select>`);
            $.each(contactModel, function(field, valfield) {
                selectDiv.append($('<option></option>').text(valfield).attr('id', valfield).attr(
                    'value', valfield))
            });
            contactDiv.append(fieldDiv, selectDiv);
            $('#handleFields').append(contactDiv);
        });
    }

    $("#validateButton").click(function(e) {
        let isValid = true;
        let previous = [];
        // Select all select elements with the "select" class
        model = [];
        $(".select").each(function(index) {
            if ($(this).val() == '') {
                $(".validate-alert").html(
                    `<div class="alert alert-warning" role="alert">You must select an option in all columns.</div>`
                );
                isValid = false;
                return false;
            }

            if (previous.includes($(this).val())) {
                $(".validate-alert").html(
                    `<div class="alert alert-danger" role="alert">You cannot assign the same field to two columns.</div>`
                );
                isValid = false;
                return false;
            }

            model.push($(this).val());
            previous.push($(this).val());
        });
        if (isValid) {
            console.log(model)
            stepThree();
        }
    });

    function stepThree() {
        $('#StepTwoModal').modal('hide');
        $('#StepThreeModal').modal('show');
    }

    $("#importContacts").click(function(e) {
        const contact = $('#contactGroup').val();
        const groups = <?php echo $groupsM; ?>;
        var formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val()); // Add CSRF token
        formData.append('data', {
            contacts: loadedData,
            group: contact
        });

        $.ajax({
            url: '/contacts/import',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: JSON.stringify({
                contacts: loadedData,
                group: contact,
                fields: model
            }),
            cache: false,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            beforeSend: function() {
                $('#StepThreeModal').modal('hide');
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                console.log(response);
                if (!response) {
                    return;
                }
                handleResults(response);
            },
            error: function(error) {
                $('#loadingModal').modal('hide');
                // Handle upload error
                console.error(error);
                alert('There was an error uploading the contacts.');
            }
        });

        $('#StepThreeModal').modal('hide');
    });

    function handleResults(data) {
        $('#loadingModal').modal('hide');
        if (data.success) {
            console.log({
                success: data.success.length
            })
            displaySuccess(data.success.length);
        } else {
            displaySuccess(0);
        }
        if (data.errors) {
            displayErrors(data.errors);
        }
        $('#resultModal').modal('show');
    }

    function displayErrors(errorArray) {
        $('#result').removeClass('d-none');
        // Create a container for the alerts
        let alertContainer = $('#alert-container');

        // Clear any existing alerts
        alertContainer.empty();

        let alert = $(
            '<div class="alert alert-dismissible border border-danger border-dashed bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">'
        );



        // Contenido
        alert.append(`
    <div class="text-center">
        <h1 class="fw-bold mb-5">Errores al cargar</h1>
        <div class="separator separator-dashed border-danger  opacity-25 mb-5"></div>
        <div class="mb-5 text-gray-900">
        <a href="#" class="fw-bold text-danger me-1">${errorArray.length}</a> errors were found while loading the contact list. </strong>.<br/>

        </div>
        <div class="d-flex flex-center flex-wrap">

        <a href="#" class="btn btn-danger m-2"  data-bs-toggle="modal" data-bs-target="#modal-errores-carga">Ver errores</a>
        </div>
    </div>
    `);
        if (errorArray.length)
            alertContainer.append(alert);


        $("#data-errores").empty();
        //Iterate through the error array and create an alert for each error
        errorArray.forEach(error => {
            let column = $('<div class="col-sm-6 col-md-3 pe-3"></div>');
            let alert = $(
                '<div class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10" role="alert">'
            );

            // Icono
            alert.append(`
            <i class="ki-duotone ki-message-text-2 fs-2hx text-danger me-4 mb-5 mb-sm-0">
            <span class="path1"></span><span class="path2"></span><span class="path3"></span>
            </i>
        `);

            // Contenido
            alert.append(`
            <div class="d-flex flex-column pe-0 pe-sm-10">
            <span class="mb-1">${error}</span>
            </div>
        `);

            // Botón de cierre
            alert.append(`
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-danger">
                <span class="path1"></span><span class="path2"></span>
            </i>
            </button>
        `);
            column.append(alert);
            $("#data-errores").append(column);
        });



        /*errorArray.forEach(error => {
          let alert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">');
          alert.text(error);
          alert.append('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
          $("#data-errores").append(alert);
        });*/

        // Ensure the alert container is visible
        alertContainer.show();
    }

    function displaySuccess(data) {
        $('#result').removeClass('d-none');
        // Create a container for the alerts
        let successContainer = $('#success-container');

        // Clear any existing alerts
        successContainer.empty();

        let alert = $(
            '<div class="alert  bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10" role="alert">'
        );

        // 
        alert.append(`
    <i class="ki-duotone ki-message-text-2 fs-2hx text-primary me-4 mb-5 mb-sm-0">
        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
    </i>
    `);

        // 
        alert.append(`
    <div class="d-flex flex-column pe-0 pe-sm-10">
        <h5 class="mb-1">Information</h5>
        <span>New contacts <a href="#" class="fw-bold me-1">${data}</a> have been registered</span>
    </div>
    `);

        successContainer.append(alert);
        successContainer.show();
    }


    $('#csv').change(function(e) {
        $("#barra-progress").show('slow')
        var file = e.target.files[0];

        if (!file) {
            return; // No file selected
        }

        // Validate file type (optional)
        if (!/\.(csv|xls|xlsx)$/.test(file.name)) {

            Swal.fire({
                text: "Invalid file type. Please select a CSV or Excel file.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-info"
                }
            });
            $("#barra-progress").hide()
            return;
        }

        var formData = new FormData();
        formData.append('csv', file);
        formData.append('_token', $('input[name="_token"]').val()); // Add CSRF token

        // Add any other form data if needed (e.g., selected group)
        /* var groupId = $('#group').val();
        if (groupId) {
          formData.append('group', groupId);
        } */
        loadedData = {};
        $.ajax({
            url: '/contacts/read',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Show loading indicator
                // $('#submit-btn').prop('disabled', true); // Disable submit button (optional)
            },
            success: function(response) {
                if (!response) {
                    $("#barra-progress").hide()
                    return;
                }
                // Handle successful upload
                /* console.log({
                  headers: response.headers,
                  body: response.data
                }); */
                loadedData = response;
                handleLoadedData();
                // Show success message or redirect
            },
            error: function(error) {
                $("#barra-progress").hide()
                // Handle upload error
                console.error(error);
                alert('There was an error uploading the file.');
            },
            complete: function() {
                // Hide loading indicator
                // $('#submit-btn').prop('disabled', false); // Enable submit button (optional)
            }
        });

    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize tooltips
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            .forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

        // Handle subscription toggle clicks
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.toggle-subscription-btn');
            if (button) {
                const contactId = button.dataset.id;
                const url = `manage/togglesubs/${contactId}`;
                const row = button.closest('tr'); // Get the table row

                fetch(url, {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === "success") {
                            const isSubscribed = data.new_status;
                            console.log('New subscription status:', isSubscribed);

                            // 1. Update the toggle button
                            button.classList.toggle('btn-active-color-success', !isSubscribed);
                            button.classList.toggle('btn-active-color-danger', isSubscribed);

                            // Update tooltip text
                            const newTitle = isSubscribed ? 'Unsubscribe' : 'Subscribe';
                            button.setAttribute('title', newTitle);

                            // Update tooltip instance
                            const tooltip = bootstrap.Tooltip.getInstance(button);
                            if (tooltip) {
                                tooltip.setContent({
                                    '.tooltip-inner': newTitle
                                });
                            }

                            // 2. Update the status badge - FIXED VERSION
                            const statusBadge = row.querySelector('.badge');
                            if (statusBadge) {
                                console.log('Current badge element:', statusBadge.outerHTML);

                                // Remove all possible status classes
                                statusBadge.classList.remove(
                                    'badge-light-success',
                                    'badge-light-danger',
                                    'bg-success',
                                    'bg-danger'
                                );

                                // Add the correct status class
                                statusBadge.classList.add(isSubscribed ? 'badge-light-success' :
                                    'badge-light-danger');

                                // Find the text element within the badge (in case it's nested)
                                let textElement = statusBadge.querySelector('span') || statusBadge;

                                // Update the displayed text
                                textElement.textContent = isSubscribed ? 'Subscribed' :
                                    'Not Subscribed';

                                console.log('Updated badge element:', statusBadge.outerHTML);
                            }

                            // 3. Show success message
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            throw new Error(data.message || 'Unknown error');
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: error.message || "Operation failed",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            .forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

        // Handle delete button clicks
        document.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.delete-contact-btn');
            if (deleteBtn) {
                e.preventDefault();
                const contactId = deleteBtn.dataset.id;
                const deleteUrl = `manage/del/${contactId}`;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading indicator
                        Swal.fire({
                            title: 'Deleting...',
                            html: 'Please wait while we delete the contact',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Make the delete request
                        fetch(deleteUrl, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.redirected) {
                                    // If Laravel redirects (as in your backend code)
                                    window.location.href = response.url;
                                } else {
                                    return response.json();
                                }
                            })
                            .then(data => {
                                if (data && data.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The contact has been deleted.',
                                        'success'
                                    ).then(() => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the contact.',
                                    'error'
                                );
                            });
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('export-excel-btn').addEventListener('click', function() {
            const exportUrl = this.dataset.exportUrl;
            const modal = new bootstrap.Modal(document.getElementById('exportProgressModal'));
            const progressBar = document.getElementById('exportProgressBar');
            const progressText = document.getElementById('exportProgressText');

            // Show modal
            modal.show();

            // Reset progress
            progressBar.style.width = '0%';
            progressText.textContent = 'Preparing export...';

            // Create a hidden iframe for the download
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            // AJAX request to start export
            const xhr = new XMLHttpRequest();
            xhr.open('GET', exportUrl, true);
            xhr.responseType = 'blob';

            xhr.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = `Exporting... ${Math.round(percentComplete)}%`;
                }
            };

            xhr.onload = function() {
                if (this.status === 200) {
                    const blob = this.response;
                    const url = URL.createObjectURL(blob);

                    iframe.src = url;

                    // Clean up
                    setTimeout(function() {
                        URL.revokeObjectURL(url);
                        document.body.removeChild(iframe);
                        modal.hide();
                    }, 100);
                } else {
                    modal.hide();
                    alert('Export failed: ' + this.statusText);
                    document.body.removeChild(iframe);
                }
            };

            xhr.onerror = function() {
                modal.hide();
                alert('Export failed. Please try again.');
                document.body.removeChild(iframe);
            };

            xhr.send();
        });
    });
</script>