<template>
  <div>
    <AppHeader />

    <div class="container my-4">
      <div class="card p-4 shadow-sm">
        <h2 class="mb-4 fw-bold fs-4 text-center">📈 Rapports Financiers</h2>

        <div class="row g-3 align-items-end mb-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Filtrer par mois :</label>
            <input type="month" v-model="selectedMonth" class="form-control" />
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Filtrer par catégorie :</label>
            <select
              v-model="selectedCategories"
              multiple
              class="form-select"
              size="5"
            >
              <option value="">Toutes</option>
              <option>Logement</option>
              <option>Transport</option>
              <option>Alimentation</option>
              <option>Divertissement</option>
              <option>Autres</option>
            </select>
          </div>

          <div class="col-md-2 d-flex align-items-end">
            <button @click="resetFilters" class="btn btn-secondary w-100">
              Réinitialiser
            </button>
          </div>
        </div>
      </div>

      <!-- Graphiques -->
      <div class="mt-5">
        <ReportChart
          :transactions="filteredTransactions"
          :budgets="filteredBudgets"
          :selectedCategory="selectedCategories"
        />
      </div>
    </div>
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
      return this.transactions.filter((t) => {
        const matchesMonth = this.selectedMonth
          ? t.date.startsWith(this.selectedMonth)
          : true;
        const matchesCategory = this.selectedCategories.length
          ? this.selectedCategories.includes(t.category)
          : true;
        return matchesMonth && matchesCategory;
      });
    },
    filteredBudgets() {
      return this.budgets.filter((b) => {
        const matchesMonth = this.selectedMonth
          ? b.date.startsWith(this.selectedMonth)
          : true;
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
