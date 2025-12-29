<div class="card followup-card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <!-- Left: Time -->
            <div class="d-flex align-items-center">
                <span class="text-success me-2">
                    <i class="fas fa-clock"></i>
                </span>
                <div class="fw-bold">{{ $followup->scheduled_at->format('M d, Y H:i') }}</div>
            </div>

            <!-- Right: Badge, Icon, Delete -->
            <div class="d-flex align-items-center">
                <span class="text-primary me-2" title="Follow-up Info">
                    <i class="fas fa-info-circle"></i>
                </span>
                <span class="badge badge-{{ $followup->reminder_sent ? 'success' : 'warning' }} me-2">
                    {{ $followup->reminder_sent ? 'Reminder Sent' : 'Pending' }}
                </span>
                <form action="{{ route('leads.followups.destroy', [$lead->id, $followup->id]) }}"
                      method="POST" class="ms-2 delete-followup">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="badge badge-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        @if ($followup->notes)
            <p class="mb-0">{{ $followup->notes }}</p>
        @endif
    </div>
</div>
