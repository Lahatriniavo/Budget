<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- Logo / Titre -->
      <h1 class="navbar-brand mb-0 fw-bold fs-4 text-primary">BudgetMaster</h1>

      <!-- Actions à droite -->
      <div class="d-flex align-items-center gap-3">
        <!-- Notifications -->
        <router-link to="/notifications" class="position-relative text-dark fs-4" title="Notifications" aria-label="Notifications">
          🔔
          <span v-if="notificationCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ notificationCount }}
            <span class="visually-hidden">notifications non lues</span>
          </span>
        </router-link>

        <!-- Import/Export -->
        <router-link to="/import-export" class="text-dark fs-4" title="Import/Export" aria-label="Import/Export">
          📁
        </router-link>

        <!-- Déconnexion -->
        <button @click="logoutUser" class="btn btn-danger btn-sm" title="Déconnexion">
          Déconnexion
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
import { logout } from '../services/authService'

export default {
  name: 'AppHeader',
  props: {
    notificationCount: {
      type: Number,
      default: 0,
    },
  },
  methods: {
    async logoutUser() {
      if (confirm('Voulez-vous vraiment vous déconnecter ?')) {
        try {
          await logout()
        } catch (e) {
          console.error('Erreur lors de la déconnexion :', e)
        }
        localStorage.removeItem('token')
        this.$router.push('/login')
      }
    }
  }
}
</script>

<style scoped>
/* Supplément pour éviter débordement du badge */
.badge {
  font-size: 0.65rem;
  padding: 0.35em 0.5em;
}
</style>
