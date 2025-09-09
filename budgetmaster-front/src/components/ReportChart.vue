<template>
  <div class="container report-chart mt-5">
    <h2 class="text-center mb-5 fw-bold">📊 Rapports Graphiques</h2>

    <div class="row g-4 justify-content-center">
      <!-- Dépenses par catégorie -->
      <div class="col-lg-6 col-md-10">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="text-center mb-3">Dépenses par catégorie</h5>
          <div style="height: 300px;">
            <PieChart :chartData="pieDataTransactions" />
          </div>
        </div>
      </div>

      <!-- Budgets par catégorie -->
      <div class="col-lg-6 col-md-10">
        <div class="card shadow-sm p-3 h-100">
          <h5 class="text-center mb-3">Budgets par catégorie</h5>
          <div style="height: 300px;">
            <PieChart :chartData="pieDataBudgets" />
          </div>
        </div>
      </div>

      <!-- Bar chart -->
      <div class="col-12">
        <div class="card shadow-sm p-3 mt-4">
          <h5 class="text-center mb-3">Revenus vs Dépenses vs Budget</h5>
          <div style="height: 400px;">
            <BarChart :chartData="barData" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Pie, Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement,
} from 'chart.js';
import PieChart from './PieChart.vue';
import BarChart from './Barchart.vue';
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement
);

export default {
  components: {
    // PieChart: {
    //   extends: Pie,
    //   props: ['chartData'],
    //   mounted() {
    //     this.renderChart(this.chartData, {
    //       responsive: true,
    //       maintainAspectRatio: false,
    //     });
    //   },
    //   watch: {
    //     chartData() {
    //       this.renderChart(this.chartData, {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //       });
    //     },
    //   },
    // },
    // BarChart: {
    //   extends: Bar,
    //   props: ['chartData'],
    //   mounted() {
    //     this.renderChart(this.chartData, {
    //       responsive: true,
    //       maintainAspectRatio: false,
    //     });
    //   },
    //   watch: {
    //     chartData() {
    //       this.renderChart(this.chartData, {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //       });
    //     },
    //   },
    // },
    PieChart,
    BarChart,
  },
  props: {
    transactions: Array,
    budgets: Array,
  },
  computed: {
    pieDataTransactions() {
      const categories = {};
      this.transactions.forEach((t) => {
        if (t.amount < 0) {
          const cat = t.category || 'Autres';
          categories[cat] = (categories[cat] || 0) + Math.abs(t.amount);
        }
      });

      return {
        labels: Object.keys(categories),
        datasets: [
          {
            label: 'Dépenses',
            backgroundColor: ['#e76f51', '#f4a261', '#2a9d8f', '#264653', '#a8dadc'],
            data: Object.values(categories),
          },
        ],
      };
    },
    pieDataBudgets() {
      const categories = {};
      this.budgets.forEach((b) => {
        const cat = b.category || 'Autres';
        categories[cat] = (categories[cat] || 0) + b.amount;
      });

      return {
        labels: Object.keys(categories),
        datasets: [
          {
            label: 'Budgets',
            backgroundColor: ['#fcbf49', '#f77f00', '#003049', '#eae2b7', '#d62828'],
            data: Object.values(categories),
          },
        ],
      };
    },
    barData() {
      let revenus = 0;
      let depenses = 0;
      let budgetTotal = 0;

      this.transactions.forEach((t) => {
        if (t.amount >= 0) revenus += t.amount;
        else depenses += Math.abs(t.amount);
      });

      this.budgets.forEach((b) => {
        budgetTotal += b.amount;
      });

      return {
        labels: ['Revenus', 'Dépenses', 'Budget prévu'],
        datasets: [
          {
            label: 'Montant',
            backgroundColor: ['#2a9d8f', '#e76f51', '#f4a261'],
            data: [revenus, depenses, budgetTotal],
          },
        ],
      };
    },
  },
};
</script>

<style scoped>
.report-chart h5 {
  font-weight: 600;
  text-align: center;
}
</style>
