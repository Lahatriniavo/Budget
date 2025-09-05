<template>
  <div style="margin: 1rem 0;">
    <form @submit.prevent="submitForecast">
      <input
        v-model="form.category"
        placeholder="Catégorie"
        required
        style="margin-right: 10px;"
      />

      <input
        v-model.number="form.amount"
        type="number"
        min="0"
        placeholder="Montant"
        required
        style="margin-right: 10px; width: 100px;"
      />

      <input
        v-model="form.month"
        type="month"
        required
        style="margin-right: 10px;"
      />

      <select v-model="form.type" required style="margin-right: 10px;">
        <option disabled value="">Type</option>
        <option value="revenu">Revenu</option>
        <option value="dépense">Dépense</option>
      </select>

      <button type="submit">{{ form.id ? 'Modifier' : 'Ajouter' }}</button>
      <button v-if="form.id" type="button" @click="resetForm" style="margin-left: 10px;">
        Annuler
      </button>
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
