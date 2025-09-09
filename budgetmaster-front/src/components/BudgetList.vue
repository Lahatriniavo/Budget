<template>
  <div class="container py-4 budget-list">
    <h2 class="mb-4">💰 Mes budgets</h2>

    <!-- Filtres -->
    <div class="row mb-4 g-3 align-items-center">
      <div class="col-12 col-md-6 col-lg-4">
        <label for="filterMonth" class="form-label fw-semibold">Mois :</label>
        <input
          id="filterMonth"
          type="month"
          v-model="selectedMonth"
          class="form-control"
          aria-label="Filtrer par mois"
        />
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <label for="filterCategory" class="form-label fw-semibold">Catégorie :</label>
        <select
          id="filterCategory"
          v-model="selectedCategory"
          class="form-select"
          aria-label="Filtrer par catégorie"
        >
          <option value="">Toutes</option>
          <option>Logement</option>
          <option>Transport</option>
          <option>Alimentation</option>
          <option>Divertissement</option>
          <option>Autres</option>
        </select>
      </div>

      <div class="col-12 col-lg-4 d-flex align-items-center justify-content-lg-end mt-3 mt-lg-0">
        <p class="mb-0 fw-bold fs-5 text-success">
          Total : {{ formattedTotal }}
        </p>
      </div>
    </div>

    <!-- Liste filtrée -->
    <ul class="list-group shadow-sm">
      <li
        v-for="budget in filteredBudgets"
        :key="budget.id"
        class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
      >
        <div>
          <strong>{{ budget.name }}</strong> — 
          <span>{{ budget.amount.toLocaleString('fr-FR') }} Ar</span>
          <br />
          <small class="text-muted">
            📅 {{ formatDate(budget.date) }} — 📂 {{ budget.category }}
            {{ console.log(budget.date) }}
          </small>
        </div>

        <div class="btn-group mt-2 mt-md-0" role="group" aria-label="Actions budget">
          <button
            @click="$emit('editBudget', budget)"
            type="button"
            class="btn btn-sm btn-warning"
            aria-label="Modifier budget"
          >
            Modifier
          </button>
          <button
            @click="openDeleteModal(budget)"
            type="button"
            class="btn btn-sm btn-danger"
            aria-label="Supprimer budget"
          >
            Supprimer
          </button>

        </div>
      </li>

      <li v-if="filteredBudgets.length === 0" class="list-group-item text-center text-muted fst-italic">
        Aucun budget trouvé.
      </li>
    </ul>
  </div>
  <!-- Modal de confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" ref="deleteModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir supprimer le budget <strong>{{ budgetToDelete?.name }}</strong> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-danger" @click="confirmDelete">Supprimer</button>
      </div>
    </div>
  </div>
</div>

</template>


<script>
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';  
export default {
  props: {
    budgets: Array,
  },
  data() {
    return {
      selectedMonth: '',
      selectedCategory: '',
      budgetToDelete: null,
    };
  },
  computed: {
    filteredBudgets() {
      return this.budgets.filter((b) => {
        const matchesMonth = this.selectedMonth
          ? b.date && b.date.startsWith(this.selectedMonth)
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
    openDeleteModal(budget) {
      this.budgetToDelete = budget;
      const modal = new bootstrap.Modal(this.$refs.deleteModal);
      modal.show();
    },
    confirmDelete() {
      this.$emit('deleteBudget', this.budgetToDelete.id);
      const modal = bootstrap.Modal.getInstance(this.$refs.deleteModal);
      modal.hide();
      this.budgetToDelete = null;
    },
  },
};
</script>

<style scoped>
.budget-list {
  max-width: 900px;
  margin: 0 auto;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.list-group-item {
  border-radius: 0.375rem;
}
</style>
