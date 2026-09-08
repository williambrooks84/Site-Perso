<template>
  <main class="flex flex-col items-center justify-center gap-20 pb-20 pt-0 md:pt-12">
    <section class="w-full max-w-6xl px-4">
      <ProjectsCarousel
        :projects="projects"
        :categories="categories"
        :api-base-url="apiBaseUrl"
      />
    </section>

    <section class="flex flex-col items-center justify-center gap-7 px-4 text-center">
      <p class="body-text">
        Envie d'aller plus loin dans mes réalisations ?
      </p>

      <a
        href="https://sites.google.com/view/portfoliobrooksw"
        target="_blank"
        rel="noopener noreferrer"
        class="btn-secondary"
      >
        Consultez mon portfolio de compétences
      </a>
    </section>
  </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import ProjectsCarousel from '~/components/Portfolio/ProjectsCarousel.vue'

definePageMeta({
    layout: 'portfolio',
})

const runtimeConfig = useRuntimeConfig()

const apiBaseUrl =
  runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const projects = ref([])
const categories = ref([])

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

onMounted(async () => {
  await Promise.all([
    loadProjects(),
    loadCategories(),
  ])
})

useHead({
  title: 'William Brooks - Portfolio',
  meta: [
    {
      name: 'description',
      content:
        'Retrouvez ici tous les projets réalisés par William Brooks, développeur web étudiant à Limoges.',
    },
    {
      name: 'keywords',
      content:
        'développeur web, développeur front-end, étudiant, Limoges, informatique',
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