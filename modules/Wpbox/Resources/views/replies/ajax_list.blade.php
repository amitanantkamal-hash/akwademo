@if (!empty($result))

    @foreach ($result as $key => $item)
        <tr class="item">
            <th scope="col" class="w-20 border-bottom py-4 ps-4">
                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                    <input class="form-check-input select-item" value="{{ $item->id }}" type="checkbox">
                </div>
            </th>

            <td class="border-bottom">
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-column">
                        <a href="#" class="text-gray-800 text-hover-primary fw-6" data-remove-other-active="true"
                            data-active="bg-light-primary" data-result="html" data-content="main-wrapper"
                            data-history="#">{{ $item->name }}</a>
                        @if ($item->type == 1)
                            <span class="text-gray-400 ">{{ Str::limit($item->text, 75, '...') }}</span>
                        @endif
                    </div>
                </div>
            </td>

            @if ($isBot == 2)
                <td class="border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                            <span class="text-gray-600">
                                @if (isset($item->template_id))
                                    {{ $item->bot_type == 2 ? __('Template bot: On exact match') : __('Template bot: When message contains') }}
                                @else
                                    {{ $item->type == 1 ? __('Quick reply') : ($item->type == 2 ? __('Text bot: On exact match') : ($item->type == 4 ? __('Text bot: Welcome') : __('Text bot: When message contains'))) }}
                                @endif
                            </span>
                            <span class="text-gray-600">
                                @if (isset($item->trigger))
                                    {{ __('Trigger by keyword') }}: <span
                                        class="text-info">{{ __($item->trigger) }}</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </td>
                <td class="border-bottom">
                    @if ($item->is_bot_active)
                        <span class="badge badge-light-success fw-4 fs-12 p-6">{{ __('Active') }}</span>
                    @else
                        <span class="badge badge-light-danger fw-4 fs-12 p-6">{{ __('Deactive') }}</span>
                    @endif
                </td>
            @endif
            @if (isset($item->template_id))
                <td class="text-end border-bottom text-nowrap py-4 pe-4">

                    <div class="dropdown dropdown-fixed dropdown-hide-arrow">
                        <!-- ANALYTICS -->
                        <a href="{{ route('campaigns.show', $item->id) }}" class="btn btn-light-info btn-sm">
                            <i class="fas fa-analytics"></i> {{ __('Analytics') }}
                        </a>
                        <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle px-3"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fad fa-th-list pe-0"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- <li>
                            <a href="{{ route('replies.edit', ['reply' => $item->id]) }}" class="dropdown-item"
                                data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                                data-content="main-wrapper"
                                data-history="{{ route('replies.edit', ['reply' => $item->id]) }}"
                                data-call-after="Core.calendar();">
                                <i class="fad fa-pen-square pe-2"></i> {{ __('Edit') }} </a>
                        </li> --}}
                            <li>
                                <!-- Activate and Deactivate -->
                                @if ($item->is_bot_active)
                                    <a href="{{ route('campaigns.deactivatebot', $item->id) }}" class="dropdown-item">
                                        <i class="fa fa-ban pe-2"></i> {{ __('Deactivate') }}
                                    </a>
                                @else
                                    <a href="{{ route('campaigns.activatebot', $item->id) }}" class="dropdown-item">
                                        <i class="fa fa-bolt pe-2"></i> {{ __('Activate') }}
                                    </a>
                                @endif
                            </li>
                            <li>
                                <a href="{{ route('campaigns.delete', $item->id) }}" class="dropdown-item"
                                    data-confirm="Are you sure to delete this items?" data-remove="item"
                                    data-active="bg-light-primary">
                                    <i class="fad fa-trash-alt pe-2"></i> {{ __('Delete') }} </a>
                            </li>
                        </ul>
                    </div>

                </td>
            @else
                <td class="text-end border-bottom text-nowrap py-4 pe-4">
                    <div class="dropdown dropdown-fixed dropdown-hide-arrow">
                        <button class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle px-3"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fad fa-th-list pe-0"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('replies.edit', ['reply' => $item->id]) }}" class="dropdown-item"
                                    data-remove-other-active="true" data-active="bg-light-primary" data-result="html"
                                    data-content="main-wrapper"
                                    data-history="{{ route('replies.edit', ['reply' => $item->id]) }}"
                                    data-call-after="Core.calendar();">
                                    <i class="fad fa-pen-square pe-2"></i> {{ __('Edit') }} </a>
                            </li>
                            @if ($item->type != 1)
                                <li>
                                    <!-- Activate and Deactivate -->
                                    @if ($item->is_bot_active)
                                        <a href="{{ route('replies.deactivatebot', $item->id) }}"
                                            class="dropdown-item">
                                            <i class="fa fa-ban pe-2"></i> {{ __('Deactivate') }}
                                        </a>
                                    @else
                                        <a href="{{ route('replies.activatebot', $item->id) }}" class="dropdown-item">
                                            <i class="fa fa-bolt pe-2"></i> {{ __('Activate') }}
                                        </a>
                                    @endif
                                    <!-- DELETE -->
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('replies.delete', ['reply' => $item->id]) }}" class="dropdown-item"
                                    data-confirm="Are you sure to delete this items?" data-remove="item"
                                    data-active="bg-light-primary">
                                    <i class="fad fa-trash-alt pe-2"></i> {{ __('Delete') }} </a>
                            </li>
                        </ul>
                    </div>
                </td>
            @endif
        </tr>
    @endforeach
@endif
