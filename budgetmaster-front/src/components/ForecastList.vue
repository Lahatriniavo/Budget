<template>
  <div>
    <h2 style="font-size: 22px; font-weight: bold; margin-bottom: 1rem;">Mes Prévisions</h2>

    <!-- Filtres -->
    <div style="margin-bottom: 1rem;">
      <label>
        Mois :
        <input type="month" v-model="selectedMonth" />
      </label>

      <label style="margin-left: 1rem;">
        Type :
        <select v-model="selectedType">
          <option value="">Tous</option>
          <option value="revenu">Revenu</option>
          <option value="dépense">Dépense</option>
        </select>
      </label>
    </div>

    <!-- Total -->
    <p style="font-weight: bold;">
      Total : {{ filteredTotal.toLocaleString('fr-FR') }} Ariary
    </p>

    <!-- Liste filtrée -->
    <ul>
      <li v-for="forecast in filteredForecasts" :key="forecast.id" style="margin-bottom: 10px;">
        <strong>{{ forecast.category }}</strong> — {{ forecast.amount.toLocaleString('fr-FR') }} Ar
        <br />
        <small>📅 {{ formatMonth(forecast.month) }} — 📂 {{ forecast.type }}</small>
        <br />
        <button @click="$emit('editForecast', forecast)" style="margin-right: 5px;">Modifier</button>
        <button @click="$emit('deleteForecast', forecast.id)" style="color: red;">Supprimer</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    forecasts: Array,
  },
  data() {
    return {
      selectedMonth: '',
      selectedType: '',
    };
  },
  computed: {
    filteredForecasts() {
      return this.forecasts.filter(forecast => {
        const matchesMonth = this.selectedMonth
          ? forecast.month === this.selectedMonth
          : true;

        const matchesType = this.selectedType
          ? forecast.type === this.selectedType
          : true;

        return matchesMonth && matchesType;
      });
    },
    filteredTotal() {
      return this.filteredForecasts.reduce((sum, f) => sum + Number(f.amount), 0);
    },
  },
  methods: {
    formatMonth(monthStr) {
      // Convertit "YYYY-MM" en "MM/YYYY"
      if (!monthStr) return '';
      const [year, month] = monthStr.split('-');
      return `${month}/${year}`;
    },
  },
};
</script>
