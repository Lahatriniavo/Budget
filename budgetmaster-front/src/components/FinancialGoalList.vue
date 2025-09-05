<template>
  <div>
    <h2 style="font-size: 20px; margin-bottom: 1rem;">Mes objectifs financiers</h2>

    <ul>
      <li v-for="goal in goals" :key="goal.id" style="margin-bottom: 15px;">
        <strong>{{ goal.name }}</strong> — Objectif : {{ goal.target_amount }} Ar
        <br />
        <small>Deadline : {{ formatDate(goal.deadline) || 'Non définie' }} — Catégorie : {{ goal.category || 'Aucune' }}</small>
        <br />
        <progress :value="goal.saved_amount" :max="goal.target_amount" style="width: 200px; height: 15px;"></progress>
        <div style="margin-top: 0.5rem;">
            <input
                type="number"
                min="1"
                v-model.number="goal.newAmount"
                placeholder="Montant économisé"
                style="width: 150px; margin-right: 5px;"
            />
            <button @click="updateProgress(goal)">Ajouter</button>
            </div>
        <span> {{ percentSaved(goal) }}% atteint</span>
        <br />
        <button @click="$emit('editGoal', goal)" style="margin-right: 5px;">Modifier</button>
        <button @click="$emit('deleteGoal', goal.id)" style="color: red;">Supprimer</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    goals: Array,
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

        alert("Progression mise à jour avec succès !");
    } catch (err) {
        console.error("Erreur lors de la mise à jour :", err);
        alert("Une erreur est survenue.");
    }
    }

  },
};
</script>
