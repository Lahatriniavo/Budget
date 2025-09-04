<template>
  <nav class="bg-gray-800 text-white px-6 py-3 flex justify-between items-center">
    <div class="text-xl font-bold">BudgetMaster</div>

    <div class="space-x-4">
      <router-link to="/budgets" class="hover:underline">Budgets</router-link>
      <router-link to="/transactions" class="hover:underline">Transactions</router-link>
      <router-link to="/forecasts" class="hover:underline">Prévisions</router-link>
      <router-link to="/profile" class="hover:underline">Profil</router-link>
      <button @click="logoutUser" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded">
        Déconnexion
      </button>
    </div>
  </nav>
</template>

<script>
import { logout } from '../services/authService'

export default {
  methods: {
    async logoutUser() {
      const confirmed = confirm('Êtes-vous sûr de vouloir vous déconnecter ?');
      if (!confirmed) return;

      try {
        await logout();
      } catch (e) {
        console.warn("Erreur lors de l'appel API logout :", e);
        // Même si l'API échoue, on supprime quand même le token côté client
      } finally {
        localStorage.removeItem('token');
        this.$router.push('/login');
      }
    }
  }
}
</script>
