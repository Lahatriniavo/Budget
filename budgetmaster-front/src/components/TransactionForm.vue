<template>
  <div class="form-container p-3 mb-4 bg-light rounded shadow-sm">
    <form @submit.prevent="submitTransaction" class="d-flex flex-wrap gap-3 align-items-center">
      <input
        v-model="form.description"
        placeholder="Description"
        required
        class="form-control flex-grow-1 min-w-200"
      />
      <input
        v-model.number="form.amount"
        type="number"
        placeholder="Montant"
        required
        class="form-control flex-grow-1 min-w-120"
      />
      <select v-model="form.type" required class="form-select flex-grow-1 min-w-140">
        <option disabled value="">Type</option>
        <option value="revenu">Revenu</option>
        <option value="dépense">Dépense</option>
      </select>
      <input v-model="form.date" type="date" required class="form-control min-w-150" />
      <select v-model="form.category" required class="form-select flex-grow-1 min-w-140">
        <option disabled value="">Catégorie</option>
        <option>Alimentation</option>
        <option>Logement</option>
        <option>Transport</option>
        <option>Divertissement</option>
        <option>Autres</option>
      </select>
      <button type="submit" class="btn btn-primary px-4">
        {{ form.id ? 'Modifier' : 'Ajouter' }}
      </button>
      <button
        v-if="form.id"
        @click="resetForm"
        type="button"
        class="btn btn-secondary px-4"
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
    transactionToEdit: Object,
  },
  data() {
    return {
      form: {
        id: null,
        description: '',
        amount: 0,
        type: '',
        date: '',
        category: '',
      },
    };
  },
  watch: {
    transactionToEdit: {
      handler(newVal) {
        if (newVal) this.form = { ...newVal };
      },
      immediate: true,
    },
  },
  methods: {
    async submitTransaction() {
      try {
        const { id, ...data } = this.form;
        if (id) {
          await api.put(`/transactions/${id}`, data);
        } else {
          await api.post('/transactions', data);
        }
        this.$emit('transactionSaved');
        this.resetForm();
      } catch (error) {
        console.error("Erreur lors de l'enregistrement :", error);
      }
    },
    resetForm() {
      this.form = {
        id: null,
        description: '',
        amount: 0,
        type: '',
        date: '',
        category: '',
      };
      this.$emit('resetEdit');
    },
  },
};
</script>

<style scoped>
.form-container {
  max-width: 900px;
  margin: 0 auto;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.min-w-120 {
  min-width: 120px;
}
.min-w-140 {
  min-width: 140px;
}
.min-w-150 {
  min-width: 150px;
}
.min-w-200 {
  min-width: 200px;
}
button.btn {
  transition: background-color 0.3s ease;
}
button.btn:hover {
  filter: brightness(0.9);
}
</style>
