import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue' // ← Le layout principal (avec sidebar)
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'

const routes = [
  {
    path: '/',
    redirect: '/budgets' // Redirection vers la page principale
  },

  // Routes sans layout (authentification)
  {
    path: '/login',
    component: Login
  },
  {
    path: '/register',
    component: Register
  },

  // Routes avec layout Home.vue (sidebar)
  {
    path: '/',
    component: Home,
    children: [
      {
        path: 'budgets',
        component: () => import('../views/Budgets.vue')
      },
      {
        path: 'transactions',
        component: () => import('../views/Transactions.vue')
      },
      {
        path: 'forecasts',
        component: () => import('../views/Forecasts.vue')
      },
      {
        path: 'profile',
        component: () => import('../views/Profile.vue')
      },
      {
        path: 'account',
        component: () => import('../views/Settings.vue')
      },
      {
        path: 'user-profile',
        component: () => import('../components/userProfile.vue')
      },
      {
        path: 'reports',
        component: () => import('../views/Reports.vue')
      },
      {
        path: 'objectifs',
        name: 'Objectifs',
        component: () => import('../views/FinancialGoals.vue')
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: () => import('../views/Notifications.vue')
      },
      {
        path: 'revenus',
        name: 'Revenus',
        component: () => import('../views/Revenues.vue')
      },
      {
        path: 'import-export',
        name: 'ImportExport',
        component: () => import('../components/DataImportExport.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
