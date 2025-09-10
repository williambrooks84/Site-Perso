<template>
    <Hero />
    <ToolsShowcase />
    <MediaShowcase />

</template>

<script setup>
import Hero from '~/components/Hero/Hero.vue'
import ToolsShowcase from '~/components/ToolsShowcase/ToolsShowcase.vue';
import Contact from '~/components/Contact/Contact.vue';

useHead({
    title: 'William Brooks - Développeur Web sur Limoges',
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
        },
        {
            property: 'og:image',
            content: '/assets/img/will.jpg'
        },
        {
            name: 'google-site-verification',
            content: 'VH8JnsJJdanfkUNguZ-wIpIhVHOjm8oyRYTR0ALmMH4'
        }
    ]
})

</script>

<style scoped></style>