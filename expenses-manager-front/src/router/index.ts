import { createRouter, createWebHistory } from 'vue-router';

import LayoutGuest from '../layouts/Guest.vue';
import LayoutMain from '../layouts/Main.vue';

import Home from '../pages/Home.vue';
import Login from '../pages/auth/Login.vue';
import ErrorNotFound from '../pages/ErrorNotFound.vue';

const routes = [
  {
    path: '/',
    component: LayoutMain,
    children: [{ path: '', name: 'home', component: Home }],
  },
  {
    path: '/expenses',
    component: LayoutMain,
    children: [{ path: '', name: 'home', component: Home }],
  },
  {
    path: '/logout',
    component: LayoutMain,
    children: [{ path: '', name: 'home', component: Home }],
  },
  {
    path: '/login',
    component: LayoutGuest,
    children: [{ path: '', name: 'login', component: Login }],
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
