<template>
  <button
    v-ripple
    :class="[ 
      'relative overflow-hidden flex items-center uppercase space-x-3 box-border cursor-pointer',
      padding,
      bgColor,
      textColor,
      textSize,
      fontWeight, 
      rounded,
    ]"
  >
    <img v-if="icon" :src="icon" alt="icon" class="w-4 h-4" />
    <span>{{ label }}</span>
  </button>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    default: null
  },
  padding: {
    type: String,
    default: 'px-4 py-2'
  },
  bgColor: {
    type: String,
    default: 'bg-secondary'
  },
  textColor: {
    type: String,
    default: 'text-white'
  },
  textSize: {
    type: String,
    default: 'text-base'
  },
  fontWeight: {
    type: String,
    default: 'font-semibold'
  },
  rounded: {
    type: String,
    default: 'rounded-lg'
  }
})
</script>

<style scoped>

</style>