<template>
  <div>
    <AppHeader />
    <FinancialGoalForm
      :goalToEdit="goalToEdit"
      @goalAdded="fetchGoals"
      @resetEdit="goalToEdit = null"
    />
    <FinancialGoalList
      :goals="goals"
      @editGoal="goalToEdit = $event"
      @deleteGoal="deleteGoal"
    />
  </div>
</template>

<script>
import FinancialGoalForm from '../components/FinancialGoalForm.vue';
import FinancialGoalList from '../components/FinancialGoalList.vue';
import AppHeader from '../components/AppHeader.vue';
import api from '../services/api';

export default {
  components: { FinancialGoalForm, FinancialGoalList, AppHeader },
  data() {
    return {
      goals: [],
      goalToEdit: null,
    };
  },
  methods: {
    async fetchGoals() {
      try {
        const res = await api.get('/financial-goals');
        this.goals = res.data;
      } catch (err) {
        console.error("Erreur lors du chargement des objectifs :", err);
      }
    },
    async deleteGoal(id) {
      if (confirm('Voulez-vous vraiment supprimer cet objectif ?')) {
        try {
          await api.delete(`/financial-goals/${id}`);
          this.fetchGoals();
        } catch (err) {
          console.error("Erreur lors de la suppression :", err);
        }
      }
    },
  },
  created() {
    this.fetchGoals();
  },
};
</script>
