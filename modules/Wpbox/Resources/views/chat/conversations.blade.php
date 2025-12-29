<!-- conversations.blade.php -->
<div class="flex-column flex-lg-row-auto">
    <div class="card card-flush border-0">
        <div class="card-body pt-0">
            @include('wpbox::chat.layout.body-conversations')

            <div class="d-flex justify-content-center mt-5 mb-8" v-if="numberOfPages>1">
                <b-pagination 
                    v-model="page" 
                    :total-rows="numberOfPages" 
                    :per-page="1" 
                    @change="allMessages"
                    class="pagination-sm"
                ></b-pagination>
            </div>

            <div class="d-flex flex-column justify-content-between align-items-center h-100 py-10" v-if="contacts.length === 0">
                <div class="text-center">
                    <i class="flaticon2-chat-1 text-muted" style="font-size: 5rem;"></i>
                    <h3 class="text-muted mt-5">No conversations yet</h3>
                    <p class="text-muted">Start a new conversation to begin chatting</p>
                </div>
            </div>
        </div>
    </div>
</div>