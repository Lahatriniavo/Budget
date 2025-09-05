<template>
  <div>
    <h3 style="margin-bottom: 1rem;">Taux de réalisation des objectifs 🎯</h3>
    <Doughnut :data="chartData" :options="chartOptions" />
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
  computed: {
    chartData() {
      const labels = this.goals.map(g => g.name);
      const data = this.goals.map(g => {
        const percent = (g.saved_amount / g.target_amount) * 100;
        return Math.min(percent.toFixed(1), 100);
      });

      return {
        labels,
        datasets: [{
          label: '% atteint',
          data,
          backgroundColor: [
            '#4caf50', '#2196f3', '#ff9800', '#f44336', '#9c27b0'
          ]
        }]
      };
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Objectifs financiers (en % atteints)'
          }
        }
      };
    }
  }
};
</script>
