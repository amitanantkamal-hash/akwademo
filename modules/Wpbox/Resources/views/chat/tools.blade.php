<div class="card-footer bg-light p-3">
    <div class="d-flex align-items-center w-100">



        <!-- Template / Quick Reply Dropdown -->
        <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret class="ms-2 me-2">
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

        <!-- Product Picker -->
        @include('wpbox::chat.components.products')

        <!-- Hidden File Inputs -->
        <input accept="image/*, video/*, audio/*" @change="handleImageChange" type="file" ref="imageInput" hidden />
        <input accept=".pdf, .doc, .docx" @change="handleFileChange" type="file" ref="fileInput" hidden />

        <!-- Message/Note Input -->
        <div class="flex-grow-1 mx-2">
            <div class="input-group">
                <input v-if="!note" @keyup.enter="sendChatMessage" v-model="activeMessage" type="text"
                    id="message" class="form-control" placeholder="{{ __('Type here') }}"
                    aria-label="{{ __('Message') }}">
                <textarea v-if="note" @keyup.enter="sendChatMessage" v-model="activeNote"
                    class="form-control border-0 rounded-pill bg-light-warning shadow-sm" rows="1"
                    placeholder="{{ __('Type your note here...') }}"></textarea>
            </div>
        </div>

        <!-- Mic Button -->
        <!-- Audio Record Button -->
        <button type="button"
            class="btn btn-light rounded-circle d-flex align-items-center justify-content-center me-2"
            style="width: 42px; height: 42px;" @click="toggleRecording">
            <i v-if="!isRecording" class="ki-duotone ki-google-play fs-2 text-danger">
                <span class="path1"></span><span class="path2"></span>
            </i>

            <i v-else class="ki-duotone ki-cross-square top fs-2 text-danger">
                <span class="path1"></span><span class="path2"></span>
            </i>
        </button>

        <!-- Emoji Button -->
        <b-button variant="link" v-if="!mobileChat" type="button" class="btn btn-outline border-0 ms-2 me-2 px-1"
            id="emoji-btn">
            <i class="ki-duotone ki-happy-emoji fs-1 text-warning">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </b-button>

        <!-- File Manager Dropdown -->
        <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" no-caret class="me-2">
            <template #button-content>
                <a href="javascript:void(0);" class="px-3 py-2 d-block btn text-gray-700 btn-active-light"
                    data-bs-toggle="modal" data-bs-target="#fileCaptionModal"
                    data-bs-original-title="{{ __('File manager') }}">
                    <i class="ki-duotone ki-picture fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </template>
        </b-dropdown>
        <!-- Send Message / Note Button -->
        <div class="ms-2">
            <button v-if="!note"
                class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                style="width: 42px; height: 42px;" @click="sendChatMessage">
                <i class="ki-duotone ki-send fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </button>
            <button v-if="note"
                class="btn btn-success rounded-circle d-flex align-items-center justify-content-center me-2"
                style="width: 42px; height: 42px;" @click="sendNote">
                <i class="ki-duotone ki-send fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </button>
        </div>
    </div>
</div>
