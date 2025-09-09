// ✅ Correction dans src/main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap';

// ✅ Créer l'instance de l'application
const app = createApp(App);

// ✅ Ajouter des propriétés globales (comme $formatCurrency)
app.config.globalProperties.$formatCurrency = function (amount) {
  const saved = localStorage.getItem('userSettings');
  const currency = saved ? JSON.parse(saved).currency || 'MGA' : 'MGA';

  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency,
    minimumFractionDigits: 0,
  }).format(amount);
};

// ✅ Utiliser les plugins et monter l'app
app.use(router).mount('#app');
