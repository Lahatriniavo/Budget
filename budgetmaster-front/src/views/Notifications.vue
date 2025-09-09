<template>
  <div>
    <AppHeader />
    <div class="notifications-container">
      <h1>🔔 Notifications</h1>

      <div v-if="loading">Chargement des notifications...</div>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>

      <ul v-if="notifications.length && !loading">
        <li
          v-for="notif in notifications"
          :key="notif.id"
          class="notification-item"
          :class="{ read: notif.is_read }"
        >
          <strong>{{ notif.title }}</strong>
          <p>{{ notif.message }}</p>
          <small>{{ formatDate(notif.created_at) }}</small>

          <button
            v-if="!notif.is_read"
            @click="markAsRead(notif)"
            :disabled="notif.loading"
            :aria-label="`Marquer la notification ${notif.title} comme lue`"
          >
            {{ notif.loading ? "..." : "Marquer comme lue" }}
          </button>
        </li>
      </ul>

      <p v-else-if="!loading">Aucune notification pour le moment.</p>
    </div>
  </div>
</template>

<script>
import AppHeader from '../components/AppHeader.vue';
import api from '../services/api';

export default {
  components: { AppHeader },
  data() {
    return {
      notifications: [],
      loading: false,
      errorMessage: '',
    };
  },
  async created() {
    await this.fetchNotifications();
  },
  methods: {
    async fetchNotifications() {
      this.loading = true;
      try {
        const res = await api.get('/notifications');
        this.notifications = res.data.map(n => ({ ...n, loading: false }));
        this.errorMessage = '';
      } catch (err) {
        console.error('Erreur lors de la récupération :', err);
        this.errorMessage = 'Impossible de charger les notifications.';
      } finally {
        this.loading = false;
      }
    },
    async markAsRead(notification) {
      if (notification.is_read) return;

      notification.loading = true;
      try {
        await api.post(`/notifications/${notification.id}/mark-as-read`);
        notification.is_read = true;
      } catch (err) {
        console.error('Erreur lors du marquage :', err);
      } finally {
        notification.loading = false;
      }
    },
    formatDate(dateStr) {
      if (!dateStr) return '';
      return new Date(dateStr).toLocaleString('fr-FR');
    }
  }
};
</script>

<style scoped>
.notifications-container {
  max-width: 700px;
  margin: 30px auto;
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.notification-item {
  border-bottom: 1px solid #eee;
  padding: 10px 0;
}

.notification-item:last-child {
  border-bottom: none;
}

.notification-item strong {
  display: block;
  color: #333;
}

.notification-item small {
  color: #888;
  font-size: 12px;
}

.notification-item.read {
  background-color: #f9f9f9;
  color: #999;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
