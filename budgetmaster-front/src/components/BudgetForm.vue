<template>
  <div class="container py-4" style="max-width: 600px;">
    <form @submit.prevent="submitBudget" class="needs-validation" novalidate>
      
      <div class="mb-3 row align-items-center">
        <label for="budgetName" class="col-4 col-form-label text-end">Nom</label>
        <div class="col-8">
          <input
            id="budgetName"
            v-model="form.name"
            type="text"
            class="form-control"
            placeholder="Nom du budget"
            required
          />
          <div class="invalid-feedback">Veuillez saisir un nom.</div>
        </div>
      </div>

      <div class="mb-3 row align-items-center">
        <label for="budgetAmount" class="col-4 col-form-label text-end">Montant</label>
        <div class="col-8">
          <input
            id="budgetAmount"
            v-model.number="form.amount"
            type="number"
            min="0"
            class="form-control"
            placeholder="Montant"
            required
          />
          <div class="invalid-feedback">Veuillez saisir un montant valide.</div>
        </div>
      </div>

      <div class="mb-3 row align-items-center">
        <label for="budgetDate" class="col-4 col-form-label text-end">Date</label>
        <div class="col-8">
          <input
            id="budgetDate"
            v-model="form.date"
            type="date"
            class="form-control"
            required
          />
          <div class="invalid-feedback">Veuillez sélectionner une date.</div>
        </div>
      </div>

      <div class="mb-4 row align-items-center">
        <label for="budgetCategory" class="col-4 col-form-label text-end">Catégorie</label>
        <div class="col-8">
          <select
            id="budgetCategory"
            v-model="form.category"
            class="form-select"
            required
          >
            <option value="" disabled>Catégorie</option>
            <option>Logement</option>
            <option>Transport</option>
            <option>Alimentation</option>
            <option>Divertissement</option>
            <option>Autres</option>
          </select>
          <div class="invalid-feedback">Veuillez sélectionner une catégorie.</div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary">
          {{ form.id ? 'Modifier' : 'Ajouter' }}
        </button>
        <button
          v-if="form.id"
          type="button"
          @click="resetForm"
          class="btn btn-secondary"
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
        } else {
          this.resetForm();
        }
      },
      immediate: true,
    },
  },
  methods: {
    async submitBudget() {
      const formEl = this.$el.querySelector('form');
      if (!formEl.checkValidity()) {
        formEl.classList.add('was-validated');
        return;
      }
      try {
        const { id, name, amount, date, category } = this.form;

        if (id) {
          await api.put(`/budgets/${id}`, { name, amount, date, category });
        } else {
          await api.post('/budgets', { name, amount, date: this.form.date, category });
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
      this.$nextTick(() => {
        const formEl = this.$el.querySelector('form');
        formEl.classList.remove('was-validated');
      });
    },
  },
};
</script>
