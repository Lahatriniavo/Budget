// src/main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

createApp(App)
  .use(router) // Très important !!
  .mount('#app');
