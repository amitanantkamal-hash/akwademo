<div class="input-group ms-2 ml-2">
    <input v-if='!note' @keyup.enter="sendChatMessage" v-model="activeMessage" type="text" id="message" class="form-control border-0 mb-2"
        placeholder="{{ __('Type here') }}" aria-label="{{ __('Message') }}">
    <textarea v-if='note' @keyup.enter="sendChatMessage" v-model='activeNote' class="form-control border-0 bg-light-warning mb-2" rows="1"
        placeholder="{{ __('Type your note here...') }}"></textarea>
</div>
