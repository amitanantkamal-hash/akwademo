@extends('layouts.app-client')

@section('css')
    <style>
        .kanban-column {
            max-height: 400px;
            /* adjust to fit 4 cards, you may tweak */
            overflow-y: auto;
            /* background-color: #f8f9fa; */
            border-radius: 8px;
            padding: 1rem;
        }

        .kanban-column::-webkit-scrollbar {
            width: 6px;
        }

        .kanban-column::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .kanban-column::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .kanban-item {
            cursor: grab;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #E4E6EF;
        }

        .kanban-item:active {
            cursor: grabbing;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-info {
            background: linear-gradient(90deg, #7239EA 0%, #8C5BE5 100%);
            border: none;
            font-weight: 600;
        }

        .kanban-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .stage-header {
            color: white;
            background: linear-gradient(90deg, #283d3b 0%, #283d3b 100%);
            border-radius: 8px 8px 0 0;
            padding: 1rem;
        }

        .stage-count {
            background-color: white;
            color: #009EF7;
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-weight: 600;
        }

        .lead-phone {
            color: #7E8299;
            font-size: 0.9rem;
        }

        .lead-detail {
            font-size: 0.85rem;
            color: #5E6278;
            margin-bottom: 0.25rem;
        }

        .kanban-container {
            overflow-x: auto;
            padding-bottom: 1rem;
        }

        .stage-column {
            min-width: 300px;
            margin-right: 1rem;
        }

        .drag-over {
            background-color: #e2f0ff !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0">
                            <i class="fas fa-columns me-2"></i>Lead Pipeline - Kanban View
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('leads.index') }}" class="btn btn-info">
                                <i class="fas fa-list me-2"></i> List View
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="kanban-container d-flex">
                            @foreach ($stages as $stage)
                                <div class="stage-column mb-4">
                                    <div class="card h-100">
                                        <div class="stage-header d-flex justify-content-between align-items-center">
                                            {{ $stage }}
                                            <span class="stage-count">{{ count($leadsByStage[$stage]) }}</span>
                                        </div>
                                        <div class="card-body p-3 kanban-column" data-stage="{{ $stage }}">
                                            @foreach ($leadsByStage[$stage] as $lead)
                                                <div class="card mb-3 kanban-item" data-lead-id="{{ $lead->id }}">
                                                    <div class="card-body p-3">
                                                        <h6 class="mb-2">
                                                            <i class="fas fa-user me-2 text-primary"></i>
                                                            {{ $lead->contact->name ?? 'Unknown' }}
                                                        </h6>
                                                        <p class="lead-phone mb-2">
                                                            <i class="fas fa-phone me-2 text-success"></i>
                                                            {{ $lead->contact->phone }}
                                                        </p>
                                                        @if ($lead->source)
                                                            <p class="lead-detail">
                                                                <i class="fas fa-source me-2 text-info"></i>
                                                                {{ $lead->source }}
                                                            </p>
                                                        @endif
                                                        @if ($lead->contact->user)
                                                            <p class="lead-detail">
                                                                <i class="fas fa-user-tie me-2 text-warning"></i>
                                                                {{ $lead->contact->user->name }}
                                                            </p>
                                                        @endif
                                                        @php
                                                            $nextFollowup = $lead->nextFollowup();
                                                        @endphp
                                                        @if ($nextFollowup)
                                                            <p class="lead-detail mb-0">
                                                                <i class="fas fa-calendar me-2 text-danger"></i>
                                                                Next:
                                                                {{ $nextFollowup->scheduled_at->format('M d, Y H:i') }}
                                                            </p>
                                                        @endif
                                                        <div class="mt-3 d-flex justify-content-end">
                                                            <a href="{{ route('leads.show', $lead->id) }}"
                                                                class="btn btn-icon btn-info btn-sm me-2"
                                                                data-bs-toggle="tooltip" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('leads.edit', $lead->id) }}"
                                                                class="btn btn-icon btn-success btn-sm"
                                                                data-bs-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kanbanItems = document.querySelectorAll('.kanban-item');
            const kanbanColumns = document.querySelectorAll('.kanban-column');

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            kanbanItems.forEach(item => {
                item.setAttribute('draggable', 'true');

                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', item.dataset.leadId);
                    item.classList.add('dragging');
                });

                item.addEventListener('dragend', function() {
                    item.classList.remove('dragging');
                });
            });

            kanbanColumns.forEach(column => {
                column.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    column.classList.add('drag-over');
                });

                column.addEventListener('dragleave', function() {
                    column.classList.remove('drag-over');
                });

                column.addEventListener('drop', function(e) {
                    e.preventDefault();
                    column.classList.remove('drag-over');
                    const leadId = e.dataTransfer.getData('text/plain');
                    const newStage = column.dataset.stage;

                    const draggedItem = document.querySelector(
                        `.kanban-item[data-lead-id='${leadId}']`);
                    const oldColumn = draggedItem.closest('.kanban-column');

                    // Move the card in DOM instantly
                    column.appendChild(draggedItem);

                    // Update stage counts
                    const oldCount = oldColumn.closest('.card').querySelector('.stage-count');
                    const newCount = column.closest('.card').querySelector('.stage-count');
                    oldCount.textContent = parseInt(oldCount.textContent) - 1;
                    newCount.textContent = parseInt(newCount.textContent) + 1;

                    // Show SweetAlert2 loading modal with progress bar
                    Swal.fire({
                        title: 'Updating lead stage...',
                        html: '<b></b>%',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request
                    fetch(`/lead-manager/${leadId}/stage`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                stage: newStage
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Response from server:', data); // debug
                            Swal.close();

                            // robust check
                            if (data && data.success === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Lead stage updated successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                // Swal.fire({
                                //     icon: 'error',
                                //     title: 'Error!',
                                //     text: 'Failed to update lead stage.',
                                // });
                                // window.location.reload(); // revert on failure
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong!',
                            });
                            // window.location.reload();
                        });

                });

            });
        });
    </script>
@endsection
