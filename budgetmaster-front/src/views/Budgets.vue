<template>
  <div>
    <AppHeader />
    <BudgetForm
      :budgetToEdit="budgetToEdit"
      @budgetAdded="fetchBudgets"
      @resetEdit="budgetToEdit = null"
    />
    <BudgetList
      :budgets="budgets"
      @editBudget="budgetToEdit = $event"
      @deleteBudget="deleteBudget"
    />
  </div>
</template>

<script>
import BudgetList from '../components/BudgetList.vue';
import BudgetForm from '../components/BudgetForm.vue';
import AppHeader from '../components/AppHeader.vue';
import api from '../services/api';

export default {
  components: { BudgetList, BudgetForm, AppHeader },
  data() {
    return {
      budgets: [],
      budgetToEdit: null,
    };
  },
  methods: {
    async fetchBudgets() {
      try {
        const res = await api.get('/budgets');
        this.budgets = res.data;
      } catch (err) {
        console.error("Erreur lors du chargement des budgets :", err);
      }
    },
    async deleteBudget(id) {
        try {
          await api.delete(`/budgets/${id}`);
          this.fetchBudgets();
        } catch (err) {
          console.error("Erreur lors de la suppression :", err);
        }
      
    }
  },
  created() {
    this.fetchBudgets();
  },
};
</script>
