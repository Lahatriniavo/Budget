<template>
  <div class="container">
    <h2>Créer un compte</h2>
    <form @submit.prevent="submit">
      <input v-model="name" placeholder="Nom" class="input" required />
      <input v-model="email" type="email" placeholder="Email" class="input" required />
      <input v-model="password" type="password" placeholder="Mot de passe" class="input" required />
      <input v-model="password_confirmation" type="password" placeholder="Confirmation" class="input" required />
      <button class="btn">S'inscrire</button>
    </form>
    <router-link to="/login" class="link">Déjà inscrit ?</router-link>
  </div>
</template>

<style>
.container {
  max-width: 400px;
  margin: 2rem auto;
  padding: 1.5rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-family: Arial, sans-serif;
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.input {
  display: block;
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn {
  background-color: #3182ce; /* bleu */
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn:hover {
  background-color: #2b6cb0;
}

.link {
  color: #3182ce;
  font-size: 0.9rem;
  text-decoration: none;
}

.link:hover {
  text-decoration: underline;
}
</style>


<script>
import { register } from '../services/authService';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    };
  },
  methods: {
    async submit() {
      try {
        await register({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });
        this.$router.push('/login');
      } catch (e) {
        alert("Erreur à l'inscription");
        console.error(e);
      }
    },
  },
};
</script>
