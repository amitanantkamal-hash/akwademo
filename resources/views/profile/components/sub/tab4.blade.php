<div class="card mb-6">
    <div class="card-header cursor-pointer py-8">
        <div class="card-title m-0 w-100 d-flex ">
            <h3 class="flex-1 fw-bold m-0">{{ __('Api Keys') }}</h3>
            <div class="flex-grow-1 d-flex justify-content-end align-items-start flex-wrap">
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-flex btn-info h-40px fs-7 fw-bold" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_campaign">
                        {{ __('New API') }}
                    </a>
                    <a href="{{ config('wpbox.api_docs', 'https://documenter.getpostman.com/view/8538142/2s9Ykn8gvj') }}"
                        class="btn btn-flex btn-info h-40px fs-7 fw-bold" target="_blank">
                        {{ __('Documentation') }}
                    </a>
                    <a href="{{ route('wpbox.api.index', ['type' => 'api']) }}"
                        class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-info bg-body h-40px fs-7 fw-bold">
                        {{ __('Campaings API') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9" id="kt_api_keys_table">
                <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                    <tr>
                        <th class="min-w-175px ps-9">API Name</th>
                        <th class="min-w-250px px-0">API Key</th>
                        <th class="min-w-100px">Created</th>
                        <th class="w-100px">Status</th>
                        <th class="w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fs-6 fw-semibold text-gray-600">
                    <tr>
                        <td class="ps-9">Main Api</td>
                        <td data-bs-target="license" class="ps-0 align-middle">
                            {{ $data_api['token'] }}
                        </td>
                        <td>Nov 01,</td>
                        <td>
                            <span class="badge badge-light-info fs-7 fw-semibold">Active</span>
                        </td>
                        <td>
                            <button data-action="copy"
                                class="btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light copy-token-btn"
                                title="Copy to clipboard">
                                <i class="ki-outline ki-copy fs-2"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .copy-token-btn {
        transition: all 0.3s ease;
    }

    .copy-token-btn.copied {
        background-color: #1bc5bd !important;
        border-color: #1bc5bd !important;
    }

    .copy-token-btn.copied i {
        color: white !important;
    }
</style>
<script>
    document.querySelector('tbody').addEventListener('click', async (event) => {
        const copyBtn = event.target.closest('[data-action="copy"]');

        if (copyBtn) {
            const row = copyBtn.closest('tr');
            const tokenElement = row.querySelector('[data-bs-target="license"]');
            const token = tokenElement.textContent.trim();
            const originalBtnContent = copyBtn.innerHTML;

            try {
                await navigator.clipboard.writeText(token);

                // Visual feedback
                copyBtn.classList.add('copied');
                copyBtn.innerHTML = '<i class="ki-outline ki-check fs-2"></i>';

                // Toast notification
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Token copied to clipboard',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                // Reset button after 2 seconds
                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyBtn.innerHTML = originalBtnContent;
                }, 2000);

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to copy token',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }
    });
</script>
