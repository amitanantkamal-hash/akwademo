<template>
  <div class="lead-manager">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Lead Manager</h2>
      <div>
        <button class="btn btn-primary" @click="showCreateModal = true">
          <i class="fas fa-plus"></i> Add Lead
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <select class="form-select" v-model="filters.stage" @change="fetchLeads">
              <option value="">All Stages</option>
              <option v-for="stage in stages" :value="stage">{{ stage }}</option>
            </select>
          </div>
          <div class="col-md-3">
            <select class="form-select" v-model="filters.agent_id" @change="fetchLeads">
              <option value="">All Agents</option>
              <option v-for="agent in agents" :value="agent.id">{{ agent.name }}</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Search source" v-model="filters.source" @input="debounceFetch">
          </div>
          <div class="col-md-3">
            <button class="btn btn-outline-secondary w-100" @click="exportLeads">
              <i class="fas fa-download"></i> Export
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Leads Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><input type="checkbox" v-model="selectAll" @change="toggleSelectAll"></th>
                <th>Name</th>
                <th>Phone</th>
                <th>Source</th>
                <th>Stage</th>
                <th>Agent</th>
                <th>Next Follow-up</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="lead in leads.data" :key="lead.id">
                <td><input type="checkbox" v-model="selectedLeads" :value="lead.id"></td>
                <td>{{ lead.contact.name }}</td>
                <td>{{ lead.contact.phone }}</td>
                <td>{{ lead.source }}</td>
                <td>
                  <span class="badge" :class="`bg-${getStageBadge(lead.stage)}`">
                    {{ lead.stage }}
                  </span>
                </td>
                <td>{{ lead.agent ? lead.agent.name : 'Unassigned' }}</td>
                <td>{{ lead.next_followup_at ? formatDate(lead.next_followup_at) : '-' }}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-sm btn-info" @click="viewLead(lead.id)">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-primary" @click="editLead(lead.id)">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" @click="deleteLead(lead.id)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span>Showing {{ leads.from }} to {{ leads.to }} of {{ leads.total }} entries</span>
          </div>
          <nav>
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: !leads.prev_page_url }">
                <button class="page-link" @click="fetchLeads(leads.current_page - 1)">Previous</button>
              </li>
              <li class="page-item" v-for="page in pages" :key="page" :class="{ active: page === leads.current_page }">
                <button class="page-link" @click="fetchLeads(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: !leads.next_page_url }">
                <button class="page-link" @click="fetchLeads(leads.current_page + 1)">Next</button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card mt-3" v-if="selectedLeads.length">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <select class="form-select" v-model="bulkAction">
              <option value="">Choose Action</option>
              <option value="assign_agent">Assign Agent</option>
              <option value="change_stage">Change Stage</option>
              <option value="add_tag">Add Tag</option>
              <option value="remove_tag">Remove Tag</option>
              <option value="add_to_group">Add to Group</option>
              <option value="remove_from_group">Remove from Group</option>
            </select>
          </div>
          <div class="col-md-3" v-if="bulkAction === 'assign_agent'">
            <select class="form-select" v-model="bulkValue">
              <option value="">Select Agent</option>
              <option v-for="agent in agents" :value="agent.id">{{ agent.name }}</option>
            </select>
          </div>
          <div class="col-md-3" v-else-if="bulkAction === 'change_stage'">
            <select class="form-select" v-model="bulkValue">
              <option value="">Select Stage</option>
              <option v-for="stage in stages" :value="stage">{{ stage }}</option>
            </select>
          </div>
          <div class="col-md-3" v-else-if="bulkAction === 'add_tag' || bulkAction === 'remove_tag'">
            <select class="form-select" v-model="bulkValue">
              <option value="">Select Tag</option>
              <option v-for="tag in tags" :value="tag.id">{{ tag.name }}</option>
            </select>
          </div>
          <div class="col-md-3" v-else-if="bulkAction === 'add_to_group' || bulkAction === 'remove_from_group'">
            <select class="form-select" v-model="bulkValue">
              <option value="">Select Group</option>
              <option v-for="group in groups" :value="group.id">{{ group.name }}</option>
            </select>
          </div>
          <div class="col-md-3">
            <button class="btn btn-primary" :disabled="!bulkValue" @click="applyBulkAction">
              Apply to {{ selectedLeads.length }} leads
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Lead Modal -->
    <div class="modal fade" :class="{ show: showCreateModal }" tabindex="-1" style="display: block;" v-if="showCreateModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Lead</h5>
            <button type="button" class="btn-close" @click="showCreateModal = false"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="createLead">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" class="form-control" v-model="newLead.phone" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" v-model="newLead.name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Source</label>
                    <input type="text" class="form-control" v-model="newLead.source">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Stage</label>
                    <select class="form-select" v-model="newLead.stage">
                      <option v-for="stage in stages" :value="stage">{{ stage }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Assign Agent</label>
                    <select class="form-select" v-model="newLead.agent_id">
                      <option value="">Unassigned</option>
                      <option v-for="agent in agents" :value="agent.id">{{ agent.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" @click="showCreateModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Lead</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show" v-if="showCreateModal"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      leads: {},
      filters: {
        stage: '',
        agent_id: '',
        source: ''
      },
      selectedLeads: [],
      selectAll: false,
      showCreateModal: false,
      newLead: {
        phone: '',
        name: '',
        source: '',
        stage: 'New',
        agent_id: ''
      },
      bulkAction: '',
      bulkValue: '',
      stages: ['New', 'In Progress', 'Follow-up', 'Won', 'Lost', 'Closed'],
      agents: [],
      tags: [],
      groups: [],
      debounce: null
    }
  },
  computed: {
    pages() {
      if (!this.leads.last_page) return [];
      const range = [];
      for (let i = 1; i <= this.leads.last_page; i++) {
        range.push(i);
      }
      return range;
    }
  },
  mounted() {
    this.fetchLeads();
    this.fetchAgents();
    this.fetchTags();
    this.fetchGroups();
  },
  methods: {
    async fetchLeads(page = 1) {
      const params = { page, ...this.filters };
      const response = await axios.get('/api/leads', { params });
      this.leads = response.data;
    },
    async fetchAgents() {
      const response = await axios.get('/api/users/agents');
      this.agents = response.data;
    },
    async fetchTags() {
      const response = await axios.get('/api/tags');
      this.tags = response.data;
    },
    async fetchGroups() {
      const response = await axios.get('/api/groups');
      this.groups = response.data;
    },
    debounceFetch() {
      clearTimeout(this.debounce);
      this.debounce = setTimeout(() => {
        this.fetchLeads();
      }, 500);
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
      return new Date(date).toLocaleString();
    },
    toggleSelectAll() {
      if (this.selectAll) {
        this.selectedLeads = this.leads.data.map(lead => lead.id);
      } else {
        this.selectedLeads = [];
      }
    },
    viewLead(id) {
      this.$router.push(`/leads/${id}`);
    },
    editLead(id) {
      this.$router.push(`/leads/${id}/edit`);
    },
    async deleteLead(id) {
      if (confirm('Are you sure you want to delete this lead?')) {
        await axios.delete(`/api/leads/${id}`);
        this.fetchLeads();
      }
    },
    async createLead() {
      try {
        await axios.post('/api/leads', this.newLead);
        this.showCreateModal = false;
        this.newLead = {
          phone: '',
          name: '',
          source: '',
          stage: 'New',
          agent_id: ''
        };
        this.fetchLeads();
      } catch (error) {
        alert('Error creating lead: ' + error.response.data.message);
      }
    },
    async exportLeads() {
      const params = { ...this.filters };
      const response = await axios.get('/api/leads/export', { 
        params,
        responseType: 'blob'
      });
      
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'leads.xlsx');
      document.body.appendChild(link);
      link.click();
    },
    async applyBulkAction() {
      if (!this.bulkAction || !this.bulkValue) return;
      
      try {
        await axios.post('/api/leads/bulk-action', {
          action: this.bulkAction,
          lead_ids: this.selectedLeads,
          value: this.bulkValue
        });
        
        this.selectedLeads = [];
        this.selectAll = false;
        this.bulkAction = '';
        this.bulkValue = '';
        this.fetchLeads();
        
        alert('Bulk action applied successfully');
      } catch (error) {
        alert('Error applying bulk action: ' + error.response.data.message);
      }
    }
  }
}
</script>

<style scoped>
.lead-manager .badge {
  font-size: 0.8em;
}
</style>