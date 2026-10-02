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

const isDark = useState(
  'theme-is-dark',
  () => theme.value === 'dark'
)

useHead({
  htmlAttrs: {
    lang: 'fr',
    class: computed(() => {
      return isDark.value ? 'dark' : undefined
    })
  },

  link: [
    {
      rel: 'preload',
      as: 'image',
      href: '/assets/img/logo.svg'
    },
    {
      rel: 'preload',
      as: 'image',
      href: '/assets/img/logo-dark.svg'
    }
  ]
})
</script>