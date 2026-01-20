<template>
  <div
    ref="elementRef"
    :class="[
      'flex flex-col items-center gap-2 transition-transform duration-300 hover:scale-150',
      isVisible ? 'translate-x-0 opacity-100' : '-translate-x-10 opacity-0'
    ]"
  >
    <client-only>
      <img :src="displayIcon" alt="" class="w-10 h-10" />
    </client-only>
    <p class="text-secondary text-sm font-semibold text-center">{{ label }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useInView } from '@/composables/useInView'
import { useTheme } from '~/composables/useTheme.js'

const props = defineProps({
  icon: { type: String, required: true },
  iconDark: { type: String, required: false },
  label: { type: String, required: true }
})

const { isDark } = useTheme()
const { elementRef, isVisible } = useInView(0.1)

const displayIcon = computed(() => {
  return isDark.value && props.iconDark ? props.iconDark : props.icon
})
</script>

<style scoped></style>