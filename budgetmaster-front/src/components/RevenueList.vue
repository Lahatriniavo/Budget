<template>
  <div>
    <h2 style="font-size: 20px; margin-bottom: 1rem;">Mes revenus</h2>

    <!-- Filtres -->
    <div style="margin-bottom: 1rem;">
      <label>
        Mois :
        <input type="month" v-model="selectedMonth" />
      </label>
      <label style="margin-left: 1rem;">
        Source :
        <input type="text" v-model="filterSource" placeholder="Ex: Salaire" />
      </label>
    </div>

    <!-- Total -->
    <p style="font-weight: bold;">Total : {{ filteredTotal }} Ar</p>

    <ul>
      <li v-for="rev in filteredRevenues" :key="rev.id" style="margin-bottom: 15px;">
        <strong>{{ rev.source }}</strong> — {{ rev.amount }} Ar
        <br />
        <small>📅 {{ formatDate(rev.date) }}</small>
        <br />
        <button @click="$emit('editRevenue', rev)" style="margin-right: 5px;">Modifier</button>
        <button @click="$emit('deleteRevenue', rev.id)" style="color: red;">Supprimer</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    revenues: Array,
  },
  data() {
    return {
      selectedMonth: '',
      filterSource: '',
    };
  },
  computed: {
    filteredRevenues() {
      return this.revenues.filter((r) => {
        const matchesMonth = this.selectedMonth
          ? r.date.startsWith(this.selectedMonth)
          : true;

        const matchesSource = this.filterSource
          ? r.source.toLowerCase().includes(this.filterSource.toLowerCase())
          : true;

        return matchesMonth && matchesSource;
      });
    },
    filteredTotal() {
      return this.filteredRevenues.reduce((sum, r) => sum + r.amount, 0).toLocaleString('fr-FR');
    },
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
  },
};
</script>
