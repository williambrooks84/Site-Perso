<template>

    <div class="space-y-8 mt-15">
        <h2>Mon parcours d'études</h2>
        <StudyPoint
            v-for="(study, index) in studies"
            :key="index"
            :name="study.name"
            :year="study.year"
            :content="study.content"
            :image="study.image"
            :imageDark="study.imageDark"
        />
    </div>
</template>

<script setup>
import StudyPoint from './StudyPoint.vue'

const studies = [
    {
        name: "BUT Métiers du Multimédia et de l'Internet",
        year: "2023-2026",
        content: "A l'Université de Limoges, j'ai réalisé un BUT MMI (métiers du Multimédia et de l'Internet) dans le parcours du développement web et dispositifs intéractifs. J'y ai appris les bases du développement web, notamment le HTML/CSS/JS pur mais également les frameworks comme React et Next.js. J'ai aussi acquéri des compétences en design et en gestion de projet agile. La première année de cette formation m'a aidé à trouver ma voie me donnant le choix entre la création numérique (graphisme et design) et le développement web (code). Je me suis orienté vers le développement web, car j'aime beaucoup coder et créer des sites et applications web ainsi que gérer leurs fonctionnements côté serveur. J'ai réalisé plusieurs projets en autonomie et j'ai également fait deux stages : un de deux mois en deuxième année et un autre de trois mois en troisième année. Ces projets m'ont permis de mettre en pratique mes connaissances et découvrir des nouvelles technologies.",
        image: "/assets/img/study/mmi.svg",
        imageDark: "/assets/img/study/mmi-dark.svg"
    },
    {
        name: "BUT informatique",
        year: "2022-2023",
        content: "J'ai commencé un BUT informatique à l'Université de Limoges, mais j'ai décidé de changer de voie après la première année. Bien que j'aie appris beaucoup de choses intéressantes, je me suis rendu compte que le développement web me passionnait davantage et le BUT Informatique était plus orienté sur le développement d'applications. N'ayant pas validé ma première année, j'ai donc décidé de me réorienter vers le BUT MMI, où je peux me concentrer sur le développement web et les technologies associées.",
    },
    {
        name: "Baccalauréat STI2D (Sciences et Technologies de l'Industrie et du Développement Durable)",
        year: "2022",
        content: "J'ai obtenu mon baccalauréat STI2D (sciences et technologies de l'industrie et du développement durable) en 2022 au lycée Raoul Dautry à Limoges. Cette formation m'a permis d'acquérir des compétences en sciences de l'ingénieur, en technologie et en développement durable. J'ai également réalisé plusieurs projets en équipe, ce qui m'a aidé à développer mes compétences en gestion de projet et en travail collaboratif.",
        // image: "/assets/img/study/sti2d.svg"
    }
]
</script>

<style scoped></style>