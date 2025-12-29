@php
    $current_page = Request::segment(1);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Anantkamal Wademo') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="google-site-verification" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="shortcut icon" href="{{ asset(env('FAVICON_URL', 'backend/Assets/img/dotflo-icon-round.png')) }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('backend/Assets/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('backend/Assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}

    <link href="{{ asset('metronic56/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('vendor/IntlTelInput/intlTelInput.css') }}">
    <script src="{{ asset('vendor/IntlTelInput/intlTelInput.min.js') }}"></script>

</head>

<body id="gomint_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root">
        <style>
            body {
                background-color: rgb(255, 255, 255);
            }

            [data-bs-theme="dark"] body {
                background-color: rgb(45, 48, 50);
            }
        </style>
        <style>
            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .animated-bounce {
                animation: bounce 1.5s infinite ease-in-out;
            }

            :root {
                --theme-color: {{ env('THEME_COLOR', '#000000') }};
                --theme-color-header-light: {{ env('THEME_COLOR_HEADER_LIGHT', '#000000') }};
                --theme-color-sidebar-light: {{ env('THEME_COLOR_SIDEBAR_LIGHT', '#000000') }};
                --theme-color-header-dark: {{ env('THEME_COLOR_HEADER_DARK', '#000000') }};
                --theme-color-sidebar-dark: {{ env('THEME_COLOR_SIDEBAR_DARK', '#000000') }};
                --theme-color-menu-selected: {{ env('THEME_COLOR_MENU_SELECTED', '#0c382a') }};
                --theme-menu-active-color: {{ env('THEME_COLOR_MENU_ACTIVE', '#1B1C22') }};
                --bs-btn-color: {{ env('THEME_BTN_COLOR', '#ffffff') }};
                --bs-info-active: {{ env('THEME_COLOR_ACTIVE', '#5014D0') }};
                --bs-btn-bg: {{ env('THEME_BTN_BG', '#7239EA') }};
                --bs-btn-border-color: {{ env('THEME_BTN_BORDER_COLOR', '#7239EA') }};
                --bs-btn-hover-color: {{ env('THEME_BTN_HOVER_COLOR', '#ffffff') }};
                --bs-btn-hover-bg: {{ env('THEME_BTN_HOVER_BG', '#6130c7') }};
                --bs-btn-hover-border-color: {{ env('THEME_BTN_HOVER_BORDER_COLOR', '#5b2ebb') }};
                --bs-btn-focus-shadow-rgb: {{ env('THEME_BTN_FOCUS_SHADOW_RGB', '135, 87, 237') }};
                --bs-btn-active-color: {{ env('THEME_BTN_ACTIVE_COLOR', '#ffffff') }};
                --bs-btn-active-bg: {{ env('THEME_BTN_ACTIVE_BG', '#5b2ebb') }};
                --bs-btn-active-border-color: {{ env('THEME_BTN_ACTIVE_BORDER_COLOR', '#562bb0') }};
                --bs-btn-active-shadow: {{ env('THEME_BTN_ACTIVE_SHADOW', 'none') }};
                --bs-btn-disabled-color: {{ env('THEME_BTN_DISABLED_COLOR', '#ffffff') }};
                --bs-btn-disabled-bg: {{ env('THEME_BTN_DISABLED_BG', '#7239EA') }};
                --bs-btn-disabled-border-color: {{ env('THEME_BTN_DISABLED_BORDER_COLOR', '#7239EA') }};
                --bs-info-rgb: {{ env('THEME_LINK_COLOR', '#7139ea') }};
                --bs-primary-rgb: {{ env('THEME_LINK_COLOR', '#7139ea') }};
                --bs-dark-rgb: {{ env('THEME_COLOR_DARK', '#7139ea') }};
                --bs-dark: {{ env('THEME_COLOR_DARK', '#7139ea') }};
                --bs-primary: {{ env('THEME_BTN_COLOR', '#7139ea') }};
                --bs-all-theme-highlight: {{ env('THEME_HIGHLIGHT', '#7139ea') }};
                --bs-text-primary: {{ env('THEME_HIGHLIGHT', '#7139ea') }};
            }
        </style>

        @if ($current_page != 'activation')
            <div class="d-flex flex-column flex-column-fluid flex-lg-row">

                <div class="d-flex flex-column flex-root" id="gomint_app_root">

                    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

                        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">

                            <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                                <div class="w-lg-500px p-10">
                                    {{ $slot }}
                                </div>
                            </div>

                            <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">

                                <div class="me-10">


                                    <img data-gomint-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                                        src="{{ asset('Metronic/assets/media/flags/india.svg') }}" alt="" />

                                    <span data-gomint-element="current-lang-name" class="me-1">English</span>


                                </div>

                                <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                    <a href="{{ route('terms-conditions') }}" target="_blank">Terms</a />

                                    <a href="{{ route('privacy-policy') }}" target="_blank">Privacy</a>

                                    <a href="/contact" target="_blank">Contact Us</a>
                                </div>
                            </div>
                        </div>

                       {{-- <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                            style="background-image: url({{ asset('backend/Assets/img/auth-bg.png') }})">  --}}
                             <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                            style="background-image: url({{ asset('backend/Assets/img/auth-main-bg.png') }})"> 
                            {{-- Required for anantkamalwademo --}}

                            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">

                                <a href="#" class="mb-0 mb-lg-12">
                                      <img alt="Logo" src="{{ asset('backend/Assets/img/logo.png') }}"
                                        class="h-60px h-lg-125px" /> 
                                </a>
                                 {{-- <img class="animated-bounce d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                                    src="{{ asset('backend/Assets/img/section-cta_1.svg') }}" alt="" />  --}}
                                 <img class="animated-bounce d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                                    src="{{ asset('backend/Assets/img/auth-image.png') }}" alt="" /> 
                                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                                    Grow your business on WhatsApp
                                </h1>
                                <div class="d-none d-lg-block text-white fs-base text-center">
                                    Personalize communication, and sell<br> more with the <a href="#"
                                        class="opacity-75-hover text-warning fw-bold me-1">WhatsApp Business API</a>

                                    platform that automates marketing,<br /> and sales, service and support.
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            @else
                <div class="d-flex flex-column flex-center flex-column-fluid">
                    <div class="d-flex flex-column flex-center text-center p-10">
                        {{ $slot }}
                    </div>
                </div>
        @endif
    </div>
    </div>
    <script>
        var hostUrl = "/assets";
    </script>

    <script src="{{ asset('backend/Assets/js/plugins.bundle.js') }}"></script>
    <script src="{{ asset('backend/Assets/js/scripts.bundle.js') }}"></script>
    @if ($current_page == 'login')
        <script src="{{ asset('backend/Assets/js/authentication/sign-in/general.js') }}"></script>
    @elseif($current_page == 'forgot-password')
        <script src="{{ asset('backend/Assets/js/authentication/reset-password/reset-password.js') }}"></script>
    @elseif($current_page == 'verify-otp')
        <script src="{{ asset('vendor/IntlTelInput/intlTelInput.min.js') }}"></script>
        <script>
            const input = document.querySelector("#new-phone");
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
                utilsScript: "{{ asset('vendor/IntlTelInput/utils.js') }}",
            });
            input.addEventListener("countrychange", function() {
                // do something with iti.getSelectedCountryData()
                country_code.value = iti.getSelectedCountryData().dialCode;
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var input = document.querySelector("#new-phone");

                // Initialize intlTelInput
                var iti = window.intlTelInput(input, {
                    separateDialCode: true,
                    initialCountry: "in",
                    preferredCountries: ["in", "us", "gb"],
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
                });

                window.updatePhone = function() {
                    let phoneNumber = iti.getNumber();
                    let isValid = iti.isValidNumber();
                    let validationError = iti.getValidationError();

                    // Get modal and elements
                    let modalElement = document.getElementById("changeNumberModal");
                    let modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    let alertMessageDiv = modalElement.querySelector(".alertMessageModel");
                    let mainAlertMessage = document.querySelector(".alertMessage");
                    let phoneDisplay = document.querySelector("#phoneDisplay");

                    alertMessageDiv.innerHTML = ""; // Clear old alerts

                    // Validation check
                    if (!isValid) {
                        let errorMsg = "Invalid phone number.";
                        if (validationError === 1) errorMsg = "Invalid country code.";
                        if (validationError === 2) errorMsg = "Phone number too short.";
                        if (validationError === 3) errorMsg = "Phone number too long.";
                        if (validationError === 4) errorMsg = "Invalid phone number format.";

                        alertMessageDiv.innerHTML = `<div class="alert alert-danger">${errorMsg}</div>`;
                        return;
                    }

                    // Send request to backend
                    fetch("{{ route('update-phone') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    "content")
                            },
                            body: JSON.stringify({
                                phone: phoneNumber
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status == "success") {

                                modalInstance.hide();
                                modalElement.classList.remove("show");
                                modalElement.style.display = "none";
                                document.body.classList.remove("modal-open");
                                document.querySelector(".modal-backdrop")?.remove();


                                if (phoneDisplay) {
                                    let maskedNumber = phoneNumber.length > 6 ?
                                        "*".repeat(phoneNumber.length - 6) + phoneNumber.slice(-6) :
                                        phoneNumber;
                                    phoneDisplay.textContent = maskedNumber;
                                }
                                timer = "{{ config('otp.otp_timer') }}"; // Reset the timer 
                                resendButton.classList.add('d-none');
                                otpText.setAttribute('style', 'display:inline');
                                countdownElement.style.display = 'inline'; // Show countdown again
                                startTimer(); // Restart the timer

                                mainAlertMessage.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Phone number updated and OTP resent successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                            } else {
                                // Handle error
                                let errorMsg = data.message || "Something went wrong.";
                                if (data.error === "number_exists") {
                                    errorMsg = "WhatsApp number already in use.";
                                }

                                alertMessageDiv.innerHTML = `<div class="alert alert-danger">${errorMsg}</div>`;
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alertMessageDiv.innerHTML =
                                `<div class="alert alert-danger">Network error. Please try again.</div>`;
                        });
                };

                window.openChangeModal = function() {
                    let modal = new bootstrap.Modal(document.getElementById('changeNumberModal'));
                    modal.show();
                };

            });
        </script>


        <script>
            let timer = "{{ config('otp.otp_timer') }}"; // Timer in seconds 
            const countdownElement = document.getElementById('countdown');
            const resendButton = document.getElementById('resend-otp-button');
            const otpText = document.getElementById('otp-text');

            const verifyButton = document.getElementById('verify-otp-button');
            const resendLoader = document.getElementById('resend-loader');
            const verifyLoader = document.getElementById('verify-loader');

            function startTimer() {
                let countdown = setInterval(() => {
                    timer--;
                    let minutes = Math.floor(timer / 60);
                    let seconds = timer % 60;
                    seconds = seconds < 10 ? '0' + seconds : seconds;
                    countdownElement.innerText = minutes + ':' + seconds;
                    if (timer <= 0) {
                        clearInterval(countdown);
                        countdownElement.style.display = 'none';
                        otpText.setAttribute('style', 'display:none ! important');
                        resendButton.classList.remove('d-none');
                    }
                }, 1000);
            }

            startTimer();

            function resendOtp() {
                resendLoader.style.display = 'inline'; // Show loader
                resendButton.classList.add('disabled');
                fetch('{{ route('resend.otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        resendLoader.style.display = 'none';
                        if (data.message) {
                            $(".alertMessage").html(
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' + data
                                .message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            )
                            timer = "{{ config('otp.otp_timer') }}"; // Reset the timer 
                            resendButton.classList.add('d-none');
                            otpText.setAttribute('style', 'display:inline');
                            countdownElement.style.display = 'inline'; // Show countdown again
                            startTimer(); // Restart the timer
                        } else if (data.error) {
                            $(".alertMessage").html(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data
                                .error +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                            )
                        }
                        resendButton.classList.remove('disabled');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resendLoader.style.display = 'none'; // Hide loader on error
                        resendButton.classList.remove('disabled');
                    });
            }

            // function verifyOtp() {
            //     const otp = document.getElementById('otp').value;

            //     if (!otp || otp.length !== 6) {
            //         $(".alertMessage").html(
            //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter a valid 6-digit OTP.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
            //         )
            //         return;
            //     }
            //     verifyButton.classList.add('disabled');

            //     verifyLoader.style.display = 'inline'; // Show loader

            //     fetch('{{ route('verify-otp') }}', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             body: JSON.stringify({
            //                 otp: otp
            //             })
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             verifyButton.classList.remove('disabled');
            //             verifyLoader.style.display = 'none'; // Hide loader
            //             if (data.message) {
            //                 $(".alertMessage").html(
            //                     '<div class="alert alert-success alert-dismissible fade show" role="alert">' + data
            //                     .message +
            //                     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
            //                 )
            //                 window.location.href = '{{ route('home') }}';
            //             } else if (data.error) {
            //                 $(".alertMessage").html(
            //                     '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + data
            //                     .error +
            //                     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
            //                 )

            //             }
            //         })
            //         .catch(error => {
            //             verifyButton.classList.remove('disabled');
            //             console.error('Error:', error);
            //             verifyLoader.style.display = 'none'; // Hide loader on error
            //         });
            // }
        </script>
        <script src="{{ asset('backend/Assets/js/otp-verfiy.js') }}"></script>
    @elseif($current_page == 'reset-password')
        <script src="{{ asset('backend/Assets/js/authentication/reset-password/new-password.js') }}"></script>
    @elseif($current_page == 'register')
        <script src="{{ asset('backend/Assets/js/authentication/sign-up/general.js') }}"></script>
    @elseif($current_page == 'resend_activation')
        <script src="{{ asset('backend/Assets/js/authentication/reset-password/resend-activation-code.js') }}"></script>
    @endif
</body>

</html>
