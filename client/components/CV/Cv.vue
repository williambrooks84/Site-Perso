<template>
  <div class="w-full flex justify-center">
    <img :src="cvImageUrl" alt="cv" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const cvImageUrl = ref('')

onMounted(async () => {
  try {
    const res = await fetch('https://api.willbrooks.fr/wp-json/wp/v2/cv?status=publish&_fields=cv_image')
    const data = await res.json()
    if (Array.isArray(data) && data.length > 0 && data[0].cv_image) {
      cvImageUrl.value = data[0].cv_image
    }
  } catch (e) {
    // fallback to asset image
  }
})
</script>

<style scoped>

</style>