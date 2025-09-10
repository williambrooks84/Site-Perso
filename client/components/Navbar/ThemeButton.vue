<template>
  <button
    class="p-2 rounded text-light transition hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover"
    @click="toggleTheme"
    aria-label="Toggle theme"
  >
    <i :class="(isDark ? 'bi bi-moon-fill' : 'bi bi-sun-fill') + ' text-xl'"></i>
  </button>
</template>

<script setup>
import { useTheme } from '~/composables/useTheme.js'
const { isDark } = useTheme()

const toggleTheme = () => {
  isDark.value = !isDark.value
}
</script>
