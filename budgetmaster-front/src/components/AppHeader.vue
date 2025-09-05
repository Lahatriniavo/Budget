<template>
  <header class="app-header">
    <h1 class="title">BudgetMaster</h1>
        <div class="header-actions">
      <router-link to="/notifications" class="notification-icon" title="Notifications">
        🔔
      </router-link>

      <button @click="logoutUser" class="logout-button">Déconnexion</button>
    </div>
  </header>
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
.app-header {
  background-color: #fff;
  padding: 20px 30px;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}

.logout-button {
  padding: 8px 14px;
  font-size: 14px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #c0392b;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

.notification-icon {
  font-size: 24px;
  text-decoration: none;
  cursor: pointer;
  color: #333;
  transition: transform 0.2s ease;
}

.notification-icon:hover {
  transform: scale(1.2);
  color: #007bff;
}

</style>
