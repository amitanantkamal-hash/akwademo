<b-button variant="link" type="button" v-b-modal.modal-replies class="mx-2">
    <i class="ki-duotone ki-exit-right-corner fs-1" style="pointer-events: none;">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
    <span>{{ __('Quick replies') }}</span>
</b-button>

<b-modal id="modal-replies" scrollable hide-backdrop content-class="shadow" title="">

    <template #modal-header="{ close }">
        <h5>{{ __('Quick replies') }}</h5>


        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" @click="close()">
            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
        </div>
    </template>

    <div class="table-responsive">
        <div>
            <div class="form-group">
                <div class="input-group mb-5">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="ki-duotone ki-magnifier fs-1"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span></i>
                    </span>
                    <input type="text" v-model="filterText" class="form-control" placeholder="{{ __('Search') }}"
                        aria-label="seeach" aria-describedby="basic-addon1">
                </div>
            </div>
            <table class="table align-items-center table-row-dashed table-row-gray-300 mt-5">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800">
                        <th scope="col" class="sort" data-sort="name">{{ __('Reply') }}</th>
                        <th scope="col" class="sort" data-sort="name">
                            <div class="d-flex justify-content-end">
                                <b-button pill class="btn btn-default btn-sm"
                                    href="{{ route('replies.index', ['type' => 'qr']) }}">
                                    <b>{{ __('Manage Quick replies') }}</b>
                                </b-button>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    <tr v-for="(reply, index) in filteredReplies">
                        <td colspan="2" class="">
                            <span @click="setMessage(reply.text)"
                                class="name mb-0 text-sm">@{{ reply.name }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</b-modal>
