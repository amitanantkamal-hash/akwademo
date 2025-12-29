{{-- Bulk Add Tag Modal --}}
<div class="modal fade" id="bulkAddTagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bulkAddTagForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Tag to Selected Leads</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Select Tags</label>
                    <select class="form-select select2" multiple>
                        @foreach ($existingTags as $tag)
                            <option value="{{ $tag }}">{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bulk Remove Tag Modal --}}
<div class="modal fade" id="bulkRemoveTagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bulkRemoveTagForm">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Tag from Selected Leads</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Select Tags</label>
                    <select class="form-select select2" multiple>
                        @foreach ($existingTags as $tag)
                            <option value="{{ $tag }}">{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Remove Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bulk Add Group Modal --}}
<div class="modal fade" id="bulkAddGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bulkAddGroupForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Selected Leads to Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Select Groups</label>
                    <select class="form-select select2" multiple>
                        @foreach ($filter_groups as $group)
                            <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add to Group</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bulk Remove Group Modal --}}
<div class="modal fade" id="bulkRemoveGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="bulkRemoveGroupForm">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Selected Leads from Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Select Groups</label>
                    <select class="form-select select2" multiple>
                          @foreach ($filter_groups as $group)
                            <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Remove from Group</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="leadSourceModal" tabindex="-1" aria-labelledby="leadSourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md"> <!-- smaller modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leadSourceModalLabel">Manage Lead Sources</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- Add New Lead Source --}}
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="newSourceName" placeholder="Enter new lead source name">
                        <button class="btn btn-success" id="addNewSourceBtn"><i class="fas fa-plus me-2"></i>Add Source</button>
                    </div>
                </div>

                {{-- Existing Lead Sources --}}
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-bordered table-striped mb-0" id="leadSourceTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sources as $source)
                            <tr data-id="{{ $source->id }}">
                                <td>
                                    <input type="text" class="form-control source-name" value="{{ $source->name }}">
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary update-source-btn">Update</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

