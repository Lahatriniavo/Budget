<template>
  <div class="forecast-list container bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4 fw-bold fs-4">📊 Mes Prévisions</h2>

    <!-- Filtres -->
    <div class="row g-3 align-items-end mb-4">
      <div class="col-md-4">
        <label class="form-label fw-semibold">Mois</label>
        <input type="month" v-model="selectedMonth" class="form-control" />
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold">Type</label>
        <select v-model="selectedType" class="form-select">
          <option value="">Tous</option>
          <option value="revenu">Revenu</option>
          <option value="dépense">Dépense</option>
        </select>
      </div>
    </div>

    <!-- Total -->
    <div class="alert alert-info fw-bold">
      Total : {{ filteredTotal.toLocaleString('fr-FR') }} Ar
    </div>

    <!-- Liste des prévisions -->
    <ul class="list-group">
      <li
        v-for="forecast in filteredForecasts"
        :key="forecast.id"
        class="list-group-item d-flex justify-content-between align-items-start"
      >
        <div class="ms-2 me-auto">
          <div class="fw-bold">{{ forecast.category }}</div>
          <span class="text-muted">
            📅 {{ formatMonth(forecast.month) }} — 📂 {{ forecast.type }}
          </span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="fw-semibold text-primary">{{ forecast.amount.toLocaleString('fr-FR') }} Ar</span>
          <button class="btn btn-sm btn-warning" @click="$emit('editForecast', forecast)">Modifier</button>
          <button class="btn btn-sm btn-danger" @click="openDeleteModal(forecast)">Supprimer</button>
        </div>
      </li>
    </ul>

    <p v-if="filteredForecasts.length === 0" class="text-center mt-4 text-muted fst-italic">
      Aucune prévision trouvée pour les filtres sélectionnés.
    </p>
  </div>
  <!-- Modal de confirmation de suppression -->
<div
  class="modal fade"
  id="deleteModal"
  tabindex="-1"
  aria-labelledby="deleteModalLabel"
  aria-hidden="true"
  ref="deleteModal"
>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir supprimer la prévision de <strong>{{ transactionToDelete?.category }}</strong> pour <strong>{{ formatMonth(transactionToDelete?.month) }}</strong> ?
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
    forecasts: Array,
  },
  data() {
    return {
      selectedMonth: '',
      selectedType: '',
      transactionToDelete: null,
    };
  },
  computed: {
    filteredForecasts() {
      return this.forecasts.filter((forecast) => {
        const matchMonth = this.selectedMonth
          ? forecast.month === this.selectedMonth
          : true;

        const matchType = this.selectedType
          ? forecast.type === this.selectedType
          : true;

        return matchMonth && matchType;
      });
    },
    filteredTotal() {
      return this.filteredForecasts.reduce((sum, f) => sum + Number(f.amount), 0);
    },
  },
  methods: {
    formatMonth(monthStr) {
      if (!monthStr) return '';
      const [year, month] = monthStr.split('-');
      return `${month}/${year}`;
    },
    openDeleteModal(forecast) {
      this.transactionToDelete = forecast;
      const modal = new bootstrap.Modal(this.$refs.deleteModal);
      modal.show();
    },
    confirmDelete() {
      this.$emit('deleteForecast', this.transactionToDelete.id);
      const modal = bootstrap.Modal.getInstance(this.$refs.deleteModal);
      modal.hide();
    },
  },
};
</script>

<style scoped>
.forecast-list {
  max-width: 900px;
  margin: 0 auto;
}
</style>
