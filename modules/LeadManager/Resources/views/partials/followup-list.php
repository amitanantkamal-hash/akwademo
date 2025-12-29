<div id="upcoming-followups">
    @foreach ($upcomingFollowups as $followup)
        @include('lead-manager::partials.followup-card', ['followup' => $followup])
    @endforeach
</div>

@if ($pastFollowups->count() > 0)
    <button class="btn btn-sm btn-secondary mb-4" id="show-past-followups">Show Past Follow-ups</button>
    <div id="past-followups" style="display: none;">
        @foreach ($pastFollowups as $followup)
            @include('lead-manager::partials.followup-card', ['followup' => $followup])
        @endforeach
    </div>
@endif
