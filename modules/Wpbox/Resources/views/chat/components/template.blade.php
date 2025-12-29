<b-button variant="link" class="mx-2" v-if="!mobileChat" v-b-modal.modal-templates>
    <i class="ki-duotone ki-paintbucket fs-1" style="pointer-events: none;">
        <span class="path1"></span>
        <span class="path2"></span>
        <span class="path3"></span>
    </i>
    <span>{{ __('Send Template') }}</span>
</b-button>

<b-modal id="modal-templates" scrollable hide-backdrop content-class="shadow">
    <template #modal-header="{ close }">
        <h5>{{ __('Send Template') }}</h5>


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
                    <input type="text" v-model="filterTemplates" class="form-control"
                        placeholder="{{ __('Search') }}" aria-label="seeach" aria-describedby="basic-addon1">
                </div>
            </div>
            <table class="table align-items-center table-row-dashed table-row-gray-300 mt-5">
                <thead>
                    <tr class="fw-bold fs-6 text-gray-800">
                        <th scope="col" class="sort" data-sort="name">{{ __('Template') }}</th>

                    </tr>
                </thead>
                <tbody class="list">
                    <tr v-for="(template) in filteredTemplates">
                        <td class="">
                            <a
                                :href="'/campaigns/create?template_id=' + template.id + '&send_now=on&contact_id=' + activeChat
                                    .id"><span
                                    class="name mb-0 text-sm" target="_blank">@{{ template.name }}</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</b-modal>
