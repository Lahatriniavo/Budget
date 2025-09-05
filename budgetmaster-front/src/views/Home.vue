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

      <router-link to="/reports" class="menu-item">
        <div class="icon">📊</div>
        <h2>Rapports</h2>
      </router-link>

      <router-link to="/objectifs" class="menu-item">
        <div class="icon">🎯</div>
        <h2>Objectifs Financiers</h2>
      </router-link>

      <router-link to="/notifications" class="notification-icon" title="Notifications">
        🔔
        <span v-if="notificationCount > 0" class="notification-badge">{{ notificationCount }}</span>
      </router-link>

      <router-link to="/revenus" class="menu-item">
        <div class="icon">💵</div>
        <h2>Revenus</h2>
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

.notification-icon {
  position: relative;
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

.notification-badge {
  position: absolute;
  top: -8px;
  right: -10px;
  background: red;
  color: white;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 50%;
  font-weight: bold;
}

</style>
