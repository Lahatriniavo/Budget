<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Connexion</h2>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="email" class="block mb-1 font-medium text-sm">Adresse email</label>
          <input
            id="email"
            v-model="email"
            type="email"
            placeholder="ex: user@example.com"
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <div>
          <label for="password" class="block mb-1 font-medium text-sm">Mot de passe</label>
          <input
            id="password"
            v-model="password"
            type="password"
            placeholder="••••••••"
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 disabled:opacity-50"
        >
          {{ loading ? 'Connexion...' : 'Se connecter' }}
        </button>

        <p v-if="error" class="text-sm text-red-600 text-center">{{ error }}</p>
      </form>

      <p class="text-center text-sm mt-4">
        Pas encore de compte ?
        <router-link to="/register" class="text-blue-600 hover:underline">Créer un compte</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import { login } from '../services/authService'

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
      loading: false,
    }
  },
  methods: {
    async submit() {
      this.loading = true
      this.error = ''
      try {
        const res = await login({ email: this.email, password: this.password })
        localStorage.setItem('token', res.data.token) // Enregistre le token
        this.$router.push('/budgets') // Redirige vers la page principale
      } catch (e) {
        this.error = 'Email ou mot de passe incorrect.'
        console.error('Erreur de connexion :', e)
      } finally {
        this.loading = false
      }
    },
  },
}
</script>
