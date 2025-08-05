<template>

    <div class="space-y-8 mt-15">
        <h2>Mes études</h2>
        <StudyPoint v-for="(study, index) in studies" :key="index" :name="study.name" :year="study.year"
            :content="study.content" :image="study.image" />
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
import StudyPoint from './StudyPoint.vue';

const studies = [
    {
        name: "BUT Métiers du Multimédia et de l'Internet",
        year: "Depuis 2023",
        content: "Je suis actuellement à l'IUT du Limousin en BUT MMI (métiers du Multimédia et de l'Internet), parcours développement web. J'y apprends les bases du développement web, ainsi que des compétences en design et en gestion de projet. En tant que formation de trois ans, la première année m'a aidé à trouver ma voie me donnant le choix entre la création numérique (graphisme et design) et le développement web (code). Je me suis orienté vers le développement web, car j'aime beaucoup coder et créer des sites web ainsi que gérer son fonctionnement côté serveur. J'ai réalisé plusieurs projets en autonomie et j'ai également réalisé un stage de deux mois où j'ai pu mettre en pratique mes colmpétences ainsi que découvrir des nouvelles technologies.",
        image: "/assets/img/study/mmi.svg"
    }
];

</script>

<style scoped></style>