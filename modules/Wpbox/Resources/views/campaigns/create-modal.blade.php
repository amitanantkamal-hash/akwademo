<form method="POST" action="{{ route('campaigns.store') }}" id="campign" enctype="multipart/form-data">
    @csrf

    {{-- <div class="col-xl-4">

        <div class="card-title mb-4">
            @if ($isBot)
                <h2>{{ __('Template bot') }}</h2>
            @elseif ($isAPI)
                <h2>{{ __('API campaign') }}</h2>
            @else
                <h2>{{ __('Campaign Reminder') }}</h2>
            @endif
        </div>
    </div> --}}
    @include('wpbox::campaigns.new.campaign')
    @if (isset($_GET['template_id']))
        <!--Variables-->
        <div class="col-xl-4">
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Variables') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @include('wpbox::campaigns.new.variables')
                </div>
            </div>
        </div>
        <!--Preview and send-->
        <div class="col-xl-4">
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Preview') }}</h2>
                    </div>
                </div>
                @include('wpbox::campaigns.new.preview')
            </div>
            @if ($isAPI)
                <div class="card card-flush mt-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('Save API campaign') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if (!isset($_GET['contact_id']))
                            <p>{{ __('This message will be sent once API with campaign ID called') }}</p>
                        @endif
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-info px-6" type="submit">{{ __('Save API Campaign') }}</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="card card-flush mt-4">
                    <div class="card-body">
                        <div class="row align-items-center h-100">
                            <div class="col-6 d-flex flex-column justify-content-center">
                                @if (!isset($_GET['contact_id']))
                                    @if ($isBot)
                                        <h2 class="my-2">{{ __('Save bot') }}</h2>
                                    @else
                                        <h2 class="my-2">{{ __('Send campaign') }}</h2>
                                    @endif
                                    @if ($isBot)
                                        <p>{{ __('This message will be sent to the contact once the trigger rule is met in the message sent by the contact.') }}
                                        </p>
                                    @else
                                        @if ($selectedContacts != '')
                                            @if ($selectedContacts == 1)
                                                <p>{{ __('Send to') }}: {{ $selectedContacts }}
                                                    {{ __('contact') }}</p>
                                            @else
                                                <p>{{ __('Send to') }}: {{ $selectedContacts }}
                                                    {{ __('contacts') }}</p>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="col-6 d-flex justify-content-end align-items-center h-100">
                                @if ($isBot)
                                    <button class="btn btn-info px-6" type="submit">{{ __('Save bot') }}</button>
                                @else
                                    @if (!isset($_GET['contact_id']) && $selectedContacts > 0)
                                        <button class="btn btn-info px-6"
                                            type="submit">{{ __('Send campaign') }}</button>
                                    @elseif (isset($_GET['contact_id']))
                                        <button class="btn btn-info px-6 "
                                            type="submit">{{ __('Send campaign') }}</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

</form>

<script>
    var vuec = null;
    var component = @json($selectedTemplateComponents);

    function submitJustCampign() {
        event.preventDefault();
        // Get form data
        const formData = new FormData(document.getElementById("campign"));
        // Build URL with GET parameters
        const url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" +
            new URLSearchParams(formData).toString();
        // Redirect to the URL (or use for AJAX request)
        window.location.href = url;
    }
    window.onload = function() {
        $(".form-control").on("input", function() {
            alert("Change");
        });
        $("#paramvalues[header][1]").on("input", function() {
            alert($(this).val());
        });
        vuec = new Vue({
            el: '#campign_managment',
            data: {
                body_1: "",
                body_2: "",
                body_3: "",
                body_4: "",
                body_5: "",
                body_6: "",
                body_7: "",
                body_8: "",
                body_9: "",
                header_1: "",
                imagePreview: null,
                videoPreview: null
            },
            methods: {
                setPreviewValue: function() {
                    this.body_1 = this.$refs['paramvalues[body][1]'] ? this.$refs[
                        'paramvalues[body][1]'].value : "";
                    this.body_2 = this.$refs['paramvalues[body][2]'] ? this.$refs[
                        'paramvalues[body][2]'].value : "";
                    this.body_3 = this.$refs['paramvalues[body][3]'] ? this.$refs[
                        'paramvalues[body][3]'].value : "";
                    this.body_4 = this.$refs['paramvalues[body][4]'] ? this.$refs[
                        'paramvalues[body][4]'].value : "";
                    this.body_5 = this.$refs['paramvalues[body][5]'] ? this.$refs[
                        'paramvalues[body][5]'].value : "";
                    this.body_6 = this.$refs['paramvalues[body][6]'] ? this.$refs[
                        'paramvalues[body][6]'].value : "";
                    this.body_7 = this.$refs['paramvalues[body][7]'] ? this.$refs[
                        'paramvalues[body][7]'].value : "";
                    this.body_8 = this.$refs['paramvalues[body][8]'] ? this.$refs[
                        'paramvalues[body][8]'].value : "";
                    this.body_9 = this.$refs['paramvalues[body][9]'] ? this.$refs[
                        'paramvalues[body][9]'].value : "";
                    this.header_1 = this.$refs['paramvalues[header][1]'] ? this.$refs[
                        'paramvalues[header][1]'].value : "";
                },
                handleImageUpload(event) {
                    const selectedFile = event.target.files[0];
                    if (selectedFile) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            this.imagePreview = reader.result;
                        };
                        reader.readAsDataURL(selectedFile);
                    } else {
                        // Handle the case when no file is selected or an error occurs.
                        this.imagePreview = "default-image.jpg";
                    }
                },
                handleImageUpload(event) {
                    const selectedFile = event.target.files[0];
                    if (selectedFile) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            this.imagePreview = reader.result;
                        };
                        reader.readAsDataURL(selectedFile);
                    } else {
                        // Handle the case when no file is selected or an error occurs.
                        this.imagePreview = "default-image.jpg";
                    }
                },
                handleVideoUpload(event) {
                    const selectedFile = event.target.files[0];
                    if (selectedFile) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            this.videoPreview = reader.result;
                        };
                        reader.readAsDataURL(selectedFile);
                    } else {
                        // Handle the case when no file is selected or an error occurs.
                        this.videoPreview = "default-image.jpg";
                    }
                },
            }
        });
        vuec.setPreviewValue();
    }
</script>
