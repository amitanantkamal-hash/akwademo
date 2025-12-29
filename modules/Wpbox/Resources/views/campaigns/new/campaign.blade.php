<div class="card-body pt-0">
    <div class="campign_elements">
        @if (!isset($_GET['contact_id']) && !isset($_GET['resend']))
            @if ($isBot)
                <!-- Bot Name Input -->
                <div class="mb-5">
                    <label for="name" class="form-label">Bot name</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text"><i class="ki-duotone ki-robot fs-2"><span
                                    class="path1"></span><span class="path2"></span></i></span>
                        <input type="text" class="form-control form-control-solid" id="name"
                            value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}" name="name"
                            placeholder="Name for your bot" />
                    </div>
                </div>
            @elseif ($isReminder)
                <!-- Reminder Name Input -->
                <div class="mb-5">
                    <label for="name" class="form-label">Reminder name</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text"><i class="ki-duotone ki-notification fs-2"><span
                                    class="path1"></span><span class="path2"></span></i></span>
                        <input type="text" class="form-control form-control-solid" id="name" name="name"
                            placeholder="Name for your reminder" />
                    </div>
                </div>
            @else
                <!-- Campaign Name Input -->
                <div class="mb-5">
                    <label for="name" class="form-label">Campaign name</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text"><i class="ki-duotone ki-message-text-2 fs-2"><span
                                    class="path1"></span><span class="path2"></span></i></span>
                        <input type="text" class="form-control form-control-solid" id="name"
                            value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}" name="name"
                            placeholder="Name for your campaign" required />
                    </div>
                </div>
            @endif
        @endif
        <!-- Template Select -->
        <div class="mb-5">
            <label for="template_id" class="form-label required">Template</label>
            <div class="input-group input-group-solid">
                <span class="input-group-text">
                    <i class="ki-duotone ki-document fs-2">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </span>
                <select class="form-select form-select-solid" id="template_id" name="template_id" required>
                    <option value="">Select a template</option>
                    @foreach ($templates as $id => $name)
                        <option value="{{ $id }}"
                            {{ isset($_GET['template_id']) && $_GET['template_id'] == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-text">Select a message template to use</div>
        </div>


        @if (isset($_GET['contact_id']))
            <!-- Contact Select -->
            <div class="mb-5">
                <label for="contact_id" class="form-label required">Contact</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-profile-user fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <select class="form-select form-select-solid" id="contact_id" name="contact_id" required>
                        @foreach ($contacts as $id => $name)
                            <option value="{{ $id }}"
                                {{ isset($_GET['contact_id']) && $_GET['contact_id'] == $id ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @elseif($isBot)
            <input type="hidden" name="type" value="bot">

            <!-- Reply Type Select -->
            <div class="mb-5">
                <label for="reply_type" class="form-label required">Reply type</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-setting-2 fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <select class="form-select form-select-solid" id="reply_type" name="reply_type" required>
                        <option value="2" selected>Reply bot: On exact match</option>
                        <option value="3">Reply bot: When message contains</option>
                    </select>
                </div>
            </div>

            <!-- Trigger Input -->
            <div class="mb-5">
                <label for="trigger" class="form-label">Trigger</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-flash fs-2"><span class="path1"></span><span
                                class="path2"></span></i></span>
                    <input type="text" class="form-control form-control-solid" id="trigger" name="trigger"
                        placeholder="Enter bot reply trigger"
                        value="{{ isset($_GET['trigger']) ? $_GET['trigger'] : '' }}" required />
                </div>
            </div>
        @elseif($isAPI)
            <input type="hidden" name="type" value="api">
        @elseif($isReminder)
            <input type="hidden" name="type" value="reminder">

            <!-- Source Select -->
            <div class="mb-5">
                <label for="source_id" class="form-label required">Source</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-document fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <select class="form-select form-select-solid" id="source_id" name="source_id" required>
                        <option value="0"></option>
                        @foreach ($sources as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Reminder Type Select -->
            <div class="mb-5">
                <label for="reminder_type" class="form-label required">Reminder type</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-clock fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <select class="form-select form-select-solid" id="reminder_type" name="reminder_type" required>
                        <option value="1" selected>Before event</option>
                        <option value="2">After event</option>
                    </select>
                </div>
            </div>

            <!-- Reminder Unit Select -->
            <div class="mb-5">
                <label for="reminder_unit" class="form-label required">Reminder unit</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-calendar-time fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <select class="form-select form-select-solid" id="reminder_unit" name="reminder_unit" required>
                        <option value="minutes">Minutes</option>
                        <option value="hours">Hours</option>
                        <option value="days">Days</option>
                        <option value="weeks">Weeks</option>
                        <option value="months">Months</option>
                    </select>
                </div>
            </div>

            <!-- Reminder Time Input -->
            <div class="mb-5">
                <label for="reminder_time" class="form-label required">Reminder time</label>
                <div class="input-group input-group-solid">
                    <span class="input-group-text"><i class="ki-duotone ki-watch fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <input type="number" class="form-control form-control-solid" id="reminder_time"
                        name="reminder_time" placeholder="Enter reminder time" required />
                </div>
            </div>
        @else
            @if (!isset($_GET['resend']))
                <!-- Group Select -->
                <div class="mb-5">
                    <label for="group_id" class="form-label">Contacts</label>
                    <div class="input-group input-group-solid">
                        <span class="input-group-text"><i class="ki-duotone ki-users fs-2"><span
                                    class="path1"></span><span class="path2"></span></i></span>
                        <select class="form-select form-select-solid" id="group_id" name="group_id" required>
                            <option value=""></option>
                            @foreach ($groups as $id => $name)
                                <option value="{{ $id }}"
                                    {{ isset($_GET['group_id']) && $_GET['group_id'] == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <!-- Schedule Send Time -->
            <div class="mb-5">
                <label for="tempus_picker_input" class="form-label">{{ __('Schedule send time') }}</label>
                <div class="input-group input-group-solid" id="tempus_picker" data-td-target-input="nearest"
                    data-td-target-toggle="nearest">
                    <span class="input-group-text"><i class="ki-duotone ki-calendar-8 fs-2"><span
                                class="path1"></span><span class="path2"></span></i></span>
                    <input id="tempus_picker_input" type="text" class="form-control form-control-solid"
                        data-td-target="#tempus_picker" name="send_time" placeholder="Select date and time" />
                    <span class="input-group-text" data-td-target="#tempus_picker" data-td-toggle="datetimepicker">
                        <i class="ki-duotone ki-calendar-edit fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </span>
                </div>
                <div class="form-text">{{ __('Per client, based on the contact timezone') }}</div>
            </div>
            <!-- Send Now Toggle -->
            <div class="mb-5">
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" name="send_now" id="send_now"
                        @if (isset($_GET['send_now']) || isset($_GET['send_now']) !== '0') checked @endif />
                    <span
                        class="form-check-label fw-semibold text-muted">{{ __('Ignore schedule time and send now') }}</span>
                </label>
            </div>
        @endif
    </div>
</div>

<div class="card-footer d-flex justify-content-end py-6 px-9">
    <button onclick="validateAndSubmit()" class="btn btn-primary">
        <span class="indicator-label">{{ __('Next') }}</span>
        <span class="indicator-progress">{{ __('Please wait...') }}
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</div>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit longer to ensure all elements are loaded
            setTimeout(function() {
                const autoretargetToggle = document.getElementById('autoretarget_enabled');
                const autoretargetSection = document.getElementById('autoretarget_section');
                
                if (autoretargetToggle && autoretargetSection) {
                    // Initial state
                    autoretargetSection.style.display = autoretargetToggle.checked ? 'block' : 'none';
                    
                    // Toggle on change
                    autoretargetToggle.addEventListener('change', function() {
                        autoretargetSection.style.display = this.checked ? 'block' : 'none';
                        
                        // If enabling, make sure a campaign is selected
                        if (this.checked) {
                            const select = document.getElementById('autoretarget_campaign_id');
                            if (select && select.value === '') {
                                // Show a message if no campaign is selected
                                //alert('Please select an AutoRetarget campaign');
                            }
                        }
                    });
                    
                    // Also add change event to the select to validate when changed
                    const autoretargetSelect = document.getElementById('autoretarget_campaign_id');
                    if (autoretargetSelect) {
                        autoretargetSelect.addEventListener('change', function() {
                            if (autoretargetToggle.checked && this.value === '') {
                                alert('Please select an AutoRetarget campaign');
                            }
                        });
                    }
                } else {
                    console.error('AutoRetarget elements not found');
                }
            }, 300); // 300ms delay to ensure DOM is fully loaded
        });
    </script>
    <script>
        function validateAndSubmit() {
            // Required fields
            const requiredFields = [{
                id: 'template_id',
                message: 'Please select a template'
            }];

            // Context-specific requirements
            if (document.getElementById('contact_id')) {
                requiredFields.push({
                    id: 'contact_id',
                    message: 'Please select a contact'
                });
            } else if (document.getElementById('group_id')) {
                requiredFields.push({
                    id: 'group_id',
                    message: 'Please select a contact group'
                });
            }

            if (document.getElementById('trigger')) {
                requiredFields.push({
                    id: 'trigger',
                    message: 'Please enter a trigger'
                }, {
                    id: 'reply_type',
                    message: 'Please select reply type'
                });
            }

            if (document.getElementById('source_id')) {
                requiredFields.push({
                    id: 'source_id',
                    message: 'Please select a source'
                }, {
                    id: 'reminder_type',
                    message: 'Please select reminder type'
                }, {
                    id: 'reminder_unit',
                    message: 'Please select reminder unit'
                }, {
                    id: 'reminder_time',
                    message: 'Please enter reminder time'
                });
            }

            // Validate all required fields
            const errors = [];
            requiredFields.forEach(field => {
                const element = document.getElementById(field.id);
                if (element && !element.value) {
                    errors.push(field.message);
                }
            });
            @if (!isset($_GET['resend']))
                // Name validation (except when contact_id is set)
                if (!document.getElementById('contact_id')) {
                    const name = document.getElementById('name')?.value.trim();
                    if (!name) {
                        errors.push('Please enter a campaign name');
                    }
                }
            @endif

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errors.join('<br>'),
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            // Show loading state
            const btn = document.querySelector('button[onclick="validateAndSubmit()"]');
            btn.setAttribute('data-kt-indicator', 'on');
            btn.disabled = true;

            // Submit form
            submitJustCampign();
        }

        // Initialize Tempus Dominus if exists
        document.addEventListener('DOMContentLoaded', function() {
            const tempusPicker = document.getElementById('tempus_picker');
            if (tempusPicker) {
                setTimeout(() => {
                    const defaultDate = new Date();
                    new tempusDominus.TempusDominus(tempusPicker, {
                        defaultDate: defaultDate,
                        display: {
                            components: {
                                decades: true,
                                year: true,
                                month: true,
                                date: true,
                                hours: true,
                                minutes: true,
                                seconds: false
                            }
                        }
                    });
                }, 300);
            }
        });
    </script>

    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const input_date = document.getElementById("tempus_picker_input");
                console.log(input_date)
                // Obtener el valor de send_time del query string
                const urlParams = new URLSearchParams(window.location.search);
                const sendTime = urlParams.get('send_time');
                // Decodificar y convertir send_time a objeto Date
                let defaultDate;
                if (sendTime) {
                    // Decodificar el valor
                    const decodedTime = decodeURIComponent(sendTime);
                    // Convertir a objeto Date
                    defaultDate = new Date(decodedTime);
                } else {
                    // Si no existe send_time, usar la fecha actual
                    defaultDate = new Date();
                }
                new tempusDominus.TempusDominus(document.getElementById("tempus_picker"), {
                    defaultDate: defaultDate,
                    stepping: 1,
                });
            }, 1000); // 4 segundos
        });
    </script>
@endsection
