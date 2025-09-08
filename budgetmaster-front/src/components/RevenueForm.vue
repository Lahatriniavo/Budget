<template>
  <div style="margin: 1rem 0;">
    <form @submit.prevent="submitRevenue">
      <input
        v-model="form.source"
        placeholder="Source de revenu"
        required
        style="margin-right: 10px;"
      />
      <input
        v-model.number="form.amount"
        type="number"
        min="0"
        placeholder="Montant"
        required
        style="margin-right: 10px; width: 120px;"
      />
      <input
        v-model="form.date"
        type="date"
        required
        style="margin-right: 10px;"
      />
      <button type="submit">{{ form.id ? 'Modifier' : 'Ajouter' }}</button>
      <button
        v-if="form.id"
        type="button"
        @click="resetForm"
        style="margin-left: 10px;"
      >
        Annuler
      </button>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  props: {
    revenueToEdit: Object,
  },
  data() {
    return {
      form: {
        id: null,
        source: '',
        amount: 0,
        date: '',
      },
    };
  },
  watch: {
    revenueToEdit: {
      handler(newRev) {
        if (newRev) {
          this.form = { ...newRev };
        }
      },
      immediate: true,
    },
  },
  methods: {
    async submitRevenue() {
      const { id, source, amount, date } = this.form;
      try {
        if (id) {
          await api.put(`/revenues/${id}`, { source, amount, date });
        } else {
          await api.post('/revenues', { source, amount, date });
        }

        this.$emit('revenueAdded');
        this.resetForm();
      } catch (err) {
        console.error('Erreur :', err);
      }
    },
    resetForm() {
      this.form = { id: null, source: '', amount: 0, date: '' };
      this.$emit('resetEdit');
    },
  },
};
</script>
