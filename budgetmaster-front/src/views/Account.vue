<template>
  <header>
    <nav>
      <router-link to="/budgets">Budgets</router-link>
      <router-link to="/transactions">Transactions</router-link>
      <router-link to="/forecasts">Prévisions</router-link>
      <router-link to="/profile">Profil</router-link> <!-- ✅ ici -->
      <button @click="logout">Déconnexion</button>
    </nav>
  </header>
</template>

<script>
import api from '../services/api';
export default {
  methods: {
    async logout() {
      try {
        await api.post('/logout');
        localStorage.removeItem('token');
        this.$router.push('/login');
      } catch (e) {
        console.error('Erreur lors de la déconnexion', e);
      }
    }
  }
}
</script>
