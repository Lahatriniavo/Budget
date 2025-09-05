<template>
  <div>
    <h2>Rapports graphiques</h2>

    <div style="max-width: 600px; margin: auto;">
      <h3>Dépenses par catégorie</h3>
      <PieChart :chartData="pieDataTransactions" />

      <h3 style="margin-top: 2rem;">Budgets par catégorie</h3>
      <PieChart :chartData="pieDataBudgets" />

      <h3 style="margin-top: 2rem;">Revenus vs Dépenses vs Budget prévu</h3>
      <BarChart :chartData="barData" />
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

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, BarElement);

export default {
  components: {
    PieChart: {
      extends: Pie,
      props: ['chartData'],
      mounted() {
        this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });
      },
      watch: {
        chartData() {
          this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });
        }
      }
    },
    BarChart: {
      extends: Bar,
      props: ['chartData'],
      mounted() {
        this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });
      },
      watch: {
        chartData() {
          this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });
        }
      }
    }
  },
  props: {
    transactions: Array,
    budgets: Array,
  },
  computed: {
    pieDataTransactions() {
      const categories = {};
      this.transactions.forEach(t => {
        if (t.amount < 0) { // dépenses
          const cat = t.category || 'Autres';
          categories[cat] = (categories[cat] || 0) + Math.abs(t.amount);
        }
      });

      return {
        labels: Object.keys(categories),
        datasets: [
          {
            label: 'Dépenses par catégorie',
            backgroundColor: ['#f87979', '#a8dadc', '#457b9d', '#e76f51', '#2a9d8f'],
            data: Object.values(categories),
          }
        ],
      };
    },
    pieDataBudgets() {
      const categories = {};
      this.budgets.forEach(b => {
        const cat = b.category || 'Autres';
        categories[cat] = (categories[cat] || 0) + b.amount;
      });

      return {
        labels: Object.keys(categories),
        datasets: [
          {
            label: 'Budgets par catégorie',
            backgroundColor: ['#f4a261', '#e9c46a', '#264653', '#2a9d8f', '#e76f51'],
            data: Object.values(categories),
          }
        ],
      };
    },
    barData() {
      let revenus = 0;
      let depenses = 0;
      let budgetTotal = 0;

      this.transactions.forEach(t => {
        if (t.amount >= 0) revenus += t.amount;
        else depenses += Math.abs(t.amount);
      });

      this.budgets.forEach(b => {
        budgetTotal += b.amount;
      });

      return {
        labels: ['Revenus', 'Dépenses', 'Budget prévu'],
        datasets: [
          {
            label: 'Montant',
            backgroundColor: ['#2a9d8f', '#e76f51', '#f4a261'],
            data: [revenus, depenses, budgetTotal],
          }
        ],
      };
    }
  }
};
</script>

<style scoped>
h2 {
  text-align: center;
  margin-bottom: 2rem;
}
</style>
