<template>
  <div class="flex flex-col gap-20">
    <!-- Categories -->
    <section v-for="group in groupedProjects" :key="group.key" class="flex flex-col gap-8">
      <h2>
        {{ group.title }}
      </h2>

      <div class="flex flex-col justify-center gap-8">
        <div class="mb-4" v-for="projet in group.items" :key="projet.id">
          <div class="w-full flex flex-col items-center xl:flex-row gap-4 md:gap-8">
            <!-- Image -->
            <img
              v-if="projet._embedded && projet._embedded['wp:featuredmedia']"
              :src="projet._embedded['wp:featuredmedia'][0].source_url"
              class="w-full h-auto md:w-96 md:h-64 object-cover"
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
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'

const projets = ref([])

const getCategoryInfo = (projet) => {
  const categories = projet.projet_categories
  if (!categories || categories.length === 0) return null
  
  const term = categories[0]
  return { name: term.name, order: term.order || 0 }
}

const groupedProjects = computed(() => {
  const groups = new Map()
  const uncategorized = []

  for (const projet of projets.value) {
    const info = getCategoryInfo(projet)
    if (!info) {
      uncategorized.push(projet)
      continue
    }

    if (!groups.has(info.name)) groups.set(info.name, { items: [], order: info.order })
    groups.get(info.name).items.push(projet)
  }

  const result = Array.from(groups.entries()).map(([title, { items, order }]) => ({
    key: title,
    title,
    items,
    order
  })).sort((a, b) => a.order - b.order)

  if (uncategorized.length) {
    result.push({
      key: 'uncategorized',
      title: 'Sans catégorie',
      items: uncategorized,
      order: Infinity
    })
  }

  return result
})

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