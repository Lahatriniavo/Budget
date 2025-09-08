<template>
  <div class="btn-group">
    <button
      v-for="option in themes"
      :key="option"
      class="btn"
      :class="{
        'btn-outline-primary': modelValue !== option,
        'btn-primary': modelValue === option
      }"
      @click="$emit('update:modelValue', option)"
    >
      {{ option === 'light' ? 'Clair ☀️' : 'Sombre 🌙' }}
    </button>
  </div>
</template>

<script>
export default {
  props: ['modelValue'],
  data() {
    return {
      themes: ['light', 'dark'],
    };
  }
};
</script>
