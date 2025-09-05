<template>
  <div style="max-width: 400px; margin: auto;">
    <h2>Mon Profil</h2>

    <form @submit.prevent="updateProfile">
      <div>
        <label>Nom</label>
        <input v-model="form.name" required />
      </div>

      <div>
        <label>Email</label>
        <input type="email" v-model="form.email" required />
      </div>

      <div>
        <label>Nouveau mot de passe (laissez vide pour ne pas changer)</label>
        <input type="password" v-model="form.password" />
      </div>

      <div>
        <label>Confirmer mot de passe</label>
        <input type="password" v-model="form.password_confirmation" />
      </div>

      <button type="submit">Mettre à jour</button>
    </form>

    <p v-if="message" style="color: green;">{{ message }}</p>
    <p v-if="error" style="color: red;">{{ error }}</p>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      message: '',
      error: '',
    };
  },
  async created() {
    try {
      const res = await api.get('/profile');
      this.form.name = res.data.name;
      this.form.email = res.data.email;
    } catch {
      this.error = 'Erreur lors du chargement du profil';
    }
  },
  methods: {
    async updateProfile() {
      this.message = '';
      this.error = '';

      try {
        const res = await api.put('/profile', this.form);
        this.message = res.data.message;
        // Reset password fields
        this.form.password = '';
        this.form.password_confirmation = '';
      } catch (e) {
        this.error = e.response?.data?.message || 'Erreur lors de la mise à jour';
      }
    },
  },
};
</script>
