<template>
  <div class="budget-list">
    <h1 class="title">💰 Mes budgets</h1>

    <!-- Filtres -->
    <div class="filters">
      <label>
        Mois :
        <input type="month" v-model="selectedMonth" />
      </label>

      <label>
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
    <p class="total">Total : {{ formattedTotal }}</p>

    <!-- Liste filtrée -->
    <ul class="budget-items">
      <li
        v-for="budget in filteredBudgets"
        :key="budget.id"
        class="budget-item"
      >
        <div class="budget-info">
          <strong>{{ budget.name }}</strong> — {{ budget.amount.toLocaleString('fr-FR') }} Ar
          <br />
          <small>📅 {{ formatDate(budget.date) }} — 📂 {{ budget.category }}</small>
        </div>
        <div class="budget-actions">
          <button @click="$emit('editBudget', budget)" class="edit-btn">Modifier</button>
          <button @click="$emit('deleteBudget', budget.id)" class="delete-btn">Supprimer</button>
        </div>
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
      return this.filteredBudgets.reduce((sum, b) => sum + Number(b.amount), 0);
    },
    formattedTotal() {
      return this.filteredTotal.toLocaleString('fr-FR', {
        style: 'currency',
        currency: 'MGA',
        minimumFractionDigits: 0,
      });
    },
  },
  methods: {
    formatDate(dateStr) {
      return new Date(dateStr).toLocaleDateString('fr-FR');
    },
  },
};
</script>

<style scoped>
.budget-list {
  max-width: 800px;
  margin: 0 auto;
  padding: 1.5rem;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.title {
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.filters {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1.2rem;
  align-items: center;
}

.filters label {
  font-size: 0.9rem;
  color: #333;
}

.total {
  font-weight: bold;
  font-size: 1.1rem;
  color: #2d6a4f;
  margin-bottom: 1rem;
}

.budget-items {
  list-style: none;
  padding: 0;
}

.budget-item {
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 1rem;
  margin-bottom: 1rem;
  background-color: #f9f9f9;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.budget-info {
  margin-bottom: 0.5rem;
  color: #333;
}

.budget-actions {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.edit-btn,
.delete-btn {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  font-size: 0.85rem;
  cursor: pointer;
}

.edit-btn {
  background-color: #f0ad4e;
  color: white;
}

.delete-btn {
  background-color: #d9534f;
  color: white;
}
</style>
