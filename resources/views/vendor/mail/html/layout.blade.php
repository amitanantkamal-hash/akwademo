<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" data-bs-theme="light">

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"> <!--end::Fonts-->
    <link href="{{ asset('Metronic/assets') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('Metronic/assets') }}/css/style.bundle.css" rel="stylesheet" type="text/css">

    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-52YZ3XGZJ6');
    </script>
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-column-fluid">

            <div class="scroll-y flex-column-fluid px-10 py-10 my-10" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true"
                style="background-color: rgb(213, 217, 226); --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc; height: 586px;">
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>

                <div id="#kt_app_body_content"
                    style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                    <div
                        style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                            height="auto" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center;">
                                        <div style="text-align:center; margin:0 15px 34px 15px">
                                            <div>
                                                <a href="https://sendinai.com/" rel="noopener" target="_blank">
                                                    <img alt="Logo"
                                                        src="{{ asset('img/sendinai-icon.svg') }}"
                                                        class="h-25px ms-3" style="height: 25px;" />

                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="display: flex; justify-content: center; margin:0 60px 0 60px">
                                    <td align="start" valign="start" style="padding-bottom: 10px;">
                                        <span
                                            style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                            {{ Illuminate\Mail\Markdown::parse($slot) }}
                                            <span>
                                                <span
                                            style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                            {{ $subcopy ?? '' }}
                                            <span>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center"
                                        style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                        <span>
                                            {{ $footer ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('Metronic/assets') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('Metronic/assets') }}/js/scripts.bundle.js"></script>
</body>

</html>
