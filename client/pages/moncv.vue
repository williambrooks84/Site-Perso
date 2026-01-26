<template>
    <div class="w-full flex flex-col justify-center items-center gap-10">
        <DownloadCvButton :href="buttonProps[0].href" :download="buttonProps[0].download" :label="buttonProps[0].label" />
        <Cv />
    </div>
</template>

<script setup>
import Cv from '~/components/CV/Cv.vue'
import DownloadCvButton from '~/components/CV/DownloadCvButton.vue'

useHead({
  title: 'William Brooks - CV',
  meta: [
    {
      name: 'description',
      content: 'Retrouvez le CV de William Brooks, développeur web étudiant à Limoges.'
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

const buttonProps = [
    {
        href: '/assets/pdf/cv.pdf',
        download: 'William-Brooks-CV.pdf',
        label: 'Télécharger mon CV'
    }
]
</script>

<style scoped>

</style>