<!-- resources/views/abandoned-cart/settings.blade.php -->
@extends('layouts.app-client')

@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header mt-6">
                        <h4>Abandoned Cart Settings</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="enabled" class="col-md-4 col-form-label text-md-right">Enable Abandoned Cart
                                    Notifications</label>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="enabled" name="enabled"
                                            value="1"
                                            {{ old('enabled', $settings->enabled ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enabled">Enabled</label>
                                    </div>
                                </div>
                            </div>

                            <div id="abandoned-cart-settings"
                                style="{{ old('enabled', $settings->enabled ?? false) ? '' : 'display: none;' }}">
                                <div class="form-group">
                                    <label class="col-md-12 font-weight-bold">Reminder Settings</label>
                                    <p class="col-md-12 text-muted">Configure your abandoned cart reminder sequence</p>

                                    <div id="reminder-settings" class="col-md-12">
                                        @php
                                            // Use old input if available, otherwise use saved settings
                                            $oldCampaignIds = old('campaign_ids', $settings->campaign_ids ?? [null]);
                                            $oldDays = old('schedule_days', $settings->schedule_days ?? [0]);
                                            $oldTimes = old('schedule_times', $settings->schedule_times ?? ['09:00']);
                                            
                                            // Ensure all arrays have the same length
                                            $maxCount = max(count($oldCampaignIds), count($oldDays), count($oldTimes));
                                            for ($i = 0; $i < $maxCount; $i++) {
                                                $campaignIds[$i] = $oldCampaignIds[$i] ?? null;
                                                $days[$i] = $oldDays[$i] ?? 0;
                                                $times[$i] = $oldTimes[$i] ?? '09:00';
                                            }
                                        @endphp

                                        @foreach ($campaignIds as $index => $campaignId)
                                            <div class="reminder-setting row mb-3 p-2 border rounded">
                                                <div class="col-md-4">
                                                    <label>Campaign</label>
                                                    <select name="campaign_ids[]" class="form-control" required>
                                                        <option value="">Select Campaign</option>
                                                        @foreach ($campaigns as $campaign)
                                                            <option value="{{ $campaign->id }}"
                                                                {{ $campaignId == $campaign->id ? 'selected' : '' }}>
                                                                {{ $campaign->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Send After (Days)</label>
                                                    <input type="number" name="schedule_days[]" class="form-control"
                                                        placeholder="Days after abandonment" min="0" max="30"
                                                        value="{{ $days[$index] ?? 0 }}" required>
                                                    <small class="form-text text-muted">0 = Same day</small>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Send At (Time)</label>
                                                    <input type="time" name="schedule_times[]" class="form-control"
                                                        value="{{ $times[$index] ?? '09:00' }}" required>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button"
                                                        class="btn btn-danger remove-reminder">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="button" class="btn btn-secondary" id="add-reminder">Add
                                            Reminder</button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="max_reminders" class="col-md-4 col-form-label text-md-right">Maximum
                                        Reminders</label>
                                    <div class="col-md-6">
                                        <input type="number" id="max_reminders" name="max_reminders" class="form-control"
                                            value="{{ old('max_reminders', $settings->max_reminders ?? 3) }}"
                                            min="1" max="10">
                                        <small class="form-text text-muted">Maximum number of reminders to send per
                                            abandoned cart</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle settings visibility
            const enabledCheckbox = document.getElementById('enabled');
            const settingsDiv = document.getElementById('abandoned-cart-settings');

            // Initial state
            if (settingsDiv) {
                settingsDiv.style.display = enabledCheckbox.checked ? 'block' : 'none';

                // Toggle required attribute on inputs
                const inputs = settingsDiv.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.required = enabledCheckbox.checked;
                });
            }

            // Change event listener
            if (enabledCheckbox && settingsDiv) {
                enabledCheckbox.addEventListener('change', function() {
                    settingsDiv.style.display = this.checked ? 'block' : 'none';

                    // Toggle required attribute on inputs
                    const inputs = settingsDiv.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.required = this.checked;
                    });
                });
            }

            // Add new reminder setting
            const addReminderBtn = document.getElementById('add-reminder');
            if (addReminderBtn) {
                addReminderBtn.addEventListener('click', function() {
                    const template = `
                    <div class="reminder-setting row mb-3 p-2 border rounded">
                        <div class="col-md-4">
                            <label>Campaign</label>
                            <select name="campaign_ids[]" class="form-control" required>
                                <option value="">Select Campaign</option>
                                @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Send After (Days)</label>
                            <input type="number" name="schedule_days[]" class="form-control"
                                placeholder="Days after abandonment" min="0" max="30" value="0" required>
                            <small class="form-text text-muted">0 = Same day</small>
                        </div>
                        <div class="col-md-3">
                            <label>Send At (Time)</label>
                            <input type="time" name="schedule_times[]" class="form-control" value="09:00" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-reminder">Remove</button>
                        </div>
                    </div>`;

                    const reminderSettings = document.getElementById('reminder-settings');
                    if (reminderSettings) {
                        reminderSettings.insertAdjacentHTML('beforeend', template);
                    }
                });
            }

            // Remove reminder setting
            const reminderSettings = document.getElementById('reminder-settings');
            if (reminderSettings) {
                reminderSettings.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-reminder')) {
                        // Only remove if there's more than one reminder setting
                        const reminderElements = document.querySelectorAll('.reminder-setting');
                        if (reminderElements.length > 1) {
                            e.target.closest('.reminder-setting').remove();
                        } else {
                            alert('You must have at least one reminder setting.');
                        }
                    }
                });
            }
        });
    </script>
@endsection