<template>
    <div
      ref="elementRef"
      :class="[
        'flex flex-col items-center gap-2 transition-all duration-700',
        isVisible ? 'translate-x-0 opacity-100' : '-translate-x-10 opacity-0'
      ]"
    >
      <img :src="icon" alt="" class="w-10 h-10" />
      <p class="text-secondary text-sm font-semibold text-center">{{ label }}</p>
    </div>
  </template>

<script setup>
import { useInView } from '@/composables/useInView'

const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    }
})

const { elementRef, isVisible } = useInView(0.1)
</script>

<style scoped>

</style>