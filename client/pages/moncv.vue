<template>
  <section
    id="Cv"
    class="w-full flex flex-col justify-center items-center gap-6"
  >
    <Cv @loaded="onCvLoaded" />

    <DownloadCvButton
      v-if="!loading"
      :href="buttonProps[0].href"
      :download="buttonProps[0].download"
      :label="buttonProps[0].label"
    />
  </section>

  <Loading v-if="loading" />
</template>

<script setup>
import { ref } from 'vue'

import Cv from '~/components/CV/Cv.vue'
import DownloadCvButton from '~/components/CV/DownloadCvButton.vue'

useHead({
  title: 'William Brooks - CV',
  meta: [
    {
      name: 'description',
      content:
        'CV de William Brooks, développeur web sur Limoges.',
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

const loading = ref(true)

const onCvLoaded = () => {
  console.log('8 - EVENT LOADED REÇU PAR MONCV')
  loading.value = false
}

const buttonProps = [
  {
    href: '/assets/pdf/cv.pdf',
    download: 'William-Brooks-CV.pdf',
    label: 'Télécharger mon CV'
  }
]
</script>