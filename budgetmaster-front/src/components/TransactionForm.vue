<template>
  <div class="form-container">
    <form @submit.prevent="submitTransaction">
      <input v-model="form.description" placeholder="Description" required />
      <input v-model.number="form.amount" type="number" placeholder="Montant" required />
      <select v-model="form.type" required>
        <option value="">Type</option>
        <option value="revenu">Revenu</option>
        <option value="dépense">Dépense</option>
      </select>
      <input v-model="form.date" type="date" required />
      <select v-model="form.category" required>
        <option disabled value="">Catégorie</option>
        <option>Alimentation</option>
        <option>Logement</option>
        <option>Transport</option>
        <option>Divertissement</option>
        <option>Autres</option>
      </select>
      <button type="submit">{{ form.id ? 'Modifier' : 'Ajouter' }}</button>
      <button v-if="form.id" @click="resetForm" type="button">Annuler</button>
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
  margin-bottom: 1rem;
}

form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: center;
}
input,
select,
button {
  padding: 5px;
}
</style>
