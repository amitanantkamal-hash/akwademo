<style>
    .wave-indicator {
        position: relative;
        display: inline-block;
        width: 10px;
        height: 10px;
    }

    .wave-circle {
        position: absolute;
        top: 0;
        left: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .wave-ripple {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: rgba(var(--bs-primary-rgb), 0.3);
        transform: translate(-50%, -50%);
        animation: wave-pulse 1.5s infinite;
    }

    .wave-ripple:nth-child(3) {
        animation-delay: 0.75s;
    }

    @keyframes wave-pulse {
        0% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.6;
        }

        100% {
            transform: translate(-50%, -50%) scale(3);
            opacity: 0;
        }
    }
</style>
<div class="card-body pt-5">
    <!--begin::Contacts container-->
    <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px"
        v-cloak>

        <!--begin::Contact list-->
        <template v-for="contact in contacts" :key="contact.id">
            <div class="d-flex flex-stack py-4 hover-effect"
                :class="{ 'bg-light-primary rounded border border-primary': contact.isActive }"
                @click="setCurrentChat(contact.id)">

                <!--begin::User info-->
                <div class="d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px symbol-circle me-5 position-relative">
                        <img v-if="contact.avatar" alt="Pic" :src="contact.avatar" class="avatar shadow" />
                        <span v-else
                            class="symbol-label bg-light-@{{ contact.color }} text-@{{ contact.color }} fs-3">
                            @{{ contact.name ? contact.name[0] : '?' }}
                        </span>

                        <!-- WhatsApp Icon -->
                        <span class="position-absolute top-0 end-0 translate-middle p-1 rounded-circle">
                            <img src="{{ asset('custom/imgs/whatsapp/whatsapp-icon.svg') }}" alt="WhatsApp"
                                width="14" height="14">
                        </span>
                    </div>

                    <!--end::Avatar-->

                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                            @{{ contact.name }}
                            <span v-if="contact.is_last_message_by_contact === 1" class="svg-icon svg-icon-1 ms-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none">
                                    <path opacity="0.3" d="M10.4 4L5 9.4L1.4 5.8L0 7.2L5 12.2L11.8 5.4L10.4 4Z"
                                        fill="currentColor" />
                                    <path opacity="0.3"
                                        d="M15.4 4L10 9.4L9.4 8.8L8 10.2L13 15.2L13.6 14.6L16 7.2L15.4 4Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </a>
                        <!--begin::Last message-->
                        <div class="d-flex align-items-center mt-1">
                            <!-- Unread indicator -->
                            <span v-if="contact.is_last_message_by_contact === 1" class="me-2">
                                <svg width="10" height="10" viewBox="0 0 512 512" class="text-success"
                                    xmlns="http://www.w3.org/2000/svg" style="display:block;">
                                    <circle cx="256" cy="256" r="256" fill="currentColor" />
                                </svg>
                            </span>

                            <!-- Last message text -->
                            <span class="text-muted fw-semibold fs-7"
                                :class="{ 'text-gray-800 fw-bold': contact.is_last_message_by_contact === 1 }">
                                @{{ contact.last_message }}
                            </span>
                        </div>
                        <!--end::Last message row-->
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::User info-->

                <!--begin::Time and status-->
                <div class="d-flex flex-column align-items-end">
                    <span class="text-muted fs-8 fw-semibold mb-1">
                        @{{ momentIt(contact.last_reply_at) }}
                    </span>
                    <span v-if="contact.unread_count > 0" class="badge badge-sm badge-circle badge-primary">
                        @{{ contact.unread_count }}
                    </span>
                </div>
                <!--end::Time and status-->
            </div>

            <!--begin::Separator-->
            <div class="separator separator-dashed"></div>
            <!--end::Separator-->
        </template>
        <!--end::Contact list-->

        <!--begin::Empty state-->
        <div v-if="contacts.length === 0" class="text-center py-10">
            <span class="svg-icon svg-icon-4x opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.3"
                        d="M20 3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H20C20.9 21 21 20.1 21 19V5C21 3.9 20.9 3 20 3ZM8 12C7.4 12 7 11.6 7 11C7 10.4 7.4 10 8 10C8.6 10 9 10.4 9 11C9 11.6 8.6 12 8 12ZM8 16C7.4 16 7 15.6 7 15C7 14.4 7.4 14 8 14C8.6 14 9 14.4 9 15C9 15.6 8.6 16 8 16ZM8 8C7.4 8 7 7.6 7 7C7 6.4 7.4 6 8 6C8.6 6 9 6.4 9 7C9 7.6 8.6 8 8 8Z"
                        fill="currentColor" />
                    <path
                        d="M16 16H11C10.4 16 10 15.6 10 15C10 14.4 10.4 14 11 14H16C16.6 14 17 14.4 17 15C17 15.6 16.6 16 16 16ZM16 12H11C10.4 12 10 11.6 10 11C10 10.4 10.4 10 11 10H16C16.6 10 17 10.4 17 11C17 11.6 16.6 12 16 12ZM16 8H11C10.4 8 10 7.6 10 7C10 6.4 10.4 6 11 6H16C16.6 6 17 6.4 17 7C17 7.6 16.6 8 16 8Z"
                        fill="currentColor" />
                </svg>
            </span>
            {{-- <div class="mt-4">
                <h4 class="text-gray-600 fw-bold">{{ __('No conversations yet') }}</h4>
                <p class="text-muted fs-6">{{ __('Start a chat by sending a template message to contact.') }}</p>
            </div> --}}
        </div>
        <!--end::Empty state-->
    </div>
    <!--end::Contacts container-->
</div>
