<template>
  <div>
    <h1 style="margin-bottom: 1rem;">Prévisions Budgétaires</h1>

    <ForecastForm
      :forecastToEdit="forecastToEdit"
      @forecastSaved="fetchForecasts"
      @resetEdit="forecastToEdit = null"
    />

    <ForecastList
      :forecasts="forecasts"
      @editForecast="forecastToEdit = $event"
      @deleteForecast="deleteForecast"
    />
  </div>
</template>

<script>
import ForecastForm from '../components/ForecastForm.vue';
import ForecastList from '../components/ForecastList.vue';
import api from '../services/api';

export default {
  components: {
    ForecastForm,
    ForecastList,
  },
  data() {
    return {
      forecasts: [],
      forecastToEdit: null,
    };
  },
  methods: {
    async fetchForecasts() {
      try {
        const res = await api.get('/forecasts');
        this.forecasts = res.data;
        this.forecastToEdit = null;
      } catch (error) {
        console.error('Erreur lors du chargement des prévisions:', error);
      }
    },

    async deleteForecast(id) {
      if (confirm('Voulez-vous vraiment supprimer cette prévision ?')) {
        try {
          await api.delete(`/forecasts/${id}`);
          this.fetchForecasts();
        } catch (error) {
          console.error('Erreur lors de la suppression:', error);
        }
      }
    },
  },
  created() {
    this.fetchForecasts();
  },
};
</script>
