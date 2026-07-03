<template>
  <div>
    <div class="flex flex-col text-justify justify-center items-center gap-8 lg:gap-10">
      <img src="/assets/img/will.jpg" class="w-48 h-auto rounded-xl" alt="">
      <p class="body-text">Je suis William Brooks. J'ai 21 ans et je suis un développeur web junior full-stack. Intéressé par l'informatique depuis un jeune âge, j'ai décidé de faire des études dans le domaine du développement web afin d'approfondir mes connaissances dessus et d'en faire mon métier.</p>
      <p class="body-text">En dehors de ma formation, je suis passionné des transports en commun (surtout les bus
        et les trains) et je fais de la photographie dessus, en plus des paysages. Je suis contributeur sur
        l'association en ligne <a class="body-link" href="https://tc-infos.fr" target="_blank"
          rel="noopener noreferrer">TC Infos</a>, un site qui permet de référencer tous les transports en commun de France, et je publie des photos assez régulièrement sur les réseaux sociaux.</p>
    </div>
    <Study />
    <Experience />
    <div class="flex flex-col gap-8 mt-10">
      <h2>Envie de savoir plus sur moi ? Venez consulter mes réseaux sociaux :</h2>
      <MediaShowcase />
    </div>
  </div>
</template>

<script setup>
import MediaShowcase from '~/components/Media/MediaShowcase.vue';
import Study from '~/components/Study/Study.vue';
import Experience from '~/components/Study/Experience.vue';

useHead({
  title: 'William Brooks - Qui suis-je ?',
  meta: [
    {
      name: 'description',
      content: 'William Brooks est un développeur web étudiant à Limoges, intéressé par l\'informatique depuis un jeune âge.'
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

<style scoped></style>