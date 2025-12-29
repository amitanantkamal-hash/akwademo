<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.querySelector('#kt_profile_details_view .btn-primary');
        const discardButton = document.getElementById('buttonDiscard');
        const detailsView = document.getElementById('kt_profile_details_view');
        const editView = document.getElementById('kt_profile_details_view_edit');
        // Evento para el botón "Edit Profile"
        editButton.addEventListener('click', function() {
            // Ocultar la vista de detalles
            detailsView.style.display = 'none';
            // Mostrar la vista de edición
            editView.style.display = 'block';
        });
        // Evento para el botón "Discard"
        discardButton.addEventListener('click', function() {
            // Mostrar la vista de detalles
            detailsView.style.display = 'block';
            // Ocultar la vista de edición
            editView.style.display = 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.querySelector('#kt_profile_billing_view .btn-primary');
        const discardButton = document.getElementById('buttonDiscardbilling');
        const detailsView = document.getElementById('kt_profile_billing_view');
        const editView = document.getElementById('kt_profile_billing_view_edit');
        // Evento para el botón "Edit Profile"
        editButton.addEventListener('click', function() {
            // Ocultar la vista de detalles
            detailsView.style.display = 'none';
            // Mostrar la vista de edición
            editView.style.display = 'block';
        });
        // Evento para el botón "Discard"
        discardButton.addEventListener('click', function() {
            // Mostrar la vista de detalles
            detailsView.style.display = 'block';
            // Ocultar la vista de edición
            editView.style.display = 'none';
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos de la interfaz
        const changeEmailButton = document.querySelector('#kt_signin_email_button .btn-light');
        const changePasswordButton = document.querySelector('#kt_signin_password_button .btn-light');
        const emailView = document.getElementById('kt_signin_email');
        const emailEditView = document.getElementById('kt_signin_email_edit');
        const passwordView = document.getElementById('kt_signin_password');
        const passwordEditView = document.getElementById('kt_signin_password_edit');
        // Evento para el botón "Change Email"
        changeEmailButton.addEventListener('click', function() {
            emailView.classList.add('d-none'); // Ocultar la vista de email
            changeEmailButton.classList.add('d-none');
            emailEditView.classList.remove('d-none'); // Mostrar la vista de edición de email
        });
        // Evento para el botón "Reset Password"
        changePasswordButton.addEventListener('click', function() {
            passwordView.classList.add('d-none'); // Ocultar la vista de contraseña
            changePasswordButton.classList.add('d-none');
            passwordEditView.classList.remove('d-none'); // Mostrar la vista de edición de contraseña
        });
        // Manejo del botón "Cancel" en el formulario de email
        const cancelEmailButton = document.getElementById('kt_signin_cancel');
        cancelEmailButton.addEventListener('click', function() {
            changeEmailButton.classList.remove('d-none');
            emailEditView.classList.add('d-none'); // Ocultar la vista de edición de email
            emailView.classList.remove('d-none'); // Mostrar la vista de email
        });
        // Manejo del botón "Cancel" en el formulario de contraseña
        const cancelPasswordButton = document.getElementById('kt_password_cancel');
        cancelPasswordButton.addEventListener('click', function() {
            passwordEditView.classList.add('d-none'); // Ocultar la vista de edición de contraseña
            changePasswordButton.classList.remove('d-none');
            passwordView.classList.remove('d-none'); // Mostrar la vista de contraseña
        });
    });
</script>
<link type="text/css" href="{{ asset('vendor') }}/flag-icons/css/flag-icons.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('custom/css/telinput.css') }}">
<script src="{{ asset('custom/js/telinput.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.querySelector("#phone_form");
        const country_code = document.querySelector("#country_code");
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "{{ asset('custom/js/telinput.js') }}",
        });
        if (input.value) {
            const countryData = iti.getSelectedCountryData();
            country_code.value = countryData.dialCode;
        }
        input.addEventListener("countrychange", function() {
            country_code.value = iti.getSelectedCountryData().dialCode;
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const input = document.querySelector("#phone_billing");
        const country_code = document.querySelector("#country_code_billing");
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
            utilsScript: "{{ asset('custom/js/telinput.js') }}",
        });
        if (input.value) {
            const countryData = iti.getSelectedCountryData();
            country_code.value = countryData.dialCode;
        }
        input.addEventListener("countrychange", function() {
            country_code.value = iti.getSelectedCountryData().dialCode;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.querySelector("#phone-flag");
        const flagDiv = document.querySelector("#flag");
        // Inicializar intl-tel-input
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: callback => {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback("us"));
            },
        });
        // Cargar la bandera al cargar la página
        if (input.value) {
            const countryData = iti.getSelectedCountryData();
            loadFlag(countryData.iso2); // Cargar la bandera
        }
        // Función para cargar la bandera
        function loadFlag(countryId) {
            bandera.style.backgroundImage =
                `url('https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.6.0/flags/4x3/${countryId}.svg')`;
        }
        // Actualizar la bandera cuando cambie el país
        input.addEventListener("countrychange", function() {
            const countryData = iti.getSelectedCountryData();
            loadFlag(countryData.iso2); // Cargar la bandera actualizada
        });
    });
</script>

<script>
    document.getElementById('updatePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto
        // Obtener los valores de los campos
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        // Validación básica
        let valid = true;
        clearErrors();
        if (!currentPassword) {
            showError('currentPasswordError', 'Current password is required.');
            valid = false;
        }
        if (!newPassword) {
            showError('newPasswordError', 'New password is required.');
            valid = false;
        }
        if (newPassword !== confirmPassword) {
            showError('confirmPasswordError', 'Passwords do not match.');
            valid = false;
        }
        if (valid) {
            // Enviar los datos al servidor
            fetch('/update-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // Asegúrate de tener el token CSRF
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        password: newPassword,
                        password_confirmation: confirmPassword
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            // Manejar errores del servidor
                            if (data.errors) {
                                for (const [key, value] of Object.entries(data.errors)) {
                                    showError(`${key}Error`, value[0]);
                                }
                            } else {
                                alert('An error occurred while updating the password.');
                            }
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Password updated successfully.');
                        document.getElementById('updatePasswordForm').reset();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    function clearErrors() {
        const errorElements = document.querySelectorAll('.invalid-feedback');
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si hay un hash en la URL
        const hash = window.location.hash;
        if (hash) {
            // Ocultar todas las pestañas
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            // Mostrar la pestaña correspondiente
            const activeTab = document.querySelector(hash);
            if (activeTab) {
                activeTab.classList.add('show', 'active');
            }
        }
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
