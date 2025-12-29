@extends('layouts.app-client', ['title' => __('CSV Contacts Import')])

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--begin::Container-->
    <div id="kt_app_content_container" class="container-xxl px-4">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">{{ __('CSV Contacts Import') }}
                        <span class="d-block text-muted pt-2 font-size-sm">Upload your contacts via CSV file</span>
                    </h3>
                </div>
                <div class="card-toolbar d-flex align-items-center gap-3">

                    <!-- Text + Download Button Group -->
                    <div class="d-flex flex-column me-3">
                        <a id="downloadFormatBtn" class="btn btn-danger font-weight-bold">
                            <i class="ki ki-download fs-2 me-2"></i> Download Format CSV
                        </a>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ route('contacts.index') }}" class="btn btn-light-primary font-weight-bold">
                        <i class="ki ki-arrow-back fs-2 me-2"></i> Back to Contacts
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('partials.flash')

                <!--begin::Form-->
                <form id="importForm" class="form" enctype="multipart/form-data">
                    @csrf

                    <!--begin::File Input-->
                    <div class="form-group row align-items-center">
                        <label class="col-form-label text-right col-lg-3 col-sm-12">CSV File *</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="dropzone dropzone-default dropzone-primary" id="fileDropzone"
                                style="min-height: 150px; border: 2px dashed #E1E1EF; background: #F3F6F9; border-radius: 6px; cursor: pointer; padding: 20px; text-align: center; margin-top: 0.5rem;">
                                <div class="dropzone-msg dz-message needsclick">
                                    <h3 class="dropzone-msg-title">Drop files here or click to upload
                                        <small class="form-text text-muted mt-2"><br>CSV files only (max 10MB)</small>
                                    </h3>
                                </div>
                                <input type="file" name="csv" id="fileInput" class="d-none" accept=".csv" required>
                            </div>
                            <div id="filePreview" class="mt-3" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <i class="flaticon-file-2 text-primary icon-2x mr-3"></i>
                                    <div>
                                        <div class="font-weight-bold" id="fileName"></div>
                                        <div class="text-muted" id="fileSize"></div>
                                        <div class="progress progress-sm mt-2" id="fileProgress"
                                            style="height: 5px; width: 200px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="form-text text-muted mt-2">Required headers: phone, name (custom fields are
                                optional)</span>
                        </div>
                    </div>
                    <!--end::File Input-->

                    <!--begin::Group Select-->
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-right col-lg-3 col-sm-12">Group to insert into</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="form-control" id="group" name="group_id" style="width: 100%; height: 20vh;">
                                <option value="">Select a group (optional)</option>
                                @foreach ($groups as $value => $text)
                                    <option value="{{ $value }}">{{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--end::Group Select-->

                    <!--begin::Create Lead Option-->
                    {{-- <div class="form-group row mb-4">
                        <label class="col-form-label text-right col-lg-3 col-sm-12"></label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="createLeadCheckbox" name="create_lead"
                                    value="1">
                                <label class="form-check-label" for="createLeadCheckbox">Yes, also create a Lead for each
                                    contact</label>
                            </div>
                        </div>
                    </div> --}}

                    <!--begin::Progress-->
                    <div class="form-group row" id="progress-container" style="display: none;">
                        <label class="col-form-label text-right col-lg-3 col-sm-12">Upload Progress</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="progress progress-lg">
                                <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-muted" id="progress-text">0% completed</span>
                            <div class="mt-2" id="stats-container">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Rows processed:</span>
                                    <span class="font-weight-bold" id="processed-rows">0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Valid contacts:</span>
                                    <span class="font-weight-bold text-success" id="valid-contacts">0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Duplicate contacts:</span>
                                    <span class="font-weight-bold text-warning" id="duplicate-contacts">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Progress-->

                    <!--begin::Submit-->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" id="submitBtn" class="btn btn-primary font-weight-bold mr-2">
                                    <i class="ki ki-upload"></i> Import Contacts
                                </button>
                                {{-- <button type="reset" class="btn btn-light-primary font-weight-bold">Cancel</button> --}}
                            </div>
                        </div>
                    </div>
                    <!--end::Submit-->
                </form>
                <!--end::Form-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->

    <script>
        $(document).ready(function() {
            // Initialize Select2 properly
            $('#group').select2({
                placeholder: "Select a group (optional)",
                allowClear: true,
                width: '100%'
            });

            // File input handling
            const fileInput = document.getElementById('fileInput');
            const fileDropzone = document.getElementById('fileDropzone');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileProgress = document.getElementById('fileProgress').querySelector('.progress-bar');

            // Handle click on dropzone
            fileDropzone.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    const file = this.files[0];
                    updateFilePreview(file);
                }
            });

            // Handle drag and drop
            fileDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#3699FF';
                this.style.background = '#F1FAFF';
            });

            fileDropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#E1E1EF';
                this.style.background = '#F3F6F9';
            });

            fileDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#E1E1EF';
                this.style.background = '#F3F6F9';

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    const file = e.dataTransfer.files[0];
                    updateFilePreview(file);
                }
            });

            function updateFilePreview(file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileProgress.style.width = '0%';
                filePreview.style.display = 'flex';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission
            // Form submission
            $('#importForm').on('submit', function(e) {
                e.preventDefault();

                let file = fileInput.files[0];
                let groupId = $('#group').val();

                if (!file) {
                    Swal.fire({
                        title: "Error!",
                        text: "Please select a file to upload",
                        icon: "error",
                        confirmButtonText: "OK",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    return;
                }

                let chunkSize = 500 * 1024; // 500KB per chunk
                let totalChunks = Math.ceil(file.size / chunkSize);
                let currentChunk = 0;
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 1800000); // 30 min timeout

                // Show SweetAlert progress modal
                Swal.fire({
                    title: 'Uploading...',
                    html: `<div class="progress progress-sm mt-2">
                    <div id="modal-progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
               </div>
               <div class="mt-2"><span id="modal-progress-text">0%</span> completed</div>`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    showConfirmButton: false
                });

                function uploadChunk() {
                    if (currentChunk >= totalChunks) {
                        Swal.close();
                        Swal.fire({
                            title: "Success!",
                            text: "Contacts imported successfully!",
                            icon: "success",
                            confirmButtonText: "View Contacts",
                            cancelButtonText: "Stay Here",
                            showCancelButton: true,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-light-primary"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('contacts.index') }}";
                            } else {
                                $('#importForm')[0].reset();
                                $('#group').val(null).trigger('change');
                                filePreview.style.display = 'none';
                                $('#progress-container').hide();
                            }
                        });

                        clearTimeout(timeoutId);
                        return;
                    }

                    let start = currentChunk * chunkSize;
                    let end = Math.min(start + chunkSize, file.size);
                    let chunk = file.slice(start, end);

                    let formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('csv_chunk', chunk);
                    formData.append('chunk_index', currentChunk);
                    formData.append('total_chunks', totalChunks);
                    formData.append('group_id', groupId);

                    fetch("{{ route('contacts.import.chunk') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Accept": "application/json"
                            },
                            signal: controller.signal,
                            cache: "no-cache",
                            redirect: "follow"
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                currentChunk++;
                                let progress = data.progress || Math.round((currentChunk /
                                    totalChunks) * 100);

                                // Update modal progress
                                $('#modal-progress-bar').css('width', progress + '%');
                                $('#modal-progress-text').text(progress + '%');

                                // Update inline UI too if needed
                                $('#progress-bar').css('width', progress + '%');
                                $('#progress-text').text(progress + '% completed');
                                fileProgress.style.width = progress + '%';

                                if (data.stats) {
                                    $('#processed-rows').text(data.stats.processed_rows || '0');
                                    $('#valid-contacts').text(data.stats.valid_contacts || '0');
                                    $('#duplicate-contacts').text(data.stats.duplicate_contacts || '0');
                                }

                                uploadChunk();
                            } else {
                                Swal.close();
                                Swal.fire({
                                    title: "Error!",
                                    text: data.message || "An error occurred during upload",
                                    icon: "error",
                                    confirmButtonText: "OK",
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            let message = error.name === 'AbortError' ?
                                "The upload took too long and was cancelled" :
                                "An unexpected error occurred: " + error.message;

                            Swal.fire({
                                title: "Error!",
                                text: message,
                                icon: "error",
                                confirmButtonText: "OK",
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                            console.error("Error:", error);
                        });
                }

                uploadChunk();
            });

        });

        //Download contact format csv
        //code added bt amit pawar 09-12-2025
        document.getElementById('downloadFormatBtn').addEventListener('click', function () {
            const fileUrl = "/uploads/csv/contact.csv";

            fetch(fileUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error("File not found");
                }
                return response.blob();
            })
            .then(blob => {
                const downloadLink = document.createElement("a");
                downloadLink.href = URL.createObjectURL(blob);
                downloadLink.download = "contact_format.csv"; // Name user sees
                downloadLink.click();
            })
            .catch(error => {
                console.error(error);

                Swal.fire({
                    title: "File Missing",
                    text: "Format file could not be found. Please contact admin.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        });
        //end
    </script>
@endsection
