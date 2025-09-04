<template>
  <div style="margin: 1rem 0;">
    <form @submit.prevent="submitBudget">
      <input
        v-model="form.name"
        placeholder="Nom du budget"
        required
        style="margin-right: 10px;"
      />
      <input
        v-model.number="form.amount"
        type="number"
        min="0"
        placeholder="Montant"
        required
        style="margin-right: 10px; width: 80px;"
      />
      <input
        v-model="form.date"
        type="date"
        required
        style="margin-right: 10px;"
      />
      <select v-model="form.category" required style="margin-right: 10px;">
        <option disabled value="">Catégorie</option>
        <option>Logement</option>
        <option>Transport</option>
        <option>Alimentation</option>
        <option>Divertissement</option>
        <option>Autres</option>
      </select>
      <button type="submit">{{ form.id ? 'Modifier' : 'Ajouter' }}</button>
      <button v-if="form.id" type="button" @click="resetForm" style="margin-left: 10px;">Annuler</button>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  props: {
    budgetToEdit: Object,
  },
  data() {
    return {
      form: {
        id: null,
        name: '',
        amount: 0,
        date: '',
        category: '',
      },
    };
  },
  watch: {
    budgetToEdit: {
      handler(newBudget) {
        if (newBudget) {
          this.form = { ...newBudget };
        }
      },
      immediate: true,
    },
  },
  methods: {
    async submitBudget() {
      try {
        const { id, name, amount, date, category } = this.form;

        if (id) {
          await api.put(`/budgets/${id}`, { name, amount, date, category });
        } else {
          await api.post('/budgets', { name, amount, date, category });
        }

        this.$emit('budgetAdded');
        this.resetForm();
      } catch (err) {
        console.error("Erreur lors de l'enregistrement :", err);
      }
    },
    resetForm() {
      this.form = { id: null, name: '', amount: 0, date: '', category: '' };
      this.$emit('resetEdit');
    },
  },
};
</script>
