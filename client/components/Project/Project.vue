<template>
  <div class="row">
    <div class="col-md-4 mb-4" v-for="projet in projets" :key="projet.id">
      <div class="card" style="width: 18rem;">
        <!-- Image -->
        <img
          v-if="projet._embedded && projet._embedded['wp:featuredmedia']"
          :src="projet._embedded['wp:featuredmedia'][0].source_url"
          class="card-img-top"
          :alt="projet.title.rendered"
        />

        <!-- Content -->
        <div class="card-body">
          <h5 class="card-title" v-html="projet.title.rendered"></h5>
          <p class="card-text">
            {{ projet.custom_fields.short_description || 'Aucune description disponible.' }}
          </p>
          <NuxtLink v-if="projet.custom_fields.custom_link" :to="projet.custom_fields.custom_link" class="btn btn-primary">
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