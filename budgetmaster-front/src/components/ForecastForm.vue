<template>
  <div class="my-4">
    <form @submit.prevent="submitForecast" class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label fw-semibold">Catégorie</label>
        <input
          v-model="form.category"
          placeholder="Catégorie"
          required
          class="form-control"
        />
      </div>

      <div class="col-md-2">
        <label class="form-label fw-semibold">Montant</label>
        <input
          v-model.number="form.amount"
          type="number"
          min="0"
          placeholder="Montant"
          required
          class="form-control"
        />
      </div>

      <div class="col-md-3">
        <label class="form-label fw-semibold">Mois</label>
        <input
          v-model="form.month"
          type="month"
          required
          class="form-control"
        />
      </div>

      <div class="col-md-2">
        <label class="form-label fw-semibold">Type</label>
        <select v-model="form.type" required class="form-select">
          <option disabled value="">Type</option>
          <option value="revenu">Revenu</option>
          <option value="dépense">Dépense</option>
        </select>
      </div>

      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">
          {{ form.id ? 'Modifier' : 'Ajouter' }}
        </button>
        <button
          v-if="form.id"
          type="button"
          @click="resetForm"
          class="btn btn-secondary w-100"
        >
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  props: {
    forecastToEdit: Object,
  },
  data() {
    return {
      form: {
        id: null,
        category: '',
        amount: 0,
        month: '',
        type: '',
      },
    };
  },
  watch: {
    forecastToEdit: {
      handler(newForecast) {
        if (newForecast) {
          this.form = { ...newForecast };
        }
      },
      immediate: true,
    },
  },
  methods: {
    async submitForecast() {
      try {
        const { id, category, amount, month, type } = this.form;
        if (id) {
          await api.put(`/forecasts/${id}`, { category, amount, month, type });
        } else {
          await api.post('/forecasts', { category, amount, month, type });
        }
        this.$emit('forecastSaved');
        this.resetForm();
      } catch (err) {
        console.error("Erreur lors de l'enregistrement :", err);
      }
    },
    resetForm() {
      this.form = { id: null, category: '', amount: 0, month: '', type: '' };
      this.$emit('resetEdit');
    },
  },
};
</script>
