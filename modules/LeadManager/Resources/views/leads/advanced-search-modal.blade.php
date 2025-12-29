<div class="modal fade" id="advancedSearchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="GET" action="{{ route('leads.index') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Advanced Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ request('phone') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tag</label>
                            <select name="tag" class="form-select select2">
                                <option value="">All Tags</option>
                                @foreach ($existingTags as $tag)
                                    <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>
                                        {{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select name="group" class="form-select select2">
                                <option value="">All Groups</option>
                                @foreach ($filter_groups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ request('group') == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stage</label>
                            <select name="stage" class="form-select select2">
                                <option value="">All Stages</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage }}"
                                        {{ request('stage') == $stage ? 'selected' : '' }}>
                                        {{ $stage }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agent</label>
                            <select name="agent_id" class="form-select select2">
                                <option value="">All Agents</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}"
                                        {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Source</label>
                            <select name="source" class="form-select select2">
                                <option value="">All Sources</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source->id }}"
                                        {{ request('source') == $source->id ? 'selected' : '' }}>{{ $source->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('leads.index') }}" class="btn btn-light me-2">Reset</a>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>
