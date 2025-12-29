@if ($company->getConfig('show_links_tab', true))
    <b-dropdown size="lg" variant='link' toggle-class="text-decoration-none" no-caret>
        <template #button-content>
            <i class="ki-duotone ki-screen fs-1" style="pointer-events: none;">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
        </template>

        @foreach ($fetcherModules as $alias => $module)
            @php
                $icon = '';
                if ($module['name'] == 'shopifylist') {
                    $icon = asset('custom/imgs/shopify.svg');
                }
                if ($module['name'] == 'woolist') {
                    $icon = asset('custom/imgs/woocommerce.svg');
                }
            @endphp
            <b-dropdown-item href="#">
                <button type="button" class="btn btn-outline mb-2 w-100"
                    @click="openLinkFetcher('{{ $alias }}');">
                    <span>
                        {{-- <img class="w-20px h-20x" alt="{{ $module['name'] }}" src="{{ $icon }}" /> </span> --}}
                    <span>
                        {{ $module['name'] }}
                    </span>
                </button>
            </b-dropdown-item>
        @endforeach
    </b-dropdown>
    <b-modal id="modal-link-fetcher" scrollable hide-backdrop content-class="shadow" v-if="selectedFetcher" size="lg">
        <template #modal-header="{ close }">
            <h5>@{{  fetcherModules[selectedFetcher].name }}</h5>
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" @click="close()">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </template>
        <div class="table-responsive">
            <div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">🔍</span>
                        </div>
                        <input type="text" v-model="filterFetcher" class="form-control"
                            placeholder="{{ __('Search') }}" aria-label="search" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div v-if="fetcherModules[selectedFetcher].data.length > 0">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">{{ __('Items') }}</th>
                                <th scope="col" class="sort" data-sort="name">
                                    <div class="d-flex justify-content-end">
                                        <b-button pill class="btn btn-default btn-sm"
                                            @click="refreshLinkData(selectedFetcher)" :disabled="isRefreshingLinks">
                                            <span v-if="isRefreshingLinks">{{ __('Loading new data') }}</span>
                                            <span v-else>{{ __('Reload data') }}</span>
                                        </b-button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr v-for="item in filteredFetcherData" @click="sendLinkMessage(item.link)"
                                class="cursor-pointer hover:bg-gray-50">
                                <td class="p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <img :src="item.image" class="rounded shadow"
                                                style="width: 64px; height: 64px; object-fit: cover;">
                                        </div>
                                        <div style="width: 100%">
                                            <h5 class="mb-1" style="word-wrap: break-word">
                                                @{{ item.title }}</h5>
                                            <p class="text-muted mb-0 small">@{{ item.description }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </b-modal>
@endif
