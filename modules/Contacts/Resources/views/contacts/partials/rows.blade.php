@forelse ($items as $item)
    <tr>
        <td>
            <div class="form-check form-check-sm form-check-custom form-check-solid">
                <input type="checkbox" class="select-item form-check-input" value="{{ $item->id }}">
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                    <a href="manage/{{ $item->id }}/edit">
                        <div class="symbol-label">
                            @if (!empty($item->avatar))
                                <img alt="Avatar {{ $item->name }}" src="{{ $item['avatar'] }}" class="w-100">
                            @else
                                <span class="symbol-label bg-light-primary text-primary fs-4 fw-bolder">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="d-flex flex-column">
                    <a href="manage/{{ $item->id }}/edit" class="text-gray-800 text-hover-primary mb-1">
                        {{ $item->name }} {{ $item->lastname }}
                    </a>
                    {{-- @php
                        $emailField = collect($item['fields'])->firstWhere('name', 'Email');
                        $emailValue = $emailField ? $emailField['pivot']['value'] : null;
                    @endphp
                    <span class="text-muted fs-7">{{ $emailValue ?? 'N/A' }}</span> --}}
                    {{-- Tags display --}}
                    @if ($item->tags && is_array(json_decode($item->tags, true)))
                        <div class="mt-2">
                            @foreach (json_decode($item->tags, true) as $tag)
                                <span class="badge badge-success me-1 mb-1">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </td>
        <td>{{ $item->phone }}</td>
        <td>
            <span
                class="badge fw-bold px-3 py-2 ms-2 {{ $item['subscribed'] == 0 ? 'badge-light-danger' : 'badge-light-success' }}">
                {{ $item['subscribed'] == 0 ? 'Not Subscribed' : 'Subscribed' }}
            </span>
        </td>
        <td class="text-center">
            @if (count($item->groups) > 0)
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @foreach ($item->groups as $group)
                        <a href="{{ route('contacts.index', ['group' => $group->id]) }}"
                            class="badge badge-info fw-bold">
                            {{ $group->name }}
                        </a>
                    @endforeach
                </div>
            @else
                <span class="text-muted fs-8">No Groups</span>
            @endif
        </td>
        <td class="text-end">
            <div class="d-flex justify-content-end">
                @if (config('settings.app_code_name', '') == 'wpbox')
                    <a href="{{ route('campaigns.create', ['contact_id' => $item->id]) }}"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip"
                        title="Chat">
                        <i class="ki-outline ki-messages fs-2"></i>
                    </a>
                @endif

                <a href="javascript:void(0);"
                    class="toggle-subscription-btn btn btn-icon btn-bg-light btn-active-color-{{ $item['subscribed'] == 0 ? 'success' : 'danger' }} btn-sm me-1"
                    data-id="{{ $item->id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ $item['subscribed'] == 0 ? 'Subscribe' : 'Unsubscribe' }}">
                    <i class="ki-outline ki-message-text-2 fs-2"></i>
                </a>


                <a href="manage/{{ $item->id }}/edit"
                    class="btn btn-icon btn-bg-light btn-active-color-info btn-sm me-1" data-bs-toggle="tooltip"
                    title="Edit">
                    <i class="ki-outline ki-pencil fs-2"></i>
                </a>

                <a href="javascript:void(0);"
                    class="delete-contact-btn btn btn-icon btn-bg-light btn-active-color-danger btn-sm"
                    data-id="{{ $item->id }}" data-bs-toggle="tooltip" title="Delete">
                    <i class="ki-outline ki-trash fs-2"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-10">
            <div class="d-flex flex-column align-items-center">
                <i class="ki-outline ki-search-list fs-2x text-muted mb-5"></i>
                <span class="text-muted fs-4">No contacts found</span>
            </div>
        </td>
    </tr>
@endforelse
