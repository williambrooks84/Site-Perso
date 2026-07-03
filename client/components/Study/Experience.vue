<template>

    <div class="space-y-8 mt-15">
        <h2>Mes expériences</h2>
        <StudyPoint
            v-for="(experience, index) in experiences"
            :key="index"
            :name="experience.name"
            :year="experience.year"
            :type="experience.type"
            :content="experience.content"
            :image="experience.image"
            :imageDark="experience.imageDark"
        />
        <div class="flex flex-col items-center justify-center pt-3 gap-3">
            <p class="body-text">Vous souhaitez voir mes compétences mises en application ?</p>
            <a href="/portfolio"
                class="px-6 py-3 bg-primary text-light rounded font-semibold uppercase text-lg transition hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover">
                Consultez mes projets
            </a>
        </div>
    </div>
</template>

<script setup>
import StudyPoint from './StudyPoint.vue'

const experiences = [
    {
        name: "Miggle One",
        year: "Février 2026 à avril 2026",
        type: "Stage en entreprise",
        content: "Pour valider ma troisième année de BUT MMI, j'ai fait un stage en développement web full stack de 12 semaines chez Miggle One. Pendant ce stage, j'ai développé des nouvelles fonctionnalités sur des applications web utilisant un back-end en Google Cloud avec Firebase, des technologies que je n'avais jamais utilisées avant. Pour la partie front-end, j'ai continué à utiliser React, une technologie que je connaissais déjà bien, avec TailwindCSS pour la stylisation.",
    },
    {
        name: "Etienne Leriche",
        year: "Avril 2025 à juin 2025",
        type: "Stage en entreprise",
        content: "Pour valider ma deuxième année de BUT MMI, j'ai réalisé un stage en développement web front-end de 8 semaines chez Etienne Leriche, où j'ai appris à utiliser le framework Nuxt avec l'utilisation d'une API Wordpress comme source de données. Pour la stylisation, j'ai utilisé TailwindCSS et Bootstrap, une technologie que je continue d'apprendre à maitriser.",
    }
]
</script>

<style scoped></style>