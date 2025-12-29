import { createRouter, createWebHistory } from 'vue-router';
import LeadIndex from '../components/LeadManager/Index.vue';
import LeadDetail from '../components/LeadManager/Detail.vue';
import LeadKanban from '../components/LeadManager/Kanban.vue';

const routes = [
    {
        path: '/leads',
        name: 'leads.index',
        component: LeadIndex
    },
    {
        path: '/leads/create',
        name: 'leads.create',
        component: () => import('../components/LeadManager/Create.vue')
    },
    {
        path: '/leads/:id',
        name: 'leads.show',
        component: LeadDetail,
        props: true
    },
    {
        path: '/leads/:id/edit',
        name: 'leads.edit',
        component: () => import('../components/LeadManager/Edit.vue'),
        props: true
    },
    {
        path: '/leads/kanban/view',
        name: 'leads.kanban',
        component: LeadKanban
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;