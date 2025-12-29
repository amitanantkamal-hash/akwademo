<script>
"use strict";

imagetopreview = "template";
var templateManager = null;
var vuec = null;

window.onload = function() {
    Vue.config.devtools = true;

    templateManager = new Vue({
        el: '#template_creator',
        data: {
            // --- WIZARD STEP: added for navigation (minimal addition) ---
            step: 'basic',
            stepsOrder: ['basic','header','body','footer','buttons'],

            // --- your existing data (kept original names) ---
            template_name: "",
            category: "MARKETING",
            template_type: "REGULAR",
            language: "en_US",
            headerEnabled: true,
            headerType: 'none',
            headerText: '',
            
            headerExampleVariable: '',
            headerHandle: "",
            headerImage: "",
            headerVideo: "",
            headerPdf: "",
            bodyText: "",
            bodyExampleVariable: [],
            footerText: "",
            quickReplies: [],
            vistiWebsite: [],
            hasPhone: false,
            dialCode: "",
            phoneNumber: "",
            callPhoneButtonText: "",
            copyOfferCode: false,
            offerCode: "",
            isSending: false,
            buttonsList: [], // new dynamic buttons array
            nextButtonId: 1,

            // small UI properties used by header/footer toggles:
            headerEnabled: false,
            footerEnabled: false,
            footerError: '',
            metaHandle: null
        },
        watch: {
            template_name: function(newVal, oldVal) {
                //Don't allow spaces in the template name
                this.template_name = newVal.replace(/\s/g, '_');

                //Replace - with _
                this.template_name = this.template_name.replace(/-/g, '_');

                //Replace Capital letters with lowercase
                this.template_name = this.template_name.toLowerCase();
            },
            template_type(newType) {
                if (newType !== "REGULAR") {
                    this.quickReplies = ["Start Flow"]; // Reset to only one quick reply
                }
            }
        },
        methods: {
            // ---------- WIZARD NAV HELPERS ----------
            goToStep(stepName) {
                if (this.canProceedToStep(stepName)) {
                    this.step = stepName;
                }
            },
            next() {
                const idx = this.stepsOrder.indexOf(this.step);
                if (idx < this.stepsOrder.length - 1) {
                    const nextStep = this.stepsOrder[idx + 1];
                    if (this.canProceedToStep(nextStep)) {
                        this.step = nextStep;
                    }
                }
            },
            previous() {
                const idx = this.stepsOrder.indexOf(this.step);
                if (idx > 0) {
                    this.step = this.stepsOrder[idx - 1];
                }
            },

            // ---------- STEP VALIDATION ----------
            canProceedToStep(stepName) {
                switch (stepName) {
                    case 'header':
                        if (!this.template_name.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Template Name Required',
                                text: 'Please enter a template name before proceeding to Header.',
                            });
                            return false;
                        }

                        // Only validate header text if a variable was added
                        if (this.headerType === 'text' && this.headervariableAdded && !this.headerText.includes('{{1}}')) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Header Text Required',
                                text: 'Please add header variable text before proceeding.',
                            });
                            return false;
                        }
                        break;

                    case 'body':
                        // Only validate body text if variables exist
                        if (this.bodyVariables && this.bodyVariables.length > 0 && !this.bodyText.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Body Text Required',
                                text: 'Please enter body text for the added variables before proceeding.',
                            });
                            return false;
                        }
                        break;

                    case 'footer':
                    case 'buttons':
                        // Only validate body text if variables exist
                        if (this.bodyVariables && this.bodyVariables.length > 0 && !this.bodyText.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Body Text Required',
                                text: 'Please enter body text for the added variables before proceeding.',
                            });
                            return false;
                        }
                        break;
                }
                return true;
            },
            
            // ---------- your original methods (untouched) ----------
            handleKeydown(event) {
                const isCmdOrCtrl = event.ctrlKey || event.metaKey;

                if (isCmdOrCtrl && event.key === "b") {
                    event.preventDefault();
                    this.wrapSelectionWith("*");
                } else if (isCmdOrCtrl && event.key === "i") {
                    event.preventDefault();
                    this.wrapSelectionWith("_");
                } else if (isCmdOrCtrl && event.shiftKey && event.key.toLowerCase() === "c") {
                    event.preventDefault();
                    this.wrapSelectionWith("`");
                } else if (isCmdOrCtrl && event.shiftKey && event.key.toLowerCase() === "x") {
                    event.preventDefault();
                    this.wrapSelectionWith("~");
                }
            },
            wrapSelectionWith(wrapper) {
                // works with textarea ref="messageInput"
                let input = this.$refs.messageInput;
                if (!input) return;
                let start = input.selectionStart;
                let end = input.selectionEnd;
                let text = this.bodyText || '';

                if (start !== end) {
                    let selectedText = text.substring(start, end);
                    let newText = text.substring(0, start) + wrapper + selectedText + wrapper + text.substring(end);
                    this.bodyText = newText;

                    this.$nextTick(() => {
                        input.setSelectionRange(start + 1, end + 1);
                    });
                } else {
                    // if no selection, append
                    this.bodyText = text + wrapper + wrapper;
                }
            },
            addButton() {
                // Default button values will be the same
                if (this.buttonsList.length < 8) {
                    this.buttonsList.push({
                        type: 'quick_reply',  // default type
                        text: '',
                        title: '',
                        url: '',
                        dialCode: '',
                        phoneNumber: '',
                        offerCode: ''
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Limit Reached",
                        text: "You can only add up to 8 buttons!",
                    });
                    return;
                }
            },
            deleteButton(index) {
                this.buttonsList.splice(index, 1);
            },
            updateButtonType(index) {
                // Reset values when type changes
                const type = this.buttonsList[index].type;
                if (type === 'quick_reply') this.buttonsList[index].text = '';
                if (type === 'visitWebsite') {
                    this.buttonsList[index].title = '';
                    this.buttonsList[index].url = '';
                }
                if (type === 'callPhone') {
                    this.buttonsList[index].text = '';
                    this.buttonsList[index].dialCode = '';
                    this.buttonsList[index].phoneNumber = '';
                }
                if (type === 'offerCode') {
                    this.buttonsList[index].offerCode = '';
                }
            },
            limitQuickReplyText(index) {
                if (!this.buttonsList[index].text) return;
                if (this.buttonsList[index].text.length > 25) this.buttonsList[index].text = this.buttonsList[index].text.substring(0,25);
            },
            limitVisitWebsiteText(index) {
                if (!this.buttonsList[index].title) return;
                if (this.buttonsList[index].title.length > 25) this.buttonsList[index].title = this.buttonsList[index].title.substring(0,25);
            },
            limitVisitWebsiteUrl(index) {
                if (!this.buttonsList[index].url) return;
                if (this.buttonsList[index].url.length > 2000) this.buttonsList[index].url = this.buttonsList[index].url.substring(0,2000);
            },
            limitCallPhoneText(index) {
                if (!this.buttonsList[index].text) return;
                if (this.buttonsList[index].text.length > 25) this.buttonsList[index].text = this.buttonsList[index].text.substring(0,25);
            },
            validateNumbers(field, index) {
                this.buttonsList[index][field] = this.buttonsList[index][field].replace(/\D/g,'');
            },
            limitCouponCodeText(index) {
                if (!this.buttonsList[index].offerCode) return;
                if (this.buttonsList[index].offerCode.length > 15) this.buttonsList[index].offerCode = this.buttonsList[index].offerCode.substring(0,15);
            },

            limitBodyText() {
                if (this.bodyText.length > 1024) {
                    this.bodyText = this.bodyText.substring(0, 1024);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Character Limit Exceeded',
                        text: 'Message body cannot exceed 1024 characters.',
                    });
                }
            },
            validateFooterText() {
                if (this.footerText.length > 60) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Character Limit Exceeded',
                        text: 'Footer text must be 60 characters or less!',
                    });
                    this.footerText = this.footerText.substring(0, 60); // Trim to 60 characters
                }
            },
            validateHeaderText() {
                if (this.headerType === 'text' && this.headerText.length > 60) {
                    this.headerText = this.headerText.substring(0, 60);
                }
            },
            // compatibility method: templates call updateHeader in several places
            updateHeader() {
                // ensure headerEnabled follows headerType, and run validation
                
                // run validation if it's text
                if (this.headerType === 'text') {
                    this.validateHeaderText();
                }
            },
            addHeaderVariable() {
                if (!this.headervariableAdded) { // Only add if not already added
                    this.headervariableAdded = true;
                    this.headerText += ' \{\{1\}\}';
                }else {
                    Swal.fire({
                        icon: "warning",
                        title: "Limit Reached",
                        text: "You can add only 1 veriable!",
                    });
                    return;
                }
            },
            addBold: function() {
                this.bodyText += '*ENTER_CONTENT_HERE*';
            },
            adddItalic: function() {
                this.bodyText += '_ENTER_CONTENT_HERE_';
            },
            addCode: function() {
                this.bodyText += '`ENTER_CODE_HERE`';
            },
            addVariable() {
                let input = this.$refs.messageInput;
                if (!input) return;

                // Get all existing variables {{1}}, {{2}} ...
                let existingVars = this.bodyText.match(/\{\{(\d+)\}\}/g) || [];

                if (existingVars.length >= 18) {
                    Swal.fire({
                        icon: "warning",
                        title: "Limit Reached",
                        text: "You can only add up to 18 variables!",
                    });
                    return;
                }

                let highest = 0;

                if (existingVars.length > 0) {
                    highest = Math.max(
                        ...existingVars.map(v => parseInt(v.replace(/[^\d]/g, '')))
                    );
                }

                let next = highest + 1;       // next variable number
                let variable = `@{{${next}}}`; // final string

                // insert at cursor position
                let start = input.selectionStart;
                let end = input.selectionEnd;
                let text = this.bodyText;

                this.bodyText =
                    text.substring(0, start) +
                    variable +
                    text.substring(end);

                // move cursor after inserted variable
                this.$nextTick(() => {
                    input.setSelectionRange(start + variable.length, start + variable.length);
                    input.focus();
                });
            },
            addQuickReply: function() {
                if (this.totalButtons >= 8) {
                    this.showLimitAlert();
                    return;
                }
                this.quickReplies.push("");
            },
            deleteQuickReply: function(index) {
                this.quickReplies.splice(index, 1);
            },
            addVisitWebsite: function() {
                if (this.totalButtons >= 8) {
                    this.showLimitAlert();
                    return;
                }
                if (this.vistiWebsite.length >= 2) {
                    return;
                }
                this.vistiWebsite.push({
                    title: "",
                    url: ""
                });
            },
            deleteVisitWebsite: function(index) {
                this.vistiWebsite.splice(index, 1);
            },
            addCallPhone: function() {
                if (this.totalButtons >= 8) {
                    this.showLimitAlert();
                    return;
                }
                this.hasPhone = true;
            },
            deletePhone: function() {
                this.hasPhone = false;
            },
            addCopyOfferCode: function() {
                if (this.totalButtons >= 8) {
                    this.showLimitAlert();
                    return;
                }
                this.copyOfferCode = true;
            },
            deleteCopyOfferCode: function() {
                this.copyOfferCode = false;
            },
            showLimitAlert: function() {
                Swal.fire({
                    icon: "warning",
                    title: "Limit Reached",
                    text: "You can only add up to 8 buttons in total!",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK"
                });
            },
            handleImageUpload(file, media_id) {
                    if (!file) return;
                    
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const maxSize = 5 * 1024 * 1024; // 5MB

                    // if (!allowedTypes.includes(file.type)) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Invalid File Type',
                    //         text: 'Only JPG, JPEG, and PNG are allowed.'
                    //     });
                    //     return;
                    // }

                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size exceeds 5MB limit.'
                        });
                        return;
                    }

                    // Show loading indicator
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while your image is being uploaded.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('media_id', media_id);

                    axios.post('/templates/upload-image', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        this.headerImage = response.data.url;
                        this.metaHandle = response.data.meta_handle;
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Upload Successful',
                        //     text: 'Your image has been uploaded successfully!'
                        // }); 

                        // Close loading indicator first
                        Swal.close();
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: 'Your image has been uploaded successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }).catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: 'Something went wrong while uploading the image.'
                        });
                    });
                },

                handleVideoUpload(file, media_id) {
                    if (!file) return;

                    const allowedTypes = ['video/mp4'];
                    const maxSize = 16 * 1024 * 1024; // 16MB

                    // console.log(file.type);
                    // if (!allowedTypes.includes(file.type)) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Invalid File Type',
                    //         text: 'Only MP4 videos are allowed.'
                    //     });
                    //     return;
                    // }

                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size exceeds 16MB limit.'
                        });
                        return;
                    }

                    // Show loading indicator
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while your video file is being uploaded.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('media_id', media_id);

                    axios.post('/templates/upload-video', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        this.headerVideo = file;
                        this.metaHandle = response.data.meta_handle;
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Upload Successful',
                        //     text: 'Your video has been uploaded successfully!'
                        // });

                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: 'Your video has been uploaded successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        });

                    }).catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: 'Something went wrong while uploading the video.'
                        });
                    });
                },

                handlePdfUpload(file, media_id) {
                    if (!file) return;

                    const allowedTypes = ['application/pdf'];
                    const maxSize = 5 * 1024 * 1024; // 5MB

                    // if (!allowedTypes.includes(file.type)) {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Invalid File Type',
                    //         text: 'Only PDF files are allowed.'
                    //     });
                    //     return;
                    // }

                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size exceeds 5MB limit.'
                        });
                        return;
                    }

                    // Show loading indicator
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while your pdf file is being uploaded.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('media_id', media_id);

                    axios.post('/templates/upload-pdf', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        this.headerPdf = response.data.url;
                        this.metaHandle = response.data.meta_handle;
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Upload Successful',
                        //     text: 'Your PDF has been uploaded successfully!'
                        // });

                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: 'Your PDF has been uploaded successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }).catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: 'Something went wrong while uploading the PDF.'
                        });
                    });
                },
            showDisabledInDemo: function() {
                console.log('This feature is disabled in the demo');
                alert('This feature is disabled in the demo');
            },
            // submitTemplate unchanged
            submitTemplate: function() {
                if (!this.template_name.trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Template Name',
                        text: 'Please enter unique template name before submitting!',
                    });
                    return;
                }

                if (this.headerType === 'text' && !this.headerText.trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Header Text',
                        text: 'Please enter header text before submitting!',
                    });
                    return;
                }

                if (!this.bodyText.trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Body Text',
                        text: 'Body text cannot be empty. Please enter some content before submitting!',
                    });
                    return;
                }

                // Validate buttons
                for (let i = 0; i < this.buttonsList.length; i++) {
                    const btn = this.buttonsList[i];
                    if (btn.type === 'quick_reply' && !btn.text.trim()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing Quick Reply Text',
                            text: 'Each Quick Reply button must have text.',
                        });
                        return;
                    }
                    if (btn.type === 'visitWebsite') {
                        if (!btn.title.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Visit Website Button Text',
                                text: 'Each Visit Website button must have a title.',
                            });
                            return;
                        }
                        if (!btn.url.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Visit Website URL',
                                text: 'Each Visit Website button must have a URL.',
                            });
                            return;
                        }
                    }
                    if (btn.type === 'callPhone') {
                        if (!btn.text.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Call Phone Button Text',
                                text: 'Call Phone button must have text.',
                            });
                            return;
                        }
                        if (!btn.dialCode.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Dial Code',
                                text: 'Please enter a dial code for the phone number.',
                            });
                            return;
                        }
                        if (!btn.phoneNumber.trim()) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Phone Number',
                                text: 'Please enter a phone number for the call button.',
                            });
                            return;
                        }
                    }
                    if (btn.type === 'offerCode' && !btn.offerCode.trim()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Missing Offer Code',
                            text: 'Offer code must have a value.',
                        });
                        return;
                    }
                }

                if (!this.isSending) {
                    this.isSending = true;

                    const metaTemplate = {
                        name: this.template_name,
                        category: this.category,
                        language: this.language,
                        allow_category_change: true,
                        components: []
                    };

                    // Body Component
                    const bodyComponent = {
                        type: "BODY",
                        text: this.bodyText
                    };
                    if (this.bodyExampleVariable && this.bodyExampleVariable.length) {
                        bodyComponent.example = { body_text: [this.bodyExampleVariable] };
                    }
                    metaTemplate.components.push(bodyComponent);

                    // Header Component
                    if (this.headerType === 'text') {
                        const headerComponent = {
                            type: "HEADER",
                            format: "TEXT",
                            text: this.headerText
                        };
                        if (this.headerExampleVariable) {
                            headerComponent.example = { header_text: [this.headerExampleVariable] };
                        }
                        metaTemplate.components.push(headerComponent);
                    } else if (this.headerType === 'image') {
                        metaTemplate.components.push({
                            type: "HEADER",
                            format: "IMAGE",
                            example: { header_handle: [this.metaHandle] }
                        });
                    } else if (this.headerType === 'video') {
                        metaTemplate.components.push({
                            type: "HEADER",
                            format: "VIDEO",
                            example: { header_handle: [this.metaHandle] }
                        });
                    } else if (this.headerType === 'pdf') {
                        metaTemplate.components.push({
                            type: "HEADER",
                            format: "DOCUMENT",
                            example: { header_handle: [this.metaHandle] }
                        });
                    }

                    // Footer Component
                    if (this.footerText && this.footerText.length > 0) {
                        metaTemplate.components.push({
                            type: "FOOTER",
                            text: this.footerText
                        });
                    }

                    // Buttons Component
                    if (this.buttonsList.length > 0) {
                        const buttonsComponent = {
                            type: "BUTTONS",
                            buttons: []
                        };

                        this.buttonsList.forEach(btn => {
                            if (btn.type === 'quick_reply') {
                                buttonsComponent.buttons.push({
                                    type: "QUICK_REPLY",
                                    text: btn.text.trim()
                                });
                            } else if (btn.type === 'visitWebsite') {
                                buttonsComponent.buttons.push({
                                    type: "URL",
                                    text: btn.title.trim(),
                                    url: btn.url.trim()
                                });
                            } else if (btn.type === 'callPhone') {
                                buttonsComponent.buttons.push({
                                    type: "PHONE_NUMBER",
                                    text: btn.text.trim(),
                                    phone_number: (btn.dialCode || '') + (btn.phoneNumber || '')
                                });
                            } else if (btn.type === 'offerCode') {
                                buttonsComponent.buttons.push({
                                    type: "COPY_CODE",
                                    example: btn.offerCode.trim()
                                });
                            }
                        });

                        if (buttonsComponent.buttons.length > 0) {
                            metaTemplate.components.push(buttonsComponent);
                        }
                    }

                    // Show loading indicator
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while your template is being sent for approval.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    // Submit to server
                    axios.post('/templates/submit', metaTemplate)
                        .then(response => {
                            if (response.data.status === "success") {
                                window.location.href = '/templates?ok=1&refresh=yes';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.data.message || 'Failed to submit template.',
                                });

                                console.log(response.data);
                                this.isSending = false; // Allow retry
                            }
                        })
                        .catch(error => {
                            let msg = "Failed to submit template.";

                            // extract real error message if available
                            if (error.response?.data?.content?.error?.message) {
                                msg = error.response.data.content.error.message;
                            } 
                            else if (error.response?.data?.errors) {
                                msg = Object.values(error.response.data.errors).join("\n");
                            } 
                            else if (error.response?.data?.message) {
                                msg = error.response.data.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg,
                            });

                            console.log(error);
                            this.isSending = false; // Allow retry
                        })
                        .finally(() => {
                            // Ensure button re-enables if error happens anywhere
                            this.isSending = false;
                        });
                }
            },
            // stub for updateButtons (templates may call this on change/input)
            updateButtons() {
                // intentionally small: keep reactivity in case template binds to @change="updateButtons"
                // you can expand this if you want to run validations or reformat buttons
                return true;
            }
        },
        computed: {
            totalButtons() {
                return this.quickReplies.length + this.vistiWebsite.length + (this.hasPhone ? 1 : 0) + (this.copyOfferCode ? 1 : 0);
            },
            headervariableAdded: function () {
                    return this.headerText.indexOf('\{\{1\}\}') > -1 && this.headerType == 'text';
                },
            bodyVariables: function() {
                return this.bodyText ? (this.bodyText.match(/\{\{[0-9]+\}\}/g) || null) : null;
            },
            formattedBodyText() {
                let bodyText = this.bodyText || '';

                // safe guard for example variables array
                if (Array.isArray(this.bodyExampleVariable) && this.bodyExampleVariable.length) {
                    this.bodyExampleVariable.forEach(function(example, index) {
                        if (example !== undefined && example !== null) {
                            // replace both forms: '{{ 1 }}' and '{{1}}'
                            const pattern1 = new RegExp('\\{\\{\\s*' + (index + 1) + '\\s*\\}\\}', 'g');
                            bodyText = bodyText.replace(pattern1, example);
                        }
                    });
                }

                bodyText = bodyText
                    .replace(/\*(.*?)\*/g, '<strong>$1</strong>')
                    .replace(/_(.*?)_/g, '<em>$1</em>')
                    .replace(/`(.*?)`/g, '<code>$1</code>')
                    .replace(/~(.*?)~/g, '<s>$1</s>');

                // escape newlines to <br>
                bodyText = bodyText.replace(/\n/g, '<br/>');

                return bodyText;
            },
            headerReplacedWithExample: function () {
                let headerText = this.headerText;
                if(this.headerExampleVariable){
                    headerText = headerText.replace('\{\{1\}\}', this.headerExampleVariable);
                }
                return headerText;
            },
            // small mapping for completed circles
            stepsMap() {
                return {
                    basic: { completed: !!(this.template_name) },
                    header: {
                        completed:
                            (this.headerType === "none") ? false :
                            (this.headerType === "text" ? !!this.headerText : !!this.metaHandle)
                    },
                    body: { completed: !!(this.bodyText) },
                    footer: { completed: !!(this.footerText) },
                    buttons: { completed: this.totalButtons > 0 }
                };
            },
            stepIndex() {
                return this.stepsOrder.indexOf(this.step) + 1;
            }
        }
    });
};
</script>