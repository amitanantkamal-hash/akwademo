<template>
  <div class="lead-detail" v-if="lead">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Lead Details</h2>
      <div>
        <button class="btn btn-outline-secondary me-2" @click="$router.push('/leads')">
          <i class="fas fa-arrow-left"></i> Back to List
        </button>
        <button class="btn btn-primary" @click="editLead(lead.id)">
          <i class="fas fa-edit"></i> Edit
        </button>
      </div>
    </div>

    <div class="row">
      <!-- Lead Info -->
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Lead Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Name:</strong> {{ lead.contact.name || 'Unknown' }}</p>
                <p><strong>Phone:</strong> {{ lead.contact.phone }}</p>
                <p><strong>Source:</strong> {{ lead.source || 'Not specified' }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Stage:</strong> 
                  <span class="badge" :class="`bg-${getStageBadge(lead.stage)}`">
                    {{ lead.stage }}
                  </span>
                </p>
                <p><strong>Agent:</strong> {{ lead.agent ? lead.agent.name : 'Unassigned' }}</p>
                <p><strong>Next Follow-up:</strong> 
                  {{ lead.next_followup_at ? formatDate(lead.next_followup_at) : 'Not scheduled' }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Notes Section -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Notes</h5>
          </div>
          <div class="card-body">
            <form @submit.prevent="addNote" class="mb-4">
              <div class="mb-3">
                <textarea class="form-control" v-model="newNote" rows="3" placeholder="Add a note..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Add Note</button>
            </form>

            <div class="timeline">
              <div class="timeline-item" v-for="note in lead.notes" :key="note.id">
                <div class="timeline-content">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>{{ note.agent.name }}</strong>
                    <small class="text-muted">{{ formatDateTime(note.created_at) }}</small>
                  </div>
                  <p class="mb-0">{{ note.note }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Follow-ups Section -->
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Follow-ups</h5>
            <button class="btn btn-sm btn-primary" @click="showFollowupModal = true">
              <i class="fas fa-plus"></i> Schedule Follow-up
            </button>
          </div>
          <div class="card-body">
            <div class="list-group">
              <div class="list-group-item" v-for="followup in lead.followups" :key="followup.id">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-1">{{ formatDateTime(followup.scheduled_at) }}</h6>
                  <span class="badge" :class="followup.reminder_sent ? 'bg-success' : 'bg-warning'">
                    {{ followup.reminder_sent ? 'Reminder Sent' : 'Pending' }}
                  </span>
                </div>
                <p class="mb-1" v-if="followup.notes">{{ followup.notes }}</p>
                <small class="text-muted">Created: {{ formatDateTime(followup.created_at) }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Quick Actions</h5>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <button class="btn btn-outline-primary" @click="showFollowupModal = true">
                <i class="fas fa-clock"></i> Schedule Follow-up
              </button>
              <button class="btn btn-outline-secondary" @click="showChangeStageModal = true">
                <i class="fas fa-exchange-alt"></i> Change Stage
              </button>
              <button class="btn btn-outline-info" @click="showAssignAgentModal = true">
                <i class="fas fa-user"></i> Assign Agent
              </button>
            </div>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Contact Information</h5>
          </div>
          <div class="card-body">
            <p><strong>Name:</strong> {{ lead.contact.name || 'Unknown' }}</p>
            <p><strong>Phone:</strong> {{ lead.contact.phone }}</p>
            <p><strong>Tags:</strong> 
              <span v-for="tag in lead.contact.tags" :key="tag.id" class="badge bg-secondary me-1">
                {{ tag.name }}
              </span>
              <span v-if="!lead.contact.tags.length">None</span>
            </p>
            <p><strong>Groups:</strong> 
              <span v-for="group in lead.contact.groups" :key="group.id" class="badge bg-info me-1">
                {{ group.name }}
              </span>
              <span v-if="!lead.contact.groups.length">None</span>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Schedule Follow-up Modal -->
    <div class="modal fade" :class="{ show: showFollowupModal }" tabindex="-1" style="display: block;" v-if="showFollowupModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Schedule Follow-up</h5>
            <button type="button" class="btn-close" @click="showFollowupModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="scheduleFollowup">
              <div class="mb-3">
                <label class="form-label">Date and Time</label>
                <input type="datetime-local" class="form-control" v-model="newFollowup.scheduled_at" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea class="form-control" v-model="newFollowup.notes" rows="3"></textarea>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" @click="showFollowupModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary">Schedule</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="showFollowupModal"></div>

    <!-- Change Stage Modal -->
    <div class="modal fade" :class="{ show: showChangeStageModal }" tabindex="-1" style="display: block;" v-if="showChangeStageModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Change Stage</h5>
            <button type="button" class="btn-close" @click="showChangeStageModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateStage">
              <div class="mb-3">
                <select class="form-select" v-model="selectedStage">
                  <option v-for="stage in stages" :value="stage">{{ stage }}</option>
                </select>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" @click="showChangeStageModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="showChangeStageModal"></div>

    <!-- Assign Agent Modal -->
    <div class="modal fade" :class="{ show: showAssignAgentModal }" tabindex="-1" style="display: block;" v-if="showAssignAgentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Assign Agent</h5>
            <button type="button" class="btn-close" @click="showAssignAgentModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="assignAgent">
              <div class="mb-3">
                <select class="form-select" v-model="selectedAgent">
                  <option value="">Unassigned</option>
                  <option v-for="agent in agents" :value="agent.id">{{ agent.name }}</option>
                </select>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" @click="showAssignAgentModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary">Assign</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="showAssignAgentModal"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      lead: null,
      newNote: '',
      newFollowup: {
        scheduled_at: '',
        notes: ''
      },
      selectedStage: '',
      selectedAgent: '',
      showFollowupModal: false,
      showChangeStageModal: false,
      showAssignAgentModal: false,
      stages: ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'],
      agents: []
    }
  },
  mounted() {
    this.fetchLead();
    this.fetchAgents();
  },
  methods: {
    async fetchLead() {
      const response = await axios.get(`/api/leads/${this.$route.params.id}`);
      this.lead = response.data;
      this.selectedStage = this.lead.stage;
      this.selectedAgent = this.lead.agent_id;
    },
    async fetchAgents() {
      const response = await axios.get('/api/users/agents');
      this.agents = response.data;
    },
    getStageBadge(stage) {
      const badges = {
        'New': 'primary',
        'In Progress': 'info',
        'Follow-up': 'warning',
        'Won': 'success',
        'Lost': 'danger',
        'Closed': 'secondary'
      };
      return badges[stage] || 'secondary';
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    formatDateTime(date) {
      return new Date(date).toLocaleString();
    },
    editLead(id) {
      this.$router.push(`/leads/${id}/edit`);
    },
    async addNote() {
      if (!this.newNote.trim()) return;
      
      try {
        await axios.post(`/api/leads/${this.lead.id}/notes`, {
          note: this.newNote
        });
        
        this.newNote = '';
        this.fetchLead(); // Refresh lead data
      } catch (error) {
        alert('Error adding note: ' + error.response.data.message);
      }
    },
    async scheduleFollowup() {
      try {
        await axios.post(`/api/leads/${this.lead.id}/followups`, this.newFollowup);
        
        this.showFollowupModal = false;
        this.newFollowup = {
          scheduled_at: '',
          notes: ''
        };
        this.fetchLead(); // Refresh lead data
      } catch (error) {
        alert('Error scheduling follow-up: ' + error.response.data.message);
      }
    },
    async updateStage() {
      try {
        await axios.put(`/api/leads/${this.lead.id}/stage`, {
          stage: this.selectedStage
        });
        
        this.showChangeStageModal = false;
        this.fetchLead(); // Refresh lead data
      } catch (error) {
        alert('Error updating stage: ' + error.response.data.message);
      }
    },
    async assignAgent() {
      try {
        await axios.put(`/api/leads/${this.lead.id}`, {
          agent_id: this.selectedAgent
        });
        
        this.showAssignAgentModal = false;
        this.fetchLead(); // Refresh lead data
      } catch (error) {
        alert('Error assigning agent: ' + error.response.data.message);
      }
    }
  }
}
</script>

<style scoped>
.timeline {
  border-left: 2px solid #dee2e6;
  margin-left: 16px;
}

.timeline-item {
  position: relative;
  padding-left: 24px;
  margin-bottom: 16px;
}

.timeline-item:before {
  content: '';
  position: absolute;
  left: -6px;
  top: 0;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #0d6efd;
}
</style>