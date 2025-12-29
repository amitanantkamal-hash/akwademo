@if ($lastContactReply)
    <div>
        @if ($windowStatus === 'expired')
            <span class="badge badge-light-danger fs-8">
                <i class="bi bi-clock-history me-2"></i>
                Free message window expired
            </span>
            <!-- Action Buttons Container -->
            <div class="mt-2 d-flex gap-2">
                <button id="refresh-window-btn" class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-abstract-8"><span class="path1"></span><span class="path2"></span></i>
                </button>
                <button id="send-template-btn" class="btn btn-sm btn-light-success">
                    <i class="ki-duotone ki-send">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Send Template Message
                </button>
            </div>
        @elseif(is_array($windowStatus))
            <span class="badge badge-light-success fs-8">
                <i class="bi bi-clock me-2"></i>
                Free messages available:
                {{ $windowStatus['remaining']->h }}h
                {{ $windowStatus['remaining']->i }}m remaining
            </span>
            <span class="text-muted fs-8 ms-2">
                (Expires: {{ $windowStatus['expires_at']->format('M j, H:i') }})
            </span>
        @endif
        <div class="text-muted fs-8 mt-1">
            Last client reply: {{ \Carbon\Carbon::parse($lastContactReply)->format('M j, Y H:i') }}
        </div>
    </div>
@endif
