<template>
    <div class="flex flex-col justify-center items-center gap-8 lg:gap-10">
        <h2>Qui suis-je ?</h2>
        <div class="flex flex-col lg:flex-row gap-7 lg:gap-15 items-center justify-center">
            <img class="w-[300px] xl:w-auto h-auto rounded-3xl xl:rounded-4xl" src="/assets/img/will.jpg" alt="will" />
            <div>
                <ul role="list" class="space-y-5">
                    <HeroPoint v-for="(item, index) in items" :key="index" :icon="item.icon" :text="item.text" />
                </ul>
            </div>
        </div>
        <a href="/quisuisje"
            class="px-6 py-3 bg-primary text-light rounded font-semibold uppercase text-lg transition hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover">
            En savoir plus
        </a>
    </div>
</template>

<script setup>
import HeroPoint from './HeroPoint.vue';

const items = [
    { icon: 'bi-person-fill', text: 'William Brooks' },
    { icon: 'bi-calendar-fill', text: '20 ans' },
    { icon: 'bi-geo-alt-fill', text: 'Limoges, France (binational France/Rouayme-Uni)' },
    { icon: 'bi-code-slash', text: 'Développeur Web' },
    { icon: 'bi-camera-fill', text: 'Photographe' },
    { icon: 'bi-bus-front-fill', text: 'Passionné de transports en commun (bus, trains, trams, etc)' },
    { icon: 'bi-controller', text: 'Amateur de jeux vidéo (principalement Team Fortress 2)' },
    { icon: 'bi-music-note-beamed', text: 'Fan de musique (Hard Rock/Métal, Rock et Britpop)' }
];

</script>

<style scoped>
/* Ajoutez vos styles spécifiques ici */
</style>