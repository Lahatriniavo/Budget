<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- Logo / Titre -->
      <h1 class="navbar-brand mb-0 fw-bold fs-4 text-primary">BudgetMaster</h1>

      <!-- Actions à droite -->
      <div class="d-flex align-items-center gap-3">
        <!-- Notifications -->
        <router-link to="/notifications" class="position-relative text-dark fs-4" title="Notifications">
          🔔
          <span v-if="notificationCount > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ notificationCount }}
            <span class="visually-hidden">notifications non lues</span>
          </span>
        </router-link>

        <!-- Import/Export -->
        <router-link to="/import-export" class="text-dark fs-4" title="Import/Export">
          📁
        </router-link>

        <!-- Avatar + Dropdown -->
        <div class="dropdown">
          <img
            :src="userPhoto || defaultAvatar"
            class="rounded-circle dropdown-toggle"
            style="width: 35px; height: 35px; object-fit: cover; cursor: pointer;"
            id="profileDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            alt="Avatar"
          />
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><router-link class="dropdown-item" to="/profile">👤 Mon profil</router-link></li>
            <li><button class="dropdown-item text-danger" @click="logoutUser">🚪 Déconnexion</button></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { logout } from '../services/authService'
import api from '../services/api'

export default {
  name: 'AppHeader',
  props: {
    notificationCount: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      userPhoto: null,
      defaultAvatar: 'https://via.placeholder.com/35?text=👤', // ou une image locale
    }
  },
  async created() {
    const token = localStorage.getItem('token')
    if(!token) return 
    try {
      const res = await api.get('/profile')
      this.userPhoto = res.data.photo_url
    } catch (e) {
      console.error('Erreur chargement photo profil :', e)
    }
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
.badge {
  font-size: 0.65rem;
  padding: 0.35em 0.5em;
}
</style>
