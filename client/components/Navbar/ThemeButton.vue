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
import { ref, onMounted } from 'vue'

const isDark = ref(false)

const toggleTheme = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  } else {
    isDark.value = false
    document.documentElement.classList.remove('dark')
  }
})
</script>