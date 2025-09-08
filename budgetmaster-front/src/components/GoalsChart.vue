<template>
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">🎯 Taux de Réalisation des Objectifs</h3>

      <div class="text-end mb-3">
        <button class="btn btn-outline-secondary btn-sm" @click="toggleHideCompleted">
          {{ hideCompleted ? 'Afficher tous les objectifs' : 'Masquer les objectifs atteints' }}
        </button>
      </div>

      <div class="chart-container mb-4" style="position: relative; height: 350px;">
        <Doughnut :data="chartData" :options="chartOptions" />
      </div>

      <div v-if="filteredGoals.length">
        <ul class="list-group">
          <li
            v-for="goal in filteredGoals"
            :key="goal.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            {{ goal.name }}
            <span
              class="badge rounded-pill"
              :class="badgeClass(goal)"
            >
              {{ percentSaved(goal) }}%
            </span>
          </li>
        </ul>
      </div>
      <div v-else class="text-center text-muted mt-3">
        Aucun objectif à afficher.
      </div>
    </div>
  </div>
</template>

<script>
import { Doughnut } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default {
  name: 'GoalsChart',
  components: { Doughnut },
  props: {
    goals: Array
  },
  data() {
    return {
      hideCompleted: false,
    };
  },
  computed: {
    filteredGoals() {
      if (!this.hideCompleted) return this.goals;
      return this.goals.filter(g => this.percentSaved(g) < 100);
    },
    chartData() {
      const labels = this.filteredGoals.map(g => g.name);
      const data = this.filteredGoals.map(g => {
        const percent = this.percentSaved(g);
        return Number(percent);
      });
      const backgroundColor = this.filteredGoals.map(g => this.getColor(g));

      return {
        labels,
        datasets: [{
          label: '% atteint',
          data,
          backgroundColor,
          borderWidth: 1,
        }]
      };
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              color: '#555',
              font: {
                size: 14
              }
            }
          },
          title: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: (tooltipItem) => {
                const label = tooltipItem.label || '';
                const value = tooltipItem.raw || 0;
                return `${label} : ${value}% atteint`;
              }
            }
          }
        }
      };
    }
  },
  methods: {
    percentSaved(goal) {
      if (!goal.target_amount) return 0;
      return Math.min(((goal.saved_amount / goal.target_amount) * 100).toFixed(1), 100);
    },
    getColor(goal) {
      const percent = this.percentSaved(goal);
      if (percent < 50) return '#e74c3c'; // Rouge
      if (percent < 75) return '#f39c12'; // Orange
      return '#2ecc71'; // Vert
    },
    badgeClass(goal) {
      const percent = this.percentSaved(goal);
      if (percent < 50) return 'bg-danger';
      if (percent < 75) return 'bg-warning text-dark';
      return 'bg-success';
    },
    toggleHideCompleted() {
      this.hideCompleted = !this.hideCompleted;
    }
  }
};
</script>

<style scoped>
.chart-container {
  max-width: 600px;
  margin: 0 auto;
}
</style>
