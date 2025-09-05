<template>
  <div class="row">
    <div class="col-md-4 mb-4" v-for="projet in projets" :key="projet.id">
      <div class="w-full flex flex-col md:flex-row gap-4 md:gap-8">
        <!-- Image -->
        <img
          v-if="projet._embedded && projet._embedded['wp:featuredmedia']"
          :src="projet._embedded['wp:featuredmedia'][0].source_url"
          class="w-full h-auto md:w-96"
          :alt="projet.title.rendered"
        />

        <!-- Content -->
        <div class="flex flex-col justify-between md:items-center gap-4">
          <h5 class="text-center text-2xl md:text-4xl" v-html="projet.title.rendered"></h5>
          <p class="text-sm md:text-lg">
            {{ projet.custom_fields.short_description || 'Aucune description disponible.' }}
          </p>
          <NuxtLink v-if="projet.custom_fields.custom_link" :to="projet.custom_fields.custom_link" class="btn-primary md:w-fit">
            Voir le projet
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const projets = ref([])

onMounted(async () => {
  try {
    const res = await fetch('https://api.willbrooks.fr/wp-json/wp/v2/projet?_embed')
    projets.value = await res.json()
  } catch (err) {
    console.error('Erreur API:', err)
  }
})
</script>

<style scoped>

</style>