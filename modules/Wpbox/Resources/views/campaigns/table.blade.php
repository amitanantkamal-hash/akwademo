<div class="col-xxl-7 mb-5 mb-xl-10">
    <div class="card card-flush h-md-100">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {{ __($title) }}
                </div>
                @isset($subtitle)
                    <p class="mb-0">{{ $subtitle }}</p>
                @endisset
            </div>
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                @isset($action_link)
                    <a href="{{ $action_link }}" class="btn btn-sm btn-primary">{{ __($action_name) }}</a>
                @endisset
                @isset($action_id)
                    <button id="{{ $action_id }}" class="btn btn-sm btn-primary">{{ __($action_name) }}</button>
                @endisset
                @isset($action_link2)
                    <a href="{{ $action_link2 }}" class="btn btn-sm btn-primary">{{ __($action_name2) }}</a>
                @endisset
                @isset($action_id2)
                    <button id="{{ $action_id2 }}" class="btn btn-sm btn-primary">{{ __($action_name2) }}</button>
                @endisset
                @isset($action_link3)
                    <a href="{{ $action_link3 }}" class="btn btn-sm btn-primary">{{ __($action_name3) }}</a>
                @endisset
                @isset($action_id3)
                    <button id="{{ $action_id3 }}" class="btn btn-sm btn-primary">{!! $action_name3 !!}
                    </button>
                @endisset
                @isset($action_link4)
                    <a href="{{ $action_link4 }}" class="btn btn-sm btn-primary">{{ __($action_name4) }}</a>
                @endisset
                @isset($action_id4)
                    <button id="{{ $action_id4 }}" class="btn btn-sm btn-primary">{{ __($action_name4) }}</button>
                @endisset
                @isset($action_link5)
                    <a target="_blank" href="{{ $action_link5 }}"
                        class="btn btn-sm btn-primary">{{ __($action_name5) }}</a>
                @endisset
                @isset($action_id5)
                    <button id="{{ $action_id5 }}" class="btn btn-sm btn-primary">{{ __($action_name5) }}</button>
                @endisset
                @isset($usefilter)
                    <button id="show-hide-filters" class="btn btn-icon btn-1 btn-sm btn-outline-secondary" type="button">
                        <span class="btn-inner--icon"><i id="button-filters" class="ni ni-bold-down"></i></span>
                    </button>
                @endisset
            </div>
            @isset($usefilter)
                @include('general.filters-client')
            @endisset
        </div>
        <div class="card-body pt-0">
            @if (count($items))
                <div class='table-responsive'>
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Sent at') }}</th>
                                <th>{{ __('Status at') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($setup['items'] as $item)
                                @isset($item->contact)
                                    <tr>
                                        <td>{{ $item->contact->phone }}</td>
                                        <td>{{ $item->contact->name }}</td>
                                        <td>
                                            <span class="short-text">{{ Str::limit($item->value, 20) }}</span>
                                            <span class="full-text" style="display:none;">{{ $item->value }}</span>
                                            <button class="btn btn-link btn-sm toggle-text">See more</button>
                                        </td>
                                        <td>
                                            {{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : '—' }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at ? $item->updated_at->format('d M Y, h:i A') : '—' }}
                                        </td>

                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-warning"></i>
                                                    <span class="badge badge-light-warning">{{ __('PENDING SENT') }}
                                                        {{ __($item->error) }}</span>
                                                </span>
                                            @elseif ($item->status == 1)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-warning"></i>
                                                    <span class="badge badge-light-success">{{ __('SENT') }}
                                                        {{ __($item->error) }}</span>
                                                </span>
                                            @elseif($item->status == 2)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-warning"></i>
                                                    <span class="badge badge-light-success">{{ __('SENT') }}
                                                        {{ __($item->error) }}</span>
                                                </span>
                                            @elseif($item->status == 3)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-info"></i>
                                                    <span class="badge badge-light-dark">{{ __('DELIVERED') }}
                                                        {{ __($item->error) }}</span>
                                                </span>
                                            @elseif($item->status == 4)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-success"></i>
                                                    <span class="badge badge-light-info">{{ __('READ') }}
                                                        {{ __($item->error) }}</span>
                                                </span>
                                            @elseif($item->status == 5)
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-danger"></i>
                                                    <span class="badge badge-light-danger">{{ __('FAILED') }} :
                                                        {{ __($item->error) }} </span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endisset
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <!-- Paginación -->
            <div class="d-flex justify-content-between">
                <div>
                    {{ $setup['items']->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-text').forEach(function(button) {
                button.addEventListener('click', function() {
                    const shortText = this.previousElementSibling
                        .previousElementSibling;
                    const fullText = this.previousElementSibling;

                    if (fullText.style.display === 'none') {
                        fullText.style.display = 'inline';
                        shortText.style.display = 'none';
                        this.textContent = 'See less';
                    } else {
                        fullText.style.display = 'none';
                        shortText.style.display = 'inline';
                        this.textContent = 'See more';
                    }
                });
            });
        });

        function orderTable(status) {
            var table = $('#kt_ecommerce_products_table').DataTable();
            if (status === 'sent') {
                table.column(4).order('asc').draw();
            } else {
                table.column(4).order('des').draw();
            }
        }
    </script>
@endpush
