@extends('layouts.app-client')

@section('css')
<!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css" />

    <style>
        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            border: 0;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .card-title {
            margin-bottom: 0;
            font-weight: 600;
        }

        .detail-card {
            border-left: 4px solid #009EF7;
            border-radius: 8px;
        }

        .badge {
            font-weight: 600;
            padding: 0.5em 0.8em;
        }

        .badge-success {
            background-color: #50CD89;
        }

        .badge-danger {
            background-color: #F1416C;
        }

        .badge-primary {
            background-color: #009EF7;
        }

        .badge-warning {
            background-color: #FFC700;
        }

        .note-card {
            border-left: 4px solid #FFC700;
        }

        .followup-card {
            border-left: 4px solid #50CD89;
        }

        .detail-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #E4E6EF;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-xl-8">
                <!-- Lead Details Card -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0"><i class="fas fa-user-circle me-2"></i>Lead Details</h3>
                        <div class="card-tools d-flex gap-2">
                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-secondary">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>

                            @if ($previousId)
                                <a href="{{ route('leads.show', $previousId) }}" class="btn btn-primary">
                                    <i class="fas fa-chevron-left me-1"></i> Previous
                                </a>
                            @endif

                            @if ($nextId)
                                <a href="{{ route('leads.show', $nextId) }}" class="btn btn-primary">
                                    Next <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            @endif

                            <a href="{{ route('leads.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-card p-4 mb-4">
                                    <!-- Name -->
                                    <div class="detail-item d-flex align-items-center">
                                        <span class="text-primary me-3"><i class="fas fa-user fa-lg"></i></span>
                                        <div>
                                            <div class="text-muted small">Name</div>
                                            <div class="fw-bold fs-6">{{ $lead->contact->name ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                    <!-- Phone -->
                                    <div class="detail-item d-flex align-items-center">
                                        <span class="text-primary me-3"><i class="fas fa-phone fa-lg"></i></span>
                                        <div>
                                            <div class="text-muted small">Phone</div>
                                            <div class="fw-bold fs-6">{{ $lead->contact->phone }}</div>
                                        </div>
                                    </div>
                                    <!-- Source -->
                                    <div class="detail-item d-flex align-items-center">
                                        <span class="text-primary me-3"><i class="fas fa-source fa-lg"></i></span>
                                        <div>
                                            <div class="text-muted small">Source</div>
                                            <div class="fw-bold fs-6">{{ $lead->source?->name ?? 'Not specified' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tags & Groups Card -->
                                <div class="card detail-card p-4 mb-4">
                                    @php
                                        $tags = [];
                                        if ($lead->contact && $lead->contact->tags) {
                                            if (is_array($lead->contact->tags)) {
                                                $tags = $lead->contact->tags;
                                            } elseif (is_string($lead->contact->tags)) {
                                                $tags =
                                                    json_decode($lead->contact->tags, true) ?:
                                                    explode(',', $lead->contact->tags);
                                            }
                                        }
                                    @endphp

                                    @php
                                        $tags = [];
                                        if ($lead->contact && $lead->contact->tags) {
                                            if (is_array($lead->contact->tags)) {
                                                $tags = $lead->contact->tags;
                                            } elseif (is_string($lead->contact->tags)) {
                                                $decoded = json_decode($lead->contact->tags, true);
                                                $tags = $decoded ?: explode(',', $lead->contact->tags);
                                            }
                                        }
                                    @endphp

                                    <div class="detail-item d-flex flex-wrap align-items-center">
                                        <div class="me-2">
                                            <div class="text-muted small mb-1">Tags</div>
                                            @if (!empty($tags))
                                                @foreach ($tags as $tag)
                                                    <span class="badge badge-success me-1 mb-1">{{ $tag }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No tags assigned</span>
                                            @endif
                                        </div>
                                        <button class="btn btn-sm btn-light ms-auto edit-field-btn" data-field="tags"
                                            data-value="{{ implode(',', $tags) }}" data-bs-toggle="modal"
                                            data-bs-target="#editFieldModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>


                                    <div class="detail-item d-flex flex-wrap align-items-center mt-3">
                                        <div class="me-2">
                                            <div class="text-muted small mb-1">Groups</div>
                                            @if ($lead->contact && $lead->contact->groups && $lead->contact->groups->count())
                                                @foreach ($lead->contact->groups as $group)
                                                    <span class="badge badge-primary me-1 mb-1">{{ $group->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No groups assigned</span>
                                            @endif
                                        </div>
                                        <button class="btn btn-sm btn-light ms-auto edit-field-btn" data-field="groups"
                                            data-value="{{ $lead->contact->groups->pluck('id')->implode(',') }}"
                                            data-bs-toggle="modal" data-bs-target="#editFieldModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-card p-4 mb-4">
                                    <div class="detail-item d-flex align-items-center mt-3">
                                        <span class="text-primary me-3"><i class="fas fa-step-forward fa-lg"></i></span>
                                        <div class="flex-grow-1">
                                            <div class="text-muted small">Stage</div>
                                            <span
                                                class="badge badge-{{ $lead->stage == 'Won' ? 'success' : ($lead->stage == 'Lost' ? 'danger' : 'primary') }}">
                                                {{ $lead->stage }}
                                            </span>
                                        </div>
                                        <button class="btn btn-sm btn-light edit-field-btn" data-field="stage"
                                            data-value="{{ $lead->stage }}" data-bs-toggle="modal"
                                            data-bs-target="#editFieldModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>

                                    <div class="detail-item d-flex align-items-center mt-3">
                                        <span class="text-primary me-3"><i class="fas fa-user-tie fa-lg"></i></span>
                                        <div class="flex-grow-1">
                                            <div class="text-muted small">Agent</div>
                                            <div class="fw-bold fs-6">{{ $lead->contact->user->name ?? 'Unassigned' }}
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-light edit-field-btn" data-field="agent"
                                            data-value="{{ $lead->contact->user_id ?? '' }}" data-bs-toggle="modal"
                                            data-bs-target="#editFieldModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>

                                    <div class="detail-item d-flex align-items-center mt-3">
                                        <span class="text-primary me-3"><i class="fas fa-calendar-alt fa-lg"></i></span>
                                        <div>
                                            <div class="text-muted small">Next Follow-up</div>
                                            <div class="fw-bold fs-6">
                                                @php $nextFollowup = $lead->nextFollowup(); @endphp
                                                {{ $nextFollowup ? $nextFollowup->scheduled_at->format('M d, Y H:i') : 'Not scheduled' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0"><i class="fas fa-sticky-note me-2"></i>Notes</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('leads.notes.store', $lead->id) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Add a note</label>
                                <textarea class="form-control" name="note" rows="3" placeholder="Type your note here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Add
                                Note</button>
                        </form>

                        <div class="separator my-6"></div>

                        <h4 class="mb-4">Recent Notes</h4>

                        @foreach ($lead->notes as $note)
                            <div class="card note-card mb-4">
                                <div class="card-body d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40px me-3">
                                            <div class="symbol-label bg-light-primary">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $note->agent->name }}</div>
                                            <div class="text-muted small">{{ $note->created_at->format('M d, Y H:i') }}
                                            </div>
                                            <p class="mb-0">{{ $note->note }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('leads.notes.destroy', [$lead->id, $note->id]) }}"
                                        method="POST" class="delete-note ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Follow-ups Card -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0"><i class="fas fa-calendar-plus me-2"></i>Schedule Follow-up</h3>
                    </div>
                    <div class="card-body">
                        <form id="schedule-followup-form" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="scheduled_at">Date and Time</label>
                                <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="notes">Notes <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mb-4">Schedule</button>
                        </form>

                        @php
                            $now = \Carbon\Carbon::now();
                            $upcomingFollowups = $lead->followups
                                ->filter(fn($f) => \Carbon\Carbon::parse($f->scheduled_at)->gte($now))
                                ->sortBy('scheduled_at');

                            $pastFollowups = $lead->followups
                                ->filter(fn($f) => \Carbon\Carbon::parse($f->scheduled_at)->lt($now))
                                ->sortByDesc('scheduled_at');
                        @endphp

                        <div style="max-height: 500px; overflow-y: auto;">
                            <div id="upcoming-followups">
                                @foreach ($upcomingFollowups as $followup)
                                    @include('lead-manager::partials.followup-card', [
                                        'followup' => $followup,
                                    ])
                                @endforeach
                            </div>

                            @if ($pastFollowups->count() > 0)
                                <button class="btn btn-sm btn-secondary mb-4" id="show-past-follow-ups-btn">
                                    Show Past Follow-ups
                                </button>
                                <div id="past-followups" style="display: none;">
                                    @foreach ($pastFollowups as $followup)
                                        @include('lead-manager::partials.followup-card', [
                                            'followup' => $followup,
                                        ])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline Edit Modal -->
    <div class="modal fade" id="editFieldModal" tabindex="-1" aria-labelledby="editFieldModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="edit-field-form">
                @csrf
                <input type="hidden" name="field" id="modal-field">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-field-label">Edit Field</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-content">
                        <!-- Dynamic content injected via JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('schedule-followup-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const notes = form.querySelector('#notes').value.trim();
                if (!notes) {
                    Swal.fire('Error', 'Notes field is required!', 'error');
                    return;
                }
                const formData = new FormData(form);

                Swal.fire({
                    title: 'Scheduling Follow-up...',
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false
                });

                fetch("{{ route('leads.followups.store', $lead->id) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success').then(() => window.location
                                .reload());
                        } else Swal.fire('Error', data.message || 'Something went wrong!', 'error');
                    })
                    .catch(err => {
                        Swal.close();
                        Swal.fire('Error', 'Server error. Try again!', 'error');
                        console.error(err);
                    });
            });

            // Delete confirmation for notes & follow-ups
            document.querySelectorAll('.delete-note, .delete-followup').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Toggle past follow-ups
            document.getElementById('show-past-follow-ups-btn')?.addEventListener('click', function() {
                const past = document.getElementById('past-followups');
                if (past.style.display === 'none') {
                    past.style.display = 'block';
                    this.textContent = 'Hide Past Follow-ups';
                } else {
                    past.style.display = 'none';
                    this.textContent = 'Show Past Follow-ups';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agents = @json($agents);
            const groups = @json($groups);
            const editButtons = document.querySelectorAll('.edit-field-btn');
            const modalField = document.getElementById('modal-field');
            const modalLabel = document.getElementById('modal-field-label');
            const modalBody = document.getElementById('modal-body-content');
            const editForm = document.getElementById('edit-field-form');
            const modal = new bootstrap.Modal(document.getElementById('editFieldModal'));

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const field = this.dataset.field;
                    const value = this.dataset.value; // comma-separated for tags/groups
                    modalField.value = field;
                    modalLabel.textContent = field.charAt(0).toUpperCase() + field.slice(1);

                    let html = '';

                    if (field === 'stage') {
                        const stages = ['New', 'In Progress', 'Follow-up', 'Won', 'Lost'];
                        html = `<select name="value" class="form-control" required>`;
                        stages.forEach(s => {
                            html +=
                                `<option value="${s}" ${value === s ? 'selected' : ''}>${s}</option>`;
                        });
                        html += `</select>`;
                    } else if (field === 'agent') {
                        html = `<select name="value" class="form-control" required>`;
                        agents.forEach(agent => {
                            html +=
                                `<option value="${agent.id}" ${value == agent.id ? 'selected' : ''}>${agent.name}</option>`;
                        });
                        html += `</select>`;
                    } else if (field === 'tags') {
                        const selectedTags = value ? value.split(',') : [];
                        html =
                            `<select name="value[]" class="form-control select2-tags-modal" multiple="multiple">`;
                        @foreach ($existingTags as $tag)
                            html +=
                                `<option value="{{ $tag }}" ${selectedTags.includes('{{ $tag }}') ? 'selected' : ''}>{{ $tag }}</option>`;
                        @endforeach
                        html += `</select>`;
                    } else if (field === 'groups') {
                        const selectedGroups = value ? value.split(',') : [];
                        html =
                            `<select name="value[]" class="form-control select2-groups-modal" multiple="multiple">`;
                        groups.forEach(group => {
                            html +=
                                `<option value="${group.id}" ${selectedGroups.includes(String(group.id)) ? 'selected' : ''}>${group.name}</option>`;
                        });
                        html += `</select>`;
                    }

                    modalBody.innerHTML = html;

                    // Initialize Select2 for modal after injecting HTML
                    if (field === 'tags') {
                        $('.select2-tags-modal').select2({
                            theme: "bootstrap-5",
                            tags: true,
                            tokenSeparators: [',', ' '],
                            width: '100%',
                            dropdownParent: $('#editFieldModal') // <--- key fix
                        });
                    }
                    if (field === 'groups') {
                        $('.select2-groups-modal').select2({
                            theme: "bootstrap-5",
                            width: '100%',
                            dropdownParent: $('#editFieldModal') // <--- key fix
                        });
                    }


                    modal.show();
                });
            });

            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(editForm);

                Swal.fire({
                    title: 'Saving...',
                    didOpen: () => Swal.showLoading(),
                    allowOutsideClick: false
                });

                fetch("{{ route('leads.inlineUpdate', $lead->id) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong!', 'error');
                        }
                    })
                    .catch(err => {
                        Swal.close();
                        Swal.fire('Error', 'Server error. Try again!', 'error');
                        console.error(err);
                    });
            });
        });
    </script>
@endsection