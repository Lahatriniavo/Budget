<template>
  <div>
    <AppHeader />
    
    <div style="margin: 1rem;">
      <label>
        Filtrer par mois : 
        <input type="month" v-model="selectedMonth" />
      </label>

      <label style="margin-left: 1rem;">
        Filtrer par catégorie :
        <select v-model="selectedCategories" multiple size="5" style="margin-left: 0.5rem; min-width: 150px;">
          <option value="">Toutes</option>
          <option>Logement</option>
          <option>Transport</option>
          <option>Alimentation</option>
          <option>Divertissement</option>
          <option>Autres</option>
        </select>
      </label>

      <button @click="resetFilters" style="margin-left: 1rem;padding: 0.5rem 1rem;cursor:pointer" title="Réinitialiser les filtres">Réinitialiser filtres</button>
    </div>

    <ReportChart 
      :transactions="filteredTransactions" 
      :budgets="filteredBudgets" 
      :selectedCategory="selectedCategory"
    />
  </div>
</template>

<script>
import AppHeader from '../components/AppHeader.vue';
import ReportChart from '../components/ReportChart.vue';
import api from '../services/api';

export default {
  components: { AppHeader, ReportChart },
  data() {
    return {
      transactions: [],
      budgets: [],
      selectedMonth: '',
      selectedCategories: [],
    };
  },
computed: {
  filteredTransactions() {
    return this.transactions.filter(t => {
      const matchesMonth = this.selectedMonth ? t.date.startsWith(this.selectedMonth) : true;
      const matchesCategory = this.selectedCategories.length
        ? this.selectedCategories.includes(t.category)
        : true;
      return matchesMonth && matchesCategory;
    });
  },
  filteredBudgets() {
    return this.budgets.filter(b => {
      const matchesMonth = this.selectedMonth ? b.date.startsWith(this.selectedMonth) : true;
      const matchesCategory = this.selectedCategories.length
        ? this.selectedCategories.includes(b.category)
        : true;
      return matchesMonth && matchesCategory;
    });
  },
},
  async created() {
    await this.fetchData();
  },
  methods: {
    resetFilters() {
      this.selectedMonth = '';
      this.selectedCategories = [];
    },
    async fetchData() {
      try {
        const [transRes, budgetsRes] = await Promise.all([
          api.get('/transactions'),
          api.get('/budgets'),
        ]);
        this.transactions = transRes.data;
        this.budgets = budgetsRes.data;
      } catch (error) {
        console.error('Erreur lors du chargement des données pour le rapport :', error);
      }
    },
  },
};
</script>
