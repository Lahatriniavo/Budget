<template>
  <div>
    <AppHeader />

    <div class="container my-4">
      <h1 class="fw-bold mb-4 text-center">🎯 Mes Objectifs Financiers</h1>

      <!-- Formulaire -->
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <FinancialGoalForm
            :goalToEdit="goalToEdit"
            @goalAdded="fetchGoals"
            @resetEdit="goalToEdit = null"
          />
        </div>
      </div>

      <!-- Liste -->
      <FinancialGoalList
        :goals="goals"
        @editGoal="goalToEdit = $event"
        @deleteGoal="deleteGoal"
        @updateGoalAmount="updateGoalAmount"
      />
    </div>
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
      goalToDelete: null,
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
        try {
          await api.delete(`/financial-goals/${id}`);
          this.fetchGoals();
        } catch (err) {
          console.error("Erreur lors de la suppression :", err);
        }
    },
    async updateGoalAmount(id, newAmount) {
      try {
        await api.patch(`/financial-goals/${id}`, { saved_amount: newAmount });
        this.fetchGoals();
      } catch (err) {
        console.error("Erreur lors de la mise à jour :", err);
      }
    },
  },
  created() {
    this.fetchGoals();
  },
};
</script>
