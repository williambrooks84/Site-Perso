<template>
  <button
    type="button"
    class="rounded p-2 text-light transition hover:bg-hover hover:text-primary hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7"
    :aria-label="
      isDark
        ? 'Activer le thème clair'
        : 'Activer le thème sombre'
    "
    @click="toggleTheme"
  >
    <i
      :class="
        isDark
          ? 'bi bi-moon-fill text-xl'
          : 'bi bi-sun-fill text-xl'
      "
      aria-hidden="true"
    ></i>
  </button>
</template>

<script setup>
import { useTheme } from '~/composables/useTheme.js'

const {
  isDark,
  toggleTheme
} = useTheme()
</script>