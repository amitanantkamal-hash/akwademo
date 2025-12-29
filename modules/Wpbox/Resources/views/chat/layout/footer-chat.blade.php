<div class="card-footer d-block" style="padding: 1.5rem">
    <div class="align-items-center">
        <div class="d-flex">
            @include('wpbox::chat.components.message-area')
        </div>
        <div class="d-flex ">
            <div class="flex-fill">
                @include('wpbox::chat.components.emoji')
                <b-dropdown size="lg" variant='link' toggle-class="text-decoration-none" no-caret>
                    <template #button-content>
                        <a href="javascript:void(0);" class="px-3 py-2 d-block btn text-gray-700 btn-active-light"
                        data-bs-toggle="modal" data-bs-target="#fileCaptionModal"
                        data-bs-original-title="{{ __('File manager') }}"><i class="ki-duotone ki-picture fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                    </template>
                    {{-- <b-dropdown-item href="#">
                        @include('wpbox::chat.components.adjunt-image')
                    </b-dropdown-item>
                    <b-dropdown-item href="#">
                        @include('wpbox::chat.components.adjunt-video')
                    </b-dropdown-item>
                    <b-dropdown-item href="#">
                        @include('wpbox::chat.components.adjunt-document')
                    </b-dropdown-item> --}}

                    {{-- <li class="text-nowrap">
                        <a href="javascript:void(0);" class="px-3 py-2 d-block btn text-gray-700 btn-active-light"
                            data-bs-toggle="modal" data-bs-target="#fileCaptionModal"
                            data-bs-original-title="{{ __('File manager') }}"><i class="ki-duotone ki-picture fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i></a>
                    </li> --}}
                </b-dropdown>

                <b-dropdown size="lg" variant='link' toggle-class="text-decoration-none" no-caret>
                    <template #button-content>
                        <i class="ki-duotone ki-exit-right-corner fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </template>
                    <b-dropdown-item href="#">
                        @include('wpbox::chat.components.template')
                    </b-dropdown-item>
                    <b-dropdown-item href="#">
                        @include('wpbox::chat.components.reply')
                    </b-dropdown-item>
                </b-dropdown>
                <input accept="image/*, video/*, audio/*" @change="handleImageChange" type="file" ref="imageInput"
                    style="display: none" />
                <input accept=".pdf, .doc, .docx" @change="handleFileChange" type="file" ref="fileInput"
                    style="display: none" />
                {{-- @include('wpbox::chat.components.notes') --}}
                @include('wpbox::chat.components.products')
                @include('wpbox::chat.components.ai')
            </div>
            <div class="flex-1">
                @include('wpbox::chat.components.send-message')
            </div>
        </div>
    </div>
</div>
{{-- send image or file with caption --}}
@include('wpbox::file_manager.popup_file_caption')
