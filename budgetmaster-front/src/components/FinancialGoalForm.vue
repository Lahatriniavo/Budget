<template>
  <div style="margin: 1rem 0;">
    <form @submit.prevent="submitGoal">
      <input
        v-model="form.name"
        placeholder="Nom de l'objectif"
        required
        style="margin-right: 10px;"
      />
      <input
        v-model.number="form.target_amount"
        type="number"
        min="0"
        placeholder="Montant cible"
        required
        style="margin-right: 10px; width: 120px;"
      />
      <input
        v-model="form.deadline"
        type="date"
        style="margin-right: 10px;"
      />
      <select v-model="form.category" style="margin-right: 10px;">
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

        if (id) {
          await api.put(`/financial-goals/${id}`, { name, target_amount, deadline, category });
        } else {
          await api.post('/financial-goals', { name, target_amount, deadline, category });
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
