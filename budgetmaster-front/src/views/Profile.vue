<template>
  <div class="container mt-5" style="max-width: 600px;">
    <h1 class="mb-4">Mon Profil</h1>

    <form @submit.prevent="updateProfile" novalidate :class="{ 'was-validated': validated }" enctype="multipart/form-data">
      <!-- Affichage de la photo -->
      <div class="mb-3 text-center">
        <img
          v-if="profilePhotoUrl"
          :src="profilePhotoUrl"
          alt="Photo de profil"
          class="rounded-circle"
          style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ddd;"
        />
        <div v-else class="placeholder rounded-circle bg-secondary d-inline-block" style="width:120px; height:120px;"></div>
      </div>

      <!-- Input pour choisir une nouvelle photo -->
      <div class="mb-3">
        <label for="photo" class="form-label">Changer la photo de profil :</label>
        <input
          ref="photoInput"
          @change="onPhotoSelected"
          type="file"
          accept="image/*"
          class="form-control"
          id="photo"
          :class="{ 'is-invalid': errors.photo }"
        />
        <div class="invalid-feedback" v-if="errors.photo">{{ errors.photo }}</div>
      </div>

      <!-- Les autres champs -->
      <div class="mb-3">
        <label for="name" class="form-label">Nom :</label>
        <input
          v-model="form.name"
          type="text"
          class="form-control"
          id="name"
          required
          :class="{'is-invalid': errors.name}"
        />
        <div class="invalid-feedback" v-if="errors.name">{{ errors.name }}</div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email :</label>
        <input
          v-model="form.email"
          type="email"
          class="form-control"
          id="email"
          required
          :class="{'is-invalid': errors.email}"
        />
        <div class="invalid-feedback" v-if="errors.email">{{ errors.email }}</div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe :</label>
        <input
          v-model="form.password"
          type="password"
          class="form-control"
          id="password"
          placeholder="Laissez vide pour ne pas changer"
          :class="{'is-invalid': errors.password}"
        />
        <div class="invalid-feedback" v-if="errors.password">{{ errors.password }}</div>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirmer mot de passe :</label>
        <input
          v-model="form.password_confirmation"
          type="password"
          class="form-control"
          id="password_confirmation"
          placeholder="Confirmation du mot de passe"
          :class="{'is-invalid': errors.password_confirmation}"
        />
        <div class="invalid-feedback" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</div>
      </div>

      <button type="submit" class="btn btn-primary" :disabled="loading">
        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span v-if="!loading">Mettre à jour</span>
      </button>
    </form>

    <div v-if="message" :class="['alert mt-4', messageType]" role="alert">
      {{ message }}
    </div>
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
        photo: null, // fichier photo sélectionné
      },
      profilePhotoUrl: '', // URL de la photo actuelle (ou vide)
      errors: {},
      message: '',
      messageType: '',
      loading: false,
      validated: false,
    };
  },
  async created() {
    try {
      const res = await api.get('/profile');
      this.form.name = res.data.name;
      this.form.email = res.data.email;
      this.profilePhotoUrl = res.data.photo_url || ''; // Assure-toi que backend renvoie l'url de la photo
    } catch (err) {
      console.error('Erreur lors du chargement du profil', err);
      this.message = "Impossible de charger les données du profil.";
      this.messageType = 'alert-danger';
    }
  },
  methods: {
    onPhotoSelected(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.photo = file;
        this.profilePhotoUrl = URL.createObjectURL(file); // preview immédiate
      }
    },
    async updateProfile() {
      this.loading = true;
      this.errors = {};
      this.message = '';
      this.messageType = '';
      this.validated = true;

      try {
        const formData = new FormData();
        formData.append('name', this.form.name);
        formData.append('email', this.form.email);
        if (this.form.password) {
          formData.append('password', this.form.password);
          formData.append('password_confirmation', this.form.password_confirmation);
        }
        if (this.form.photo) {
          formData.append('photo', this.form.photo);
        }

        const res = await api.put('/profile', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        this.message = res.data.message || 'Profil mis à jour avec succès.';
        this.messageType = 'alert-success';

        // Reset password et photo input après succès
        this.form.password = '';
        this.form.password_confirmation = '';
        this.form.photo = null;
        this.$refs.photoInput.value = null;
        this.validated = false;

        // Met à jour l'URL photo si serveur renvoie nouvelle URL
        if (res.data.photo_url) {
          this.profilePhotoUrl = res.data.photo_url;
        }

      } catch (error) {
        this.messageType = 'alert-danger';

        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          this.message = "Erreur lors de la mise à jour.";
          console.error(error);
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.placeholder {
  width: 120px;
  height: 120px;
}
</style>
