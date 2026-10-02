<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup>
import { computed } from 'vue'

const theme = useCookie('theme', {
  default: () => null
})

useHead({
  htmlAttrs: {
    class: computed(() => {
      return theme.value === 'dark'
        ? 'dark'
        : undefined
    })
  }
})
</script>