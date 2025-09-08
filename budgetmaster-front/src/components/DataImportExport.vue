<template>
  <div style="margin-top: 2rem;">
    <h2>Import / Export des Transactions</h2>

    <!-- Import -->
    <input type="file" @change="handleFile" accept=".csv, .xlsx" />
    <button @click="importFile" :disabled="!selectedFile">Importer</button>

    <!-- Export -->
    <button @click="exportFile">Exporter</button>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  data() {
    return {
      selectedFile: null,
    };
  },
  methods: {
    handleFile(event) {
      this.selectedFile = event.target.files[0];
    },
    async importFile() {
      const formData = new FormData();
      formData.append('file', this.selectedFile);

      try {
        await api.post('/import', formData);
        alert('Importation réussie !');
        this.selectedFile = null;
      } catch (err) {
        console.error('Erreur d\'importation', err);
        alert('Erreur lors de l\'importation');
      }
    },
    async exportFile() {
      try {
        const response = await api.get('/export', {
          responseType: 'blob',
        });

        const blob = new Blob([response.data]);
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'transactions.xlsx';
        link.click();
      } catch (err) {
        console.error('Erreur d\'exportation', err);
        alert('Erreur lors de l\'exportation');
      }
    }
  }
};
</script>
