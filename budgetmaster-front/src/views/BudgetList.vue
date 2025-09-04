<template>
  <div>
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 1rem;">Mes budgets</h1>

    <!-- Filtres -->
    <div style="margin-bottom: 1rem;">
      <label>
        Mois :
        <input type="month" v-model="selectedMonth" />
      </label>

      <label style="margin-left: 1rem;">
        Catégorie :
        <select v-model="selectedCategory">
          <option value="">Toutes</option>
          <option>Logement</option>
          <option>Transport</option>
          <option>Alimentation</option>
          <option>Divertissement</option>
          <option>Autres</option>
        </select>
      </label>
    </div>

    <!-- Total -->
    <p style="font-weight: bold;">Total : {{ filteredTotal }} Ariary</p>

    <!-- Liste filtrée -->
    <ul>
      <li
        v-for="budget in filteredBudgets"
        :key="budget.id"
        style="margin-bottom: 10px;"
      >
        <strong>{{ budget.name }}</strong> — {{ budget.amount }} Ar
        <br />
        <small>📅 {{ formatDate(budget.date) }} — 📂 {{ budget.category }}</small>
        <br />
        <button @click="$emit('editBudget', budget)" style="margin-right: 5px;">Modifier</button>
        <button @click="$emit('deleteBudget', budget.id)" style="color: red;">Supprimer</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    budgets: Array,
  },
  data() {
    return {
      selectedMonth: '',
      selectedCategory: '',
    };
  },
  computed: {
    filteredBudgets() {
      return this.budgets.filter((b) => {
        const matchesMonth = this.selectedMonth
          ? b.date.startsWith(this.selectedMonth)
          : true;

        const matchesCategory = this.selectedCategory
          ? b.category === this.selectedCategory
          : true;

        return matchesMonth && matchesCategory;
      });
    },
    filteredTotal() {
      return this.filteredBudgets.reduce((sum, b) => sum + b.amount, 0);
    },
  },
  methods: {
    formatDate(dateStr) {
      return new Date(dateStr).toLocaleDateString();
    },
  },
};
</script>
