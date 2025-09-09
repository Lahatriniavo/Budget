<template>
  <div :class="themeClass">
    <router-view @themeChanged="onThemeChanged" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      themeClass: 'theme-light',
    };
  },
  methods: {
    applyThemeFromSettings() {
      const saved = localStorage.getItem('userSettings');
      if (saved) {
        const parsed = JSON.parse(saved);
        this.themeClass = parsed.theme === 'dark' ? 'theme-dark' : 'theme-light';
      } else {
        this.themeClass = 'theme-light';
      }
    },
    onThemeChanged(newTheme) {
      this.themeClass = newTheme === 'dark' ? 'theme-dark' : 'theme-light';
    }
  },
  created() {
    this.applyThemeFromSettings();
  },
  watch: {
    '$route': {
      handler() {
        this.applyThemeFromSettings();
      },
      immediate: true,
    }
  }
};
</script>
