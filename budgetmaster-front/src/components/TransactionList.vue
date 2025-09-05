<template>
  <div class="transaction-list">
    <h2 class="title">📋 Mes Transactions</h2>

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
          <option>Alimentation</option>
          <option>Logement</option>
          <option>Transport</option>
          <option>Divertissement</option>
          <option>Autres</option>
        </select>
      </label>
    </div>

    <!-- Solde -->
    <div class="summary">
      <p><strong>Revenus :</strong> +{{ totalRevenus.toLocaleString('fr-FR') }} Ar</p>
      <p><strong>Dépenses :</strong> -{{ totalDepenses.toLocaleString('fr-FR') }} Ar</p>
      <p><strong>Solde :</strong> {{ solde.toLocaleString('fr-FR') }} Ar</p>
    </div>

    <!-- Liste -->
    <ul class="transaction-items">
      <li v-for="tx in filteredTransactions" :key="tx.id" class="transaction-item">
        <div class="details">
          <strong>{{ tx.description }}</strong> — {{ tx.amount.toLocaleString('fr-FR') }} Ar
          <br />
          <small>📅 {{ formatDate(tx.date) }} — 📂 {{ tx.category }} — 🔖 {{ tx.type }}</small>
        </div>
        <div class="actions">
          <button @click="$emit('editTransaction', tx)" class="edit-btn">Modifier</button>
          <button @click="$emit('deleteTransaction', tx.id)" class="delete-btn">Supprimer</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    transactions: Array,
  },
  data() {
    return {
      selectedMonth: '',
      selectedCategory: '',
    };
  },
  computed: {
    filteredTransactions() {
      return this.transactions.filter((tx) => {
        const matchMonth = this.selectedMonth
          ? tx.date.startsWith(this.selectedMonth)
          : true;

        const matchCategory = this.selectedCategory
          ? tx.category === this.selectedCategory
          : true;

        return matchMonth && matchCategory;
      });
    },
    totalRevenus() {
      return this.filteredTransactions
        .filter((tx) => tx.type === 'revenu')
        .reduce((sum, tx) => sum + Number(tx.amount), 0);
    },
    totalDepenses() {
      return this.filteredTransactions
        .filter((tx) => tx.type === 'dépense')
        .reduce((sum, tx) => sum + Number(tx.amount), 0);
    },
    solde() {
      return this.totalRevenus - this.totalDepenses;
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
.transaction-list {
  max-width: 800px;
  margin: 0 auto;
  padding: 1.5rem;
  font-family: 'Segoe UI', sans-serif;
}

.title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.filters {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 1rem;
}

.summary {
  background: #f4f4f4;
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 6px;
  font-weight: bold;
  color: #333;
}

.transaction-items {
  list-style: none;
  padding: 0;
}

.transaction-item {
  background-color: #fdfdfd;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 1rem;
  margin-bottom: 1rem;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.details {
  margin-bottom: 0.5rem;
}

.actions {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.edit-btn {
  background-color: #f0ad4e;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 4px;
  cursor: pointer;
}

.delete-btn {
  background-color: #d9534f;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 4px;
  cursor: pointer;
}
</style>
