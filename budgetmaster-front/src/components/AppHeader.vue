<template>
  <header class="app-header">
    <h1 class="title">BudgetMaster</h1>
    <button @click="logoutUser" class="logout-button">Déconnexion</button>
  </header>
</template>

<script>
import { logout } from '../services/authService'

export default {
  name: 'AppHeader',
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
</style>
