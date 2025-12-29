<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    "use strict";

    // Helper function for axios with SweetAlert loading and toast
    function axiosWithSwal(config, successMsg = 'Operation successful!', errorMsg = 'Something went wrong!') {
        Swal.fire({
            title: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        return axios(config)
            .then(response => {
                Swal.close();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: successMsg,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return response;
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: errorMsg,
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
                throw error;
            });
    }

    var updateContact = function() {
        console.log("updateContact");

        var contactDetails = chatList.activeChat;

        var newContactDetails = {
            name: contactDetails.name,
            email: contactDetails.email,
            id: contactDetails.id
        };

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/updateContact',
            data: newContactDetails
        }, 'Contact updated successfully!', 'Failed to update contact.')
        .then(response => {
            console.log(response);
        });
    }

    const BASE_URL = window.location.origin;

    var addTag = function() {
        if (!this.newTag || !this.newTag.trim()) return;

        var contactId = this.activeChat.id;
        var tag = this.newTag.trim();

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/addTagToContact',
            data: { id: contactId, tag: tag }
        }, 'Tag added!', 'Failed to add tag.')
        .then(response => {
            console.log('Tag added:', response.data);
            if (this.activeChat && this.activeChat.id === contactId) {
                let currentTags = this.activeChat.tags ? this.activeChat.tags.split(',') : [];
                if (!currentTags.includes(tag)) {
                    currentTags.push(tag);
                    this.activeChat.tags = currentTags.join(',');
                    this.newTag = '';
                }
            }
        })
        .catch(error => {
            console.error('Error adding tag:', error);
        });
    }

    var removeTag = function(tag) {
        var contactId = this.activeChat.id;

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/removeTagFromContact',
            data: { id: contactId, tag: tag }
        }, 'Tag removed!', 'Failed to remove tag.')
        .then(response => {
            console.log('Tag removed:', response.data);
            if (this.activeChat && this.activeChat.id === contactId) {
                let currentTags = this.getTagsArray();
                let updatedTags = currentTags.filter(t => t !== tag);
                this.activeChat.tags = updatedTags.join(',');
            }
        })
        .catch(error => {
            console.error('Error removing tag:', error.response || error);
        });
    }

    // New method to parse tags correctly
    var getTagsArray = function() {
        if (!this.activeChat || !this.activeChat.tags) return [];

        try {
            // Try parsing as JSON array
            const parsed = JSON.parse(this.activeChat.tags);
            if (Array.isArray(parsed)) {
                return parsed;
            }
        } catch (e) {
            // If parsing fails, try splitting as comma-separated string
            if (typeof this.activeChat.tags === 'string') {
                // Clean up any brackets that might be present
                const cleaned = this.activeChat.tags.replace(/[\[\]"]/g, '');
                return cleaned.split(',').map(t => t.trim()).filter(t => t);
            }
        }

        return [];
    }

    var addGroup = function(groupId) {
        var contactId = this.activeChat.id;

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/addGroupToContact',
            data: {
                contact_id: contactId,
                group_id: groupId,
                token: '_'
            }
        }, 'Group added!', 'Failed to add group.')
        .then(response => {
            console.log('Group added:', response.data);
            if (this.activeChat && this.activeChat.id === contactId) {
                let groupExists = this.activeChatGroups.some(g => g.id == groupId);
                if (!groupExists) {
                    let groupToAdd = this.availableGroups.find(g => g.id == groupId);
                    if (groupToAdd) {
                        this.activeChatGroups.push(groupToAdd);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error adding group:', error);
        });
    }

    var removeGroup = function(groupId) {
        var contactId = this.activeChat.id;

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/removeGroupFromContact',
            data: {
                contact_id: contactId,
                group_id: groupId,
                token: '_'
            }
        }, 'Group removed!', 'Failed to remove group.')
        .then(response => {
            console.log('Group removed:', response.data);
            if (this.activeChat && this.activeChat.id === contactId) {
                this.activeChatGroups = this.activeChatGroups.filter(g => g.id != groupId);
            }
        })
        .catch(error => {
            console.error('Error removing group:', error);
        });
    }

    function updateChatStatus(chatId) {
        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/updateChatStatus',
            data: {
                id: chatId,
                status: 'closed'
            }
        }, 'Chat status updated!', 'Failed to update chat status.')
        .then(response => {
            console.log('Chat status updated:', response.data);
            if (chatList.activeChat && chatList.activeChat.id === chatId) {
                chatList.activeChat.resolved_chat = '1';
            }
        })
        .catch(error => {
            console.error('Error updating chat status:', error);
        });
    }

    var updateAIBotStatus = function() {
        var contactId = chatList.activeChat.id;
        var enabled = chatList.activeChat.enabled_ai_bot;

        axiosWithSwal({
            method: 'post',
            url: '/api/wpbox/updateAIBot',
            data: {
                id: contactId,
                enabled_ai_bot: enabled ? '1' : '0',
                token: '_'
            }
        }, 'AI Bot status updated!', 'Failed to update AI bot status.')
        .then(response => {
            console.log('AI Bot status updated');
        })
        .catch(error => {
            console.error('Error updating AI bot status:', error);
            // Revert the toggle if the update fails
            chatList.activeChat.enabled_ai_bot = !chatList.activeChat.enabled_ai_bot;
        });
    }

    //Add this function to the Vue instance of chatList
    window.addEventListener('load', function() {

        if (typeof chatList.newTagValue === 'undefined') {
            chatList.$set(chatList, 'newTagValue', '');
        }

        //Watch for changes in activeChat
        chatList.$watch('activeChat', function(newVal, oldVal) {
            if (newVal !== oldVal) {
                var newContactDetails = {
                    name: newVal.name,
                    email: newVal.email,
                    id: newVal.id
                }
                // Future logic for new contact details here
            }
        });

        chatList.updateAIBotStatus = updateAIBotStatus;

        chatList.addTag = addTag.bind(chatList);
        chatList.removeTag = removeTag;
        chatList.addGroup = addGroup;
        chatList.removeGroup = removeGroup;
        chatList.getTagsArray = getTagsArray;
    });
</script>
