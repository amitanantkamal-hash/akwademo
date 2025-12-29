{{-- Brij Mohan Negi Update --}}
@if (!empty($result))

    @foreach ($result as $key => $item)
        <tr class="item">

            <th scope="col" class="w-20 border-bottom py-4 ps-4">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input select-item" value="{{ $item->id }}" type="checkbox">
                </div>
            </th>
            <td class="border-bottom">{{ $item->name }}</td>
            <td class="border-bottom">
                @php
                    $options = [];
                    $data = json_decode($item->template);
                    if (!empty($data) && isset($data->templateButtons) && count($data->templateButtons) != 0) {
                        $options = $data->templateButtons;
                    }
                @endphp

                @if (!empty($options))
                    @foreach ($options as $key => $value)
                        @if (isset($value->quickReplyButton))
                            <span
                                class="badge badge-light-primary fw-4 fs-12 p-6">{{ $displayText = $value->quickReplyButton->displayText }}</span>
                        @elseif (isset($value->urlButton))
                            <span
                                class="badge badge-light-primary fw-4 fs-12 p-6">{{ $displayText = $value->urlButton->displayText }}</span>
                        @elseif (isset($value->callButton))
                            <span
                                class="badge badge-light-primary fw-4 fs-12 p-6">{{ $displayText = $value->callButton->displayText }}</span>
                        @endif
                    @endforeach
                @endif
            </td>
            <td class="text-end border-bottom text-nowrap py-4 pe-4">

                <div class="dropdown dropdown-fixed dropdown-hide-arrow">

                    <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle px-3" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fad fa-th-list pe-0"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('button_template.edit', ['button' => $item->id]) }}" class="dropdown-item"
                                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                                data-content="main-wrapper"
                                data-history="{{ route('button_template.edit', ['button' => $item->id]) }}"
                                data-call-after="Core.calendar();">
                                <i class="fad fa-pen-square pe-2"></i> {{ __('Edit') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('button_template.delete', ['button' => $item->id]) }}"
                                class="dropdown-item" data-confirm="Are you sure to delete this items?"
                                data-remove="item" data-active="bg-light-primary">
                                <i class="fad fa-trash-alt pe-2"></i> {{ __('Delete') }} </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach

@endif
