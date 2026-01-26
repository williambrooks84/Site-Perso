<template>
    <div class="flex flex-col items-center gap-10">
        <ContactInfos />
    </div>
</template>

<script setup>
import ContactInfos from '../components/Contact/ContactInfos.vue';

useHead({
  title: 'William Brooks - Contact',
  meta: [
    {
      name: 'description',
      content: 'Contactez William Brooks, développeur web étudiant à Limoges, pour toute demande ou collaboration.'
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