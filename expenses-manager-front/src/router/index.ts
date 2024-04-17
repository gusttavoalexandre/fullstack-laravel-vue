import { createRouter, createWebHistory } from 'vue-router';
import Guard from './middleware'
import LayoutGuest from '../layouts/Guest.vue';
import LayoutMain from '../layouts/Main.vue';

import Home from '../pages/Home.vue';
import Login from '../pages/auth/Login.vue';
import ExpenseIndex from '../pages/expense/index.vue';
import ExpenseCreate from '../pages/expense/create.vue';
import ExpenseEdit from '../pages/expense/edit.vue';
import Register from '../pages/auth/Register.vue';
import ErrorNotFound from '../pages/ErrorNotFound.vue';

const routes = [
  {
    path: '/',
    component: LayoutMain,
    beforeEnter: Guard.redirectIfNotAuthenticated,
    children: [{ path: '', name: 'home', component: Home }],
  },
  {
    path: '/expenses',
    component: LayoutMain,
    children: [{ path: '', name: 'expenses', component: ExpenseIndex }],
  },
  {
    path: '/expenses/create',
    component: LayoutMain,
    children: [{ path: '', name: 'expenses/create', component: ExpenseCreate }],
  },
  {
    path: '/expenses/edit/:id',
    component: LayoutMain,
    children: [{ path: '', name: 'expenses/edit', component: ExpenseEdit }],
  },
  {
    path: '/login',
    component: LayoutGuest,
    beforeEnter: Guard.redirectIfAuthenticated,
    children: [{ path: '', name: 'login', component: Login }],
  },
  {
    path: '/register',
    component: LayoutGuest,
    beforeEnter: Guard.redirectIfAuthenticated,
    children: [{ path: '', name: 'register', component: Register }],
  },
  {
    path: '/:catchAll(.*)*',
    component: ErrorNotFound,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
