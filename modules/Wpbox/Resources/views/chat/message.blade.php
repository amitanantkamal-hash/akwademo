<div v-for="(message, indexMessage) in messages" class="row mb-4"
    :class="[
        { 'justify-content-start': message.is_message_by_contact == 1 },
        { 'justify-content-end': message.is_message_by_contact == 0 },
        { 'text-end': message.is_message_by_contact == 0 && message.is_campign_messages == 0 }
    ]">

    <!-- Date Badge -->
    <div class="col-md-12"
        v-if="indexMessage === 0 || momentDay(message.created_at) !== momentDay(messages[indexMessage - 1].created_at)">
        <div class="text-center">
            <span class="badge badge-light text-muted">
                <i class="fas fa-calendar-day me-2"></i>@{{ momentDay(message.created_at) }}
            </span>
        </div>
    </div>

    <!-- Message Bubble -->
    <div class="col-auto chat-bubble">
        <div class="card border-0 text-gray-800 fw-semibold shadow-sm"
            :class="[
                { 'bg-light-info': message.is_message_by_contact == 1 },
                { 'bg-light-primary': message.is_message_by_contact == 0 },
                { 'bg-light-warning': message.header_text === 'Note' }
            ]">
            <div class="card-body py-3 px-4">

                <!-- Header Media -->
                <img v-if="message.header_image" class="mb-4 rounded" :src="message.header_image"
                    style="max-width: 100%" />

                <a v-if="message.header_document" :href="message.header_document" target="_blank" type="button"
                    class="btn btn-sm btn-primary mb-2"> <i
                        class="fas fa-file-download me-2"></i>{{ __('Document link') }} </a>

                <a v-if="message.header_location" :href="message.header_location" target="_blank" type="button"
                    class="btn btn-sm btn-primary mb-2">{{ __('See location') }}</a>

                <video v-if="message.header_video" class="rounded mb-2" style="width: 300px;height: 200px;" controls>
                    <source :src="message.header_video" type="video/mp4">
                </video>

                <audio v-if="message.header_audio" class="mb-2" style="width: 100%" controls>
                    <source :src="message.header_audio" type="audio/mpeg">
                </audio>

                <!-- Header Text -->
                <h4 v-if="message.header_text" class="mb-2 text-gray-800">
                    <i v-if="message.header_text === 'Note'" class="fas fa-heading me-2"></i>
                    @{{ message.header_text }}
                </h4>

                <!-- Message Body -->
                <p v-html="formatIt(message.value)" class="mt-4 mb-2"
                    :class="{ 'fw-bold': message.is_message_by_contact == 0 }"></p>

                <!-- Original Message -->
                <p v-if="message.original_message.length > 0"
                    v-html="formatIt('{{ __('Original:') }} ' + message.original_message)"
                    class="mt-4 mb-2 small text-muted" :class="{ 'fw-bold': message.is_message_by_contact == 0 }"></p>

                <!-- Footer Text -->
                <p v-if="message.footer_text" class="text-xs text-muted mt-2">
                    <i class="fas fa-info-circle me-1"></i>@{{ message.footer_text }}
                </p>

                <!-- Buttons -->
                <div v-if="message.buttons" class="d-flex flex-column mt-3">
                    <!-- If buttons is plain text -->
                    <div v-if="!isJsonString(message.buttons)" class="btn btn-sm btn-primary mb-2"
                        style="pointer-events: none;">
                        @{{ message.buttons }}
                    </div>

                    <!-- If buttons is JSON array -->
                    <div v-else-if="parseJSON(message.buttons).length > 0"
                        v-for="(button, indexButton) in parseJSON(message.buttons)" :key="indexButton"
                        class="btn btn-sm btn-primary mb-2" style="pointer-events: none;">
                        <i v-if="button.type === 'URL'" class="fas fa-link me-2"></i>
                        <i v-if="button.type === 'reply'" class="fas fa-reply me-2"></i>
                        @{{ button.text || (button.name === 'cta_url' ?
    button.parameters.display_text :
    (button.type === 'reply' ? button.reply.title : '')) }}
                    </div>
                </div>
                <!-- Timestamp & Sender -->
                <div class="d-flex text-xs text-muted mt-2"
                    :class="[
                        { 'text-gray-600': message.is_message_by_contact == 0 },
                        { 'justify-content-end': message.is_message_by_contact == 0 }
                    ]">
                    <i class="fas fa-check-circle text-success me-1"></i>
                    <span>@{{ momentHM(message.created_at) }}</span>
                    <span class="ms-1" v-if="!message.is_message_by_contact && message.sender_name?.length > 0">
                        <i class="fas fa-user-edit me-1"></i>@{{ message.sender_name }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div v-if="message.error" class="alert alert-danger d-flex align-items-center p-2 mt-2">
            <i class="fas fa-exclamation-circle fs-2 me-3"></i>
            <div class="flex-column">
                <span>@{{ message.error }}</span>
            </div>
        </div>
    </div>
</div>
