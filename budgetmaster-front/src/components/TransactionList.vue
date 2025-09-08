<template>
  <div class="transaction-list container p-4 bg-white rounded shadow-sm">
    <h2 class="title mb-4">📋 Mes Transactions</h2>

    <!-- Filtres -->
    <div class="filters d-flex flex-wrap gap-3 mb-4 align-items-center">
      <div>
        <label for="filterMonth" class="form-label fw-semibold me-2">Mois :</label>
        <input id="filterMonth" type="month" v-model="selectedMonth" class="form-control" />
      </div>
      <div>
        <label for="filterCategory" class="form-label fw-semibold me-2">Catégorie :</label>
        <select id="filterCategory" v-model="selectedCategory" class="form-select">
          <option value="">Toutes</option>
          <option>Alimentation</option>
          <option>Logement</option>
          <option>Transport</option>
          <option>Divertissement</option>
          <option>Autres</option>
        </select>
      </div>
    </div>

    <!-- Solde -->
    <div class="summary d-flex justify-content-around bg-light p-3 rounded mb-4 text-center">
      <p class="text-success mb-0"><strong>Revenus :</strong> +{{ totalRevenus.toLocaleString('fr-FR') }} Ar</p>
      <p class="text-danger mb-0"><strong>Dépenses :</strong> -{{ totalDepenses.toLocaleString('fr-FR') }} Ar</p>
      <p class="mb-0"><strong>Solde :</strong> {{ solde.toLocaleString('fr-FR') }} Ar</p>
    </div>

    <!-- Liste -->
    <ul class="transaction-items list-unstyled">
      <li
        v-for="tx in filteredTransactions"
        :key="tx.id"
        class="transaction-item d-flex justify-content-between align-items-center p-3 mb-3 rounded shadow-sm"
        :class="{'bg-success bg-opacity-10': tx.type === 'revenu', 'bg-danger bg-opacity-10': tx.type === 'dépense'}"
      >
        <div class="details flex-grow-1">
          <strong class="d-block mb-1">{{ tx.description }}</strong>
          <span class="amount fw-bold">{{ tx.amount.toLocaleString('fr-FR') }} Ar</span>
          <small class="text-muted d-block mt-1">
            📅 {{ formatDate(tx.date) }} — 📂 {{ tx.category }} — 🔖 {{ tx.type }}
          </small>
        </div>

        <div class="actions d-flex gap-2 ms-3">
          <button
            @click="$emit('editTransaction', tx)"
            class="btn btn-sm btn-warning"
            aria-label="Modifier transaction"
          >
            Modifier
          </button>
          <button
            @click="$emit('deleteTransaction', tx.id)"
            class="btn btn-sm btn-danger"
            aria-label="Supprimer transaction"
          >
            Supprimer
          </button>
        </div>
      </li>
      <li v-if="filteredTransactions.length === 0" class="text-center text-muted fst-italic">
        Aucune transaction trouvée.
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
  max-width: 900px;
  margin: 0 auto;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #343a40;
}

.filters label {
  font-weight: 600;
  color: #495057;
}

.summary p {
  font-size: 1.1rem;
}

.transaction-item {
  border: 1px solid #ddd;
  transition: box-shadow 0.3s ease;
}

.transaction-item:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
}

.details .amount {
  color: #212529;
}

.actions button {
  min-width: 80px;
  transition: background-color 0.3s ease;
}

.actions button:hover {
  filter: brightness(0.9);
}
</style>
