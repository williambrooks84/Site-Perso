<template>
  <CvPreview @loaded="emit('loaded')" />
</template>

<script setup>
import CvPreview from './CvPreview.vue'

const emit = defineEmits(['loaded'])
</script>