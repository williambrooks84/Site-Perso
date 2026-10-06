<template>
  <Loading v-if="loading" />

  <section
    v-else
    id="portfolio"
    class="flex flex-col items-center pb-20"
  >

    <section
      id="projects"
      class="flex w-full flex-col gap-3 md:gap-5 px-4"
    >
      <h2 class="text-center mt-1">
        Mes projets Web
      </h2>

      <ProjectsCarousel
        :projects="projects"
        :categories="categories"
        :api-base-url="apiBaseUrl"
      />
    </section>

    <section
      id="designs"
      class="mt-10 flex w-full max-w-6xl flex-col gap-5 px-4 pb-20"
    >
      <h2 class="text-center">
        Mes designs
      </h2>

      <DesignGrid
        :designs="designs"
        :api-base-url="apiBaseUrl"
      />
    </section>
    <PortfolioCompetences />
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import ProjectsCarousel from '~/components/Portfolio/ProjectsCarousel.vue'
import DesignGrid from '~/components/Portfolio/DesignGrid.vue'
import PortfolioCompetences from '~/components/CallToAction/PortfolioCompetences.vue'
import Loading from '~/components/Loading/Loading.vue'

definePageMeta({
  layout: 'portfolio',
})

const runtimeConfig = useRuntimeConfig()

const apiBaseUrl =
  runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const projects = ref([])
const categories = ref([])
const designs = ref([])
const loading = ref(true)

const loadProjects = async () => {
  try {
    const response = await fetch(
      `${apiBaseUrl}/api/projects`,
      {
        headers: {
          Accept: 'application/ld+json',
        },
      }
    )

    if (!response.ok) {
      throw new Error('Impossible de charger les projets')
    }

    const data = await response.json()

    projects.value = data.member || data
  } catch (error) {
    console.error('Erreur chargement projets:', error)
  }
}

const loadCategories = async () => {
  try {
    const response = await fetch(
      `${apiBaseUrl}/api/categories`,
      {
        headers: {
          Accept: 'application/ld+json',
        },
      }
    )

    if (!response.ok) {
      throw new Error('Impossible de charger les catégories')
    }

    const data = await response.json()

    categories.value = data.member || data
  } catch (error) {
    console.error('Erreur chargement catégories:', error)
  }
}

const loadDesigns = async () => {
  try {
    const response = await fetch(
      `${apiBaseUrl}/api/designs`,
      {
        headers: {
          Accept: 'application/ld+json',
        },
      }
    )

    if (!response.ok) {
      throw new Error('Impossible de charger les designs')
    }

    const data = await response.json()

    designs.value = data.member || data
  } catch (error) {
    console.error('Erreur chargement designs:', error)
  }
}

onMounted(async () => {
  try {
    await Promise.all([
      loadProjects(),
      loadCategories(),
      loadDesigns(),
    ])
  } finally {
    loading.value = false
  }
})

useHead({
  title: 'William Brooks - Réalisations',
  meta: [
    {
      name: 'description',
      content:
        'Réalisations de William Brooks, développeur web sur Limoges.',
    },
    {
      name: 'keywords',
      content: 'développeur web, développeur front-end, développeur back-end, développeur full stack, Limoges, informatique'
    },
    {
      property: 'og:title',
      content:
        'William Brooks - Développeur Web sur Limoges',
    },
    {
      property: 'og:description',
      content:
        "William Brooks est un développeur web étudiant à Limoges, intéressé par l'informatique depuis un jeune âge.",
    },
    {
      property: 'og:url',
      content: 'https://willbrooks.fr',
    },
    {
      property: 'og:type',
      content: 'website',
    },
  ],
})
</script>