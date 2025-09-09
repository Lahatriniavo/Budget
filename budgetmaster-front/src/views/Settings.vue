<template>
  <div class="container mt-4">
    <h2 class="mb-4">⚙️ Paramètres</h2>

    <div class="mb-4">
      <h5>Apparence</h5>
      <ThemeSelector v-model="settings.theme" />
    </div>

    <div class="mb-4">
      <h5>Format</h5>
      <label class="form-label">Devise</label>
      <select v-model="settings.currency" class="form-select w-auto">
        <option value="MGA">Ariary (MGA)</option>
        <option value="USD">Dollar (USD)</option>
        <option value="EUR">Euro (EUR)</option>
      </select>
    </div>

    <div class="mb-4">
      <h5>Affichage</h5>
      <div class="form-check">
        <input
          class="form-check-input"
          type="checkbox"
          v-model="settings.hideCompletedGoals"
          id="hideCompleted"
        />
        <label class="form-check-label" for="hideCompleted">
          Masquer les objectifs atteints à 100%
        </label>
      </div>
    </div>

    <button class="btn btn-primary" @click="saveSettings">💾 Enregistrer</button>
  </div>
</template>

<script>
import ThemeSelector from '../components/ThemeSelector.vue';

export default {
  components: { ThemeSelector },
  data() {
    return {
      settings: {
        theme: 'light',
        currency: 'MGA',
        hideCompletedGoals: false,
      }
    };
  },
  mounted() {
    const saved = localStorage.getItem('userSettings');
    if (saved) this.settings = JSON.parse(saved);
  },
  watch: {
    'settings.theme'(newTheme) {
      localStorage.setItem('userSettings', JSON.stringify(this.settings));
      this.$emit('themeChanged', newTheme);
    }
  },
  methods: {
    saveSettings() {
      localStorage.setItem('userSettings', JSON.stringify(this.settings));
      alert('Paramètres enregistrés !');
    }
  }
};
</script>
