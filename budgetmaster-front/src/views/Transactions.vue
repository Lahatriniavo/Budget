<template>
  <div>
    <AppHeader />

    <div class="container">
      <TransactionForm
        :transactionToEdit="transactionToEdit"
        @transactionSaved="fetchTransactions"
        @resetEdit="transactionToEdit = null"
      />

      <TransactionList
        :transactions="transactions"
        @editTransaction="transactionToEdit = $event"
        @deleteTransaction="deleteTransaction"
      />
    </div>
  </div>
</template>

<script>
import TransactionForm from '../components/TransactionForm.vue';
import TransactionList from '../components/TransactionList.vue';
import AppHeader from '../components/AppHeader.vue'; // ou ajuste selon ton chemin
import api from '../services/api';

export default {
  components: {
    TransactionForm,
    TransactionList,
    AppHeader,
  },
  data() {
    return {
      transactions: [],
      transactionToEdit: null,
    };
  },
  methods: {
    async fetchTransactions() {
      try {
        const response = await api.get('/transactions');
        this.transactions = response.data;
      } catch (error) {
        console.error("Erreur lors du chargement des transactions :", error);
      }
    },
    async deleteTransaction(id) {
      if (confirm('Voulez-vous vraiment supprimer cette transaction ?')) {
        try {
          await api.delete(`/transactions/${id}`);
          this.fetchTransactions();
        } catch (error) {
          console.error("Erreur lors de la suppression :", error);
        }
      }
    },
  },
  created() {
    this.fetchTransactions();
  },
};
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 1rem;
}
</style>
