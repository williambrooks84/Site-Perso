<template>
    <div class="flex flex-col items-center justify-center min-h-[60vh] gap-20 pb-20">
        <Project />
        <div class="flex flex-col items-center justify-center gap-7">
            <p class="body-text">Envie d'aller plus loin dans mes réalisations ?</p>
            <a href="https://sites.google.com/view/portfoliobrooksw" class="btn-secondary">
                Consultez mon portfolio de compétences
            </a>
        </div>
    </div>
</template>

<script setup>
import Project from '@/components/Project/Project.vue'

useHead({
  title: 'William Brooks - Portfolio',
  meta: [
    {
      name: 'description',
      content: 'Retrouvez ici tous les projets réalisés par William Brooks, développeur web étudiant à Limoges.'
    },
    {
      name: 'keywords',
      content: 'développeur web, développeur front-end, étudiant, Limoges, informatique'
    },
    {
      property: 'og:title',
      content: 'William Brooks - Développeur Web sur Limoges'
    },
    {
      property: 'og:description',
      content: 'William Brooks est un développeur web étudiant à Limoges, intéressé par l\'informatique depuis un jeune âge.'
    },
    {
      property: 'og:url',
      content: 'https://willbrooks.fr'
    },
    {
      property: 'og:type',
      content: 'website'
    }
  ]
})
</script>

<style scoped>
</style>