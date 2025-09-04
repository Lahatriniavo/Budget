<template>
  <div class="home-container">
    <AppHeader />

    <div class="menu-grid">
      <router-link to="/budgets" class="menu-item">
        <div class="icon">💰</div>
        <h2>Budgets</h2>
      </router-link>

      <router-link to="/transactions" class="menu-item">
        <div class="icon">💳</div>
        <h2>Transactions</h2>
      </router-link>

      <router-link to="/forecasts" class="menu-item">
        <div class="icon">📊</div>
        <h2>Prévisions</h2>
      </router-link>

      <router-link to="/profile" class="menu-item">
        <div class="icon">👤</div>
        <h2>Profil</h2>
      </router-link>

      <router-link to="/account" class="menu-item">
        <div class="icon">⚙️</div>
        <h2>Compte</h2>
      </router-link>
    </div>
  </div>
</template>

<script>
import AppHeader from '../components/AppHeader.vue'

export default {
  name: 'Home',
  components: {
    AppHeader
  }
}
</script>

<style scoped>
.home-container {
  min-height: 100vh;
  padding: 30px;
  background-color: #f8f8f8;
  text-align: center;
}

.menu-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
  margin-top: 40px;
}

.menu-item {
  background: white;
  border: 1px solid #ddd;
  border-radius: 10px;
  width: 150px;
  padding: 20px;
  text-decoration: none;
  color: #333;
  transition: background 0.3s;
}

.menu-item:hover {
  background: #eef2f7;
}

.icon {
  font-size: 36px;
  margin-bottom: 10px;
}
</style>
