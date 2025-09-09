<template>
  <form @submit.prevent="submitGoal" class="row gy-3 align-items-end">
    <div class="col-md-3">
      <label class="form-label">Nom de l'objectif</label>
      <input v-model="form.name" type="text" class="form-control" required />
    </div>

    <div class="col-md-2">
      <label class="form-label">Montant cible</label>
      <input
        v-model.number="form.target_amount"
        type="number"
        min="0"
        class="form-control"
        required
      />
    </div>

    <div class="col-md-3">
      <label class="form-label">Date limite</label>
      <input v-model="form.deadline" type="date" class="form-control" />
    </div>

    <div class="col-md-2">
      <label class="form-label">Catégorie</label>
      <select v-model="form.category" class="form-select">
        <option disabled value="">Choisir...</option>
        <option>Logement</option>
        <option>Transport</option>
        <option>Alimentation</option>
        <option>Divertissement</option>
        <option>Autres</option>
      </select>
    </div>

    <div class="col-md-2 d-grid">
      <button type="submit" class="btn btn-primary">
        {{ form.id ? 'Modifier' : 'Ajouter' }}
      </button>
    </div>

    <div v-if="form.id" class="col-md-12 text-end">
      <button type="button" @click="resetForm" class="btn btn-outline-secondary">
        Annuler
      </button>
    </div>
  </form>
</template>

<script>
import api from '../services/api';

export default {
  props: {
    goalToEdit: Object,
  },
  data() {
    return {
      form: {
        id: null,
        name: '',
        target_amount: 0,
        deadline: '',
        category: '',
      },
    };
  },
  watch: {
    goalToEdit: {
      handler(newGoal) {
        if (newGoal) {
          this.form = { ...newGoal };
        }
      },
      immediate: true,
    },
  },
  methods: {
    async submitGoal() {
      try {
        const { id, name, target_amount, deadline, category } = this.form;

        const payload = { name, target_amount, deadline, category, saved_amount: this.form.saved_amount || 0 };
        console.log(payload);

        if (id) {
          await api.put(`/financial-goals/${id}`, { ...payload });
        } else {
          await api.post('/financial-goals', { ...payload, newAmount: 0 });
        }

        this.$emit('goalAdded');
        this.resetForm();
      } catch (err) {
        console.error("Erreur lors de l'enregistrement :", err);
      }
    },
    resetForm() {
      this.form = { id: null, name: '', target_amount: 0, deadline: '', category: '' };
      this.$emit('resetEdit');
    },
  },
};
</script>
