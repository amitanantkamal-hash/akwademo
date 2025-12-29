<div class="scrollable-content" style="height: calc(80vh - 100px); overflow-y: auto; padding: 1.5rem;">
    <!-- Close Button (added at top right) -->
    <!-- Avatar Section -->
    <div class="text-center mb-6">
        <a :href="'/contacts/manage/' + activeChat.id + '/edit'" class="d-inline-block position-relative symbol symbol-50px"
            target="_blank">
            <div v-cloak v-if="activeChat && activeChat.name && activeChat.name[0] && (!activeChat.avatar)"
                class="symbol-label bg-success fs-2x fw-bold text-white">
                @{{ activeChat.name[0] }}
            </div>
            <img v-cloak v-if="activeChat && activeChat.avatar" alt="Contact Avatar" :src="activeChat.avatar"
                class="symbol-label" />
        </a>
    </div>

    <!-- Contact Info -->
    <div class="text-center mb-6">
        <a :href="'/contacts/manage/' + activeChat.id + '/edit'" class="text-gray-800 text-hover-primary" target="_blank">
            <h4 class="fw-bold mb-2">@{{ activeChat.name }}</h4>
        </a>
        <div class="text-muted mb-4">@{{ activeChat.country.name }}</div>
        <div>
            <span v-for="group in activeChatGroups" :key="group.id"
                class="badge badge-light-primary me-2 mb-1">@{{ group.name }}</span>
        </div>
    </div>

    <!-- Tags Management Section -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Tags') }}</h6>
        <div class="card card-bordered">
            <div class="card-body">
                <!-- Current Tags -->
                <div class="d-flex flex-wrap gap-2 mb-4" v-if="activeChat.tags && getTagsArray().length > 0">
                    <div v-for="tag in getTagsArray()" :key="tag"
                        class="badge badge-light-success d-flex align-items-center py-2 px-3 mt-2">
                        @{{ tag }}
                        <button type="button" class="btn btn-icon btn-sm ms-2" @click="removeTag(tag)">
                            <i class="ki-outline ki-cross fs-5"></i>
                        </button>
                    </div>
                </div>
                <div v-else class="text-muted mb-4">
                    {{ __('No tags added') }}
                </div>

                <!-- Add Tag Input -->
                <div class="input-group mb-2">
                    <input type="text" class="form-control" placeholder="{{ __('Add new tag') }}" v-model="newTag"
                        @keyup.enter="addTag">
                    <button class="btn btn-primary" type="button" @click="addTag">
                        <i class="ki-outline ki-plus fs-2 me-1"></i> {{ __('Add') }}
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Groups Management Section -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Groups') }}</h6>
        <div class="card card-bordered">
            <div class="card-body">
                <!-- Current Groups -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <div v-for="group in activeChatGroups" :key="group.id"
                        class="badge badge-light-primary d-flex align-items-center py-2 px-3 mt-2">
                        @{{ group.name }}
                        <button type="button" class="btn btn-icon btn-sm ms-2" @click="removeGroup(group.id)">
                            <i class="ki-outline ki-cross fs-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Add to Group Dropdown -->
                <div class="d-flex align-items-center mb-2">
                    <b-dropdown variant="light" class="w-100"
                        toggle-class="d-flex align-items-center justify-content-between">
                        <template #button-content>
                            <div class="d-flex align-items-center">
                                <i class="ki-outline ki-plus fs-3 me-2"></i>
                                <span class="fs-6 fw-semibold text-gray-800">{{ __('Add to Group') }}</span>
                            </div>
                        </template>
                        <b-dropdown-item v-for="group in availableGroups" :key="group.id"
    @click="addGroup(group.id)" class="d-flex align-items-center py-3">
    <span class="fs-6 text-gray-800">@{{ group.name }}</span>
</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned To - Fixed UI -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Assigned to') }}</h6>
        <b-dropdown size="sm" variant="light" class="w-100"
            toggle-class="d-flex align-items-center justify-content-between bg-light rounded">
            <template #button-content>
                <div class="d-flex align-items-center">
                    <span class="fs-6 fw-semibold text-gray-800 me-2">@{{ getAssignedUser(activeChat) }}</span>
                    <i class="ki-outline ki-down fs-5 text-muted"></i>
                </div>
            </template>
            <b-dropdown-item v-for="(user, key) in users" :key="key" @click="assignUser(key, activeChat.id)"
                class="d-flex align-items-center py-3">
                <span class="fs-6 text-gray-800">@{{ user }}</span>
            </b-dropdown-item>
        </b-dropdown>
    </div>

    <!-- Contact Details -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Contact Details') }}</h6>
        <div class="card card-bordered">
            <div class="card-body">
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Name') }}</span>
                    <strong class="text-gray-800">@{{ activeChat.name }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Phone') }}</span>
                    <strong class="text-gray-800">@{{ activeChat.phone }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Email') }}</span>
                    <strong class="text-gray-800">@{{ activeChat.email }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Country') }}</span>
                    <strong class="text-gray-800">@{{ activeChat.country.name }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3">
                    <span class="text-muted">{{ __('Subscribed') }}</span>
                    <span v-cloak
                        :class="['badge', activeChat.subscribed == '1' ? 'badge-light-success' : 'badge-light-warning']">
                        @{{ activeChat.subscribed == '1' ? 'Subscribed' : 'Not Subscribed' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Details -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Chat Details') }}</h6>
        <div class="card card-bordered">
            <div class="card-body">
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Created at') }}</span>
                    <strong class="text-gray-800">@{{ momentDaySimple(activeChat.created_at) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Status') }}</span>
                    <span v-cloak
                        :class="['badge', activeChat.resolved_chat == '0' ? 'badge-light-primary' : 'badge-light-success']">
                        @{{ activeChat.resolved_chat == '0' ? 'Open' : 'Closed' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Last Activity') }}</span>
                    <strong class="text-gray-800">@{{ momentDaySimple(activeChat.updated_at) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-bottom">
                    <span class="text-muted">{{ __('Language') }}</span>
                    <strong class="text-gray-800">@{{ activeChat.language }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3">
                    <span class="text-muted">{{ __('AI Bot Enabled') }}</span>
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" v-model="activeChat.enabled_ai_bot"
                            @change="updateAIBotStatus" :checked="activeChat.enabled_ai_bot == '1'">
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Fields -->
    <div class="mb-6">
        <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">{{ __('Custom Fields') }}</h6>
        <div class="card card-bordered">
            <div class="card-body">
                <div v-for="field in activeChatCustomFields" :key="field.id"
                    class="d-flex justify-content-between py-3" :class="{ 'border-bottom': !$last }">
                    <span class="text-muted">@{{ field.name }}</span>
                    <strong class="text-gray-800">@{{ field.value }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Button -->
    <div class="d-grid">
        <a :href="'/contacts/manage/' + activeChat.id + '/edit'" class="btn btn-primary" target="_blank">
            <i class="ki-outline ki-pencil fs-2 me-2"></i> {{ __('Edit Contact') }}
        </a>
    </div>
</div>

<style>
    /* Additional styles for the tags and groups section */
    .badge-light-primary {
        background-color: #f0f6ff;
        color: #3b71ca;
        border-radius: 0.475rem;
        transition: all 0.3s;
    }

    .badge-light-primary:hover {
        background-color: #e1ebff;
    }

    .btn-icon {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        padding: 0;
    }

    .btn-icon:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .input-group .btn {
        z-index: 1;
    }

    .d-flex.flex-wrap.gap-2 {
        gap: 0.5rem;
        flex-wrap: wrap;
    }
</style>
