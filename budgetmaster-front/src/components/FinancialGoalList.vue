<template>
  <div>
    <h2 class="fw-bold fs-4 mb-4">📌 Mes objectifs</h2>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col" v-for="goal in goals" :key="goal.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title fw-semibold">{{ goal.name }}</h5>
            <p class="card-text">
              <strong>Objectif :</strong> {{ goal.target_amount.toLocaleString() }} Ar <br />
              <strong>Date limite :</strong> {{ formatDate(goal.deadline) || 'Non définie' }} <br />
              <strong>Catégorie :</strong> {{ goal.category || 'Aucune' }}
            </p>

            <div class="mb-2">
              <progress
                :value="goal.saved_amount"
                :max="goal.target_amount"
                class="w-100"
                style="height: 12px;"
              ></progress>
              <small>{{ percentSaved(goal) }}% atteint</small>
            </div>

            <div class="input-group mb-2">
              <input
                type="number"
                v-model.number="goal.newAmount"
                class="form-control"
                placeholder="Montant économisé"
                min="1"
              />
              <button class="btn btn-success" @click="updateProgress(goal)">
                Ajouter
              </button>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button class="btn btn-outline-primary btn-sm" @click="$emit('editGoal', goal)">
                Modifier
              </button>
              <button class="btn btn-outline-danger btn-sm" @click="openDeleteModal(goal)">
                Supprimer
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 🔔 MODALE DE CONFIRMATION -->
    <div
      class="modal fade"
      ref="deleteModal"
      tabindex="-1"
      aria-labelledby="deleteModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            Êtes-vous sûr de vouloir supprimer l'objectif <strong>"{{ goalToDelete?.name }}"</strong> ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="confirmDelete">
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';  

export default {
  props: {
    goals: Array,
  },
  data() {
    return {
      goalToDelete: null,
    };
  },
  methods: {
    formatDate(dateStr) {
      return dateStr ? new Date(dateStr).toLocaleDateString() : '';
    },
    percentSaved(goal) {
      if (!goal.target_amount) return 0;
      return Math.min(((goal.saved_amount / goal.target_amount) * 100).toFixed(1), 100);
    },
    async updateProgress(goal) {
      if (!goal.newAmount || goal.newAmount <= 0) {
        alert('Veuillez entrer un montant valide');
        return;
      }

      const tentative = goal.saved_amount + goal.newAmount;

      if (tentative > goal.target_amount) {
        alert("Vous ne pouvez pas dépasser l'objectif total !");
        return;
      }

      try {
        await this.$emit('updateGoalAmount', goal.id, tentative);
        goal.newAmount = null;
      } catch (err) {
        console.error("Erreur lors de la mise à jour :", err);
        alert("Une erreur est survenue.");
      }
    },
    openDeleteModal(goal) {
      this.goalToDelete = goal;
      const modal = new bootstrap.Modal(this.$refs.deleteModal);
      modal.show();
    },
    confirmDelete() {
      if (this.goalToDelete) {
        this.$emit('deleteGoal', this.goalToDelete.id);
        this.goalToDelete = null;
      }
    },
  },
};
</script>
