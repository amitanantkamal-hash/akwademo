<template>
  <div class="lead-kanban">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Lead Pipeline</h2>
      <button class="btn btn-outline-primary" @click="$router.push('/leads')">
        <i class="fas fa-list"></i> List View
      </button>
    </div>

    <div class="kanban-board">
      <div class="kanban-column" v-for="stage in stages" :key="stage">
        <div class="kanban-header">
          <h5>{{ stage }} <span class="badge bg-secondary">{{ getLeadsByStage(stage).length }}</span></h5>
        </div>
        <div class="kanban-content" 
             @dragover.prevent 
             @drop="drop(stage, $event)"
             :data-stage="stage">
          <div class="kanban-item" 
               v-for="lead in getLeadsByStage(stage)" 
               :key="lead.id"
               draggable="true"
               @dragstart="dragStart(lead, $event)"
               :data-lead-id="lead.id">
            <div class="d-flex justify-content-between align-items-start">
              <h6>{{ lead.contact.name || 'Unknown' }}</h6>
              <span class="badge" :class="`bg-${getStageBadge(lead.stage)}`">{{ lead.stage }}</span>
            </div>
            <p class="mb-1 text-muted">{{ lead.contact.phone }}</p>
            <p class="mb-1" v-if="lead.source">Source: {{ lead.source }}</p>
            <p class="mb-1" v-if="lead.agent">Agent: {{ lead.agent.name }}</p>
            <p class="mb-0" v-if="lead.next_followup_at">
              Next: {{ formatDate(lead.next_followup_at) }}
            </p>
            <div class="mt-2 d-flex justify-content-end">
              <button class="btn btn-sm btn-info me-1" @click="viewLead(lead.id)">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-sm btn-primary" @click="editLead(lead.id)">
                <i class="fas fa-edit"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      leadsByStage: {},
      stages: ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'],
      draggedLead: null
    }
  },
  mounted() {
    this.fetchLeads();
  },
  methods: {
    async fetchLeads() {
      const response = await axios.get('/api/leads/kanban');
      this.leadsByStage = response.data;
    },
    getLeadsByStage(stage) {
      return this.leadsByStage[stage] || [];
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
    viewLead(id) {
      this.$router.push(`/leads/${id}`);
    },
    editLead(id) {
      this.$router.push(`/leads/${id}/edit`);
    },
    dragStart(lead, event) {
      this.draggedLead = lead;
      event.dataTransfer.setData('text/plain', lead.id);
    },
    async drop(newStage, event) {
      event.preventDefault();
      if (!this.draggedLead) return;
      
      if (this.draggedLead.stage !== newStage) {
        try {
          await axios.put(`/api/leads/${this.draggedLead.id}/stage`, {
            stage: newStage
          });
          
          // Update local data
          const oldStage = this.draggedLead.stage;
          this.draggedLead.stage = newStage;
          
          // Remove from old stage
          this.leadsByStage[oldStage] = this.leadsByStage[oldStage].filter(
            lead => lead.id !== this.draggedLead.id
          );
          
          // Add to new stage
          if (!this.leadsByStage[newStage]) {
            this.leadsByStage[newStage] = [];
          }
          this.leadsByStage[newStage].push(this.draggedLead);
          
          this.draggedLead = null;
        } catch (error) {
          alert('Error updating lead stage: ' + error.response.data.message);
        }
      }
    }
  }
}
</script>

<style scoped>
.kanban-board {
  display: flex;
  gap: 16px;
  overflow-x: auto;
  padding-bottom: 16px;
}

.kanban-column {
  min-width: 300px;
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 16px;
}

.kanban-header {
  margin-bottom: 16px;
  padding-bottom: 8px;
  border-bottom: 1px solid #dee2e6;
}

.kanban-content {
  min-height: 500px;
}

.kanban-item {
  background: white;
  border-radius: 6px;
  padding: 12px;
  margin-bottom: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  cursor: grab;
}

.kanban-item:active {
  cursor: grabbing;
}
</style>