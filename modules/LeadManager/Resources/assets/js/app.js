import { createApp } from 'vue';
import LeadIndex from './components/LeadManager/Index.vue';

const app = createApp({});

// Register components
app.component('lead-index', LeadIndex);

// Mount the app
app.mount('#app');

console.log('Vue app initialized');