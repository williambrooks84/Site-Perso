<template>
  <div class="flex flex-col justify-center gap-8">
    <div class=" mb-4" v-for="projet in projets" :key="projet.id">
      <div class="w-full flex flex-col md:flex-row gap-4 md:gap-8">
        <!-- Image -->
        <img
          v-if="projet._embedded && projet._embedded['wp:featuredmedia']"
          :src="projet._embedded['wp:featuredmedia'][0].source_url"
          class="w-full h-auto md:w-96"
          :alt="projet.title.rendered"
        />

        <!-- Content -->
        <div class="flex flex-col justify-between items-center gap-4 text-center w-full">
          <h5 class="text-2xl md:text-4xl" v-html="projet.title.rendered"></h5>
          <p class="text-sm md:text-lg text-left">
            {{ projet.custom_fields.description || 'Aucune description disponible.' }}
          </p>
          <div class="flex flex-col md:flex-row gap-4">
            <a
              v-if="projet.custom_fields.project_link"
              :href="projet.custom_fields.project_link"
              class="btn-primary md:w-fit"
              target="_blank"
              rel="noopener"
            >
              Voir le projet
            </a>
            <a
              v-if="projet.custom_fields.site_link"
              :href="projet.custom_fields.site_link"
              class="btn-primary md:w-fit"
              target="_blank"
              rel="noopener"
            >
              Voir le site hébergé
            </a>
          </div>
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