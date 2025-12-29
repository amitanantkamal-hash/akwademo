@extends('layouts.app-client')
@section('topcss')
@endsection

@section('content')
    <link href="{{ asset('backend/Assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/Assets/plugins/jquery/jquery.min.js') }}"></script>
    <link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets/File_manager/css/file_manager.css') }}">
    <div class="main-wrapper flex-grow-1 n-scroll d-flex file-manager" data-loading="false">
        <form class="fm-content fm-form flex-grow-1">
            <div class="fm-progress-bar bg-primary"></div>
            <div class="fm-list row px-2 py-4 ajax-load-scroll m-l-0 m-r-0 n-scroll align-content-start"
                data-url="{{ route('file-manager.load_files') }}" data-scroll="ajax-load-scroll"
                data-call-after="File_manager.lazy();">
                <div
                    class="fm-empty text-center fs-90 text-muted h-100 d-flex flex-column align-items-center justify-content-center">
                    <img class="mh-190 mb-4" alt="" src="{{ asset('backend/Assets/img/empty.png') }}">
                </div>
            </div>
            <div class="ajax-loading text-center bg-primary"></div>
        </form>

        @include('wpbox::file_manager.sidebar')
    </div>
@endsection

@section('js')
    <script>
        const isStaff = @json(auth()->user()->hasRole('staff'));
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("✅ JavaScript Loaded!");

            document.addEventListener("click", async function(event) {
                let button = event.target.closest(".copy-path-btn");
                if (!button) return;

                event.preventDefault();
                event.stopPropagation();

                let filePath = button.getAttribute("data-path");
                console.log("Copying path:", filePath);

                if (!filePath) {
                    console.error("❌ File path is empty!");
                    return;
                }

                try {
                    await navigator.clipboard.writeText(filePath);
                    Swal.fire({
                        icon: "success",
                        title: "Copied!",
                        text: "File path copied to clipboard.",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    let icon = button.querySelector("i");
                    if (icon) {
                        icon.classList.replace("fa-copy", "fa-check");
                        setTimeout(() => icon.classList.replace("fa-check", "fa-copy"), 1500);
                    }
                } catch (err) {
                    console.error("❌ Clipboard copy failed:", err);
                    Swal.fire({
                        icon: "error",
                        title: "Copy Failed!",
                        text: "Could not copy the file path. Please try again.",
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    </script>
    
    {{-- <script src="{{ asset('backend/Assets/File_manager/plugins/jquery.lazy/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('backend/Assets/plugins/izitoast/izitoast.min.js') }}"></script>
    <script src="{{ asset('backend/Assets/plugins/emojionearea/emojionearea.min.js') }}"></script>
    <script src="{{ asset('backend/Assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/Assets/plugins/webui-popover/webui-popover.js') }}"></script>
    <script src="{{ asset('backend/Assets/js/layout.js') }}"></script>
    <script src="{{ asset('backend/Assets/js/core.js') }}"></script>

    <script>
        File_manager.lazy();
    </script> --}}
@endsection
