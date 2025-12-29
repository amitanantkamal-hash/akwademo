<!--begin::Card header (separator style)-->
<!--begin::Card header (compact style)-->
<div class="card-header border-0 border-gray-300 py-2 px-3 bg-body" id="theChatHeader">
    <div class="card-title d-flex justify-content-between align-items-center w-100">
        <!--begin::Contact info-->
        <div class="d-flex align-items-center" v-cloak>
            <!-- Back button (mobile) -->
            <button v-if="mobileChat" @click="showConversations" class="btn btn-icon btn-active-light-primary me-2 p-0"
                style="width: 28px; height: 28px;">
                <i class="fas fa-arrow-left fs-7"></i>
            </button>

            <!-- Avatar -->
            <div class="symbol symbol-35px symbol-circle me-3 position-relative">
                <template v-if="activeChat">
                    <span v-if="!activeChat.avatar && activeChat.name"
                        class="symbol-label bg-light-@{{ getContactColor(activeChat) }} text-@{{ getContactColor(activeChat) }} fs-7 fw-bold">
                        @{{ activeChat.name[0] }}
                    </span>
                    <img v-else-if="activeChat.avatar" :src="activeChat.avatar" class="symbol-img"
                        alt="Contact avatar" />

                    <!-- Country flag -->
                    <div class="position-absolute translate-middle start-100 top-100 ms-n2 mt-n4">
                        <span v-if="activeChat.country" :class="'fi fi-' + activeChat.country.iso2.toLowerCase()"
                            class="border border-1 border-white rounded-circle"
                            style="width: 12px; height: 12px;"></span>
                    </div>
                </template>
            </div>

            <!-- Contact details -->
            <div class="d-flex flex-column lh-sm">
                <a :href="'/contacts/manage/' + activeChat.id + '/edit'"
                    class="text-gray-800 text-hover-primary fs-6 fw-semibold d-flex align-items-center">
                    @{{ activeChat.name }}
                    <span class="badge ms-2 fs-9 text-white" :class="getReplyNotification(activeChat).class">
                        @{{ getReplyNotification(activeChat).text }}
                    </span>

                </a>
                <span class="text-muted fs-8">
                    <i class="fas fa-phone-alt me-1 fs-9"></i>
                    @{{ activeChat.phone }}
                </span>
            </div>
        </div>
        <!--end::Contact info-->

        <!-- Actions -->
        @include('wpbox::chat.actions')
        <!--end::Actions-->
    </div>
</div>
<!--end::Card header-->

<!--end::Card header-->

<!--begin::Card body-->
<div class="card-body p-0 d-flex flex-column">
    <!--begin::Messages scroll-->
    <div class="scroll-y overflow-auto px-6 py-5" style="height: 65vh; min-height: 300px; max-height: 600px;"
        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#theChatHeader" data-kt-scroll-wrappers="#chatMessages" data-kt-scroll-offset="5px"
        ref="scrollableDiv" id="chatMessages">

        <!-- Messages content -->
        @include('wpbox::chat.message')
    </div>
    <!--end::Messages scroll-->

    <!--begin::Input (fixed to bottom)-->

    <!--end::Input-->
</div>
<!--end::Card body-->
</div>
<div>
    @include('wpbox::chat.tools')
</div>
