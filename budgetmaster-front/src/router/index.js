import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Budgets from '../views/Budgets.vue';
import Home from '../views/Home.vue';

const routes = [
  { path: '/', redirect: '/home' }, // ← redirection par défaut
  { path: '/home', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/budgets', component: Budgets },
  { path: '/transactions', component: () => import('../views/Transactions.vue') },
  { path: '/forecasts', component: () => import('../views/Forecasts.vue') },
  { path: '/profile', component: () => import('../views/Profile.vue') },
  { path: '/account', component: () => import('../views/Account.vue') },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
