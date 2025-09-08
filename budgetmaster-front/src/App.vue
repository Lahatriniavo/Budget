<template>
  <div :class="themeClass">
    <router-view />
  </div>
</template>

<script>
export default {
  data() {
    return {
      themeClass: 'theme-light',
    };
  },
  created() {
    const saved = localStorage.getItem('userSettings');
    if (saved) {
      const parsed = JSON.parse(saved);
      this.themeClass = parsed.theme === 'dark' ? 'theme-dark' : 'theme-light';
    }
  },
  watch: {
    '$route': {
      handler() {
        const saved = localStorage.getItem('userSettings');
        if (saved) {
          const parsed = JSON.parse(saved);
          this.themeClass = parsed.theme === 'dark' ? 'theme-dark' : 'theme-light';
        }
      },
      immediate: true,
    }
  }
};
</script>

<style>
/* Thème clair (par défaut) */
.theme-light {
  background-color: #f9f9f9;
  color: #222;
}

/* Thème sombre */
.theme-dark {
  background-color: #121212;
  color: #e0e0e0;
}

.theme-dark input,
.theme-dark select,
.theme-dark textarea {
  background-color: #1e1e1e;
  color: white;
  border-color: #444;
}

.theme-dark .btn {
  background-color: #333;
  color: white;
  border-color: #555;
}
</style>
