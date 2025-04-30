<template>
    <div class="flex flex-col justify-center items-center p-20 gap-10">
        <h2 class="text-primary text-3xl font-bold text-center">Qui suis-je ?</h2>
        <div class="flex flex-col lg:flex-row gap-15 items-center justify-center">
            <img class="w-[300px] xl:w-auto h-auto rounded-3xl xl:rounded-4xl" src="/assets/img/will.jpg" alt="will" />
            <div>
                <ul role="list" class="space-y-5">
                    <HeroPoint v-for="(item, index) in text" :key="index" :text="item" />
                </ul>
            </div>
        </div>
        <Button label="En savoir plus" padding="px-4 py-2" bgColor="bg-primary hover:bg-secondary transition"
        textColor="text-light hover:text-primary" textSize="text-lg" rounded="rounded-lg" />
    </div>    
</template>

<script setup>
import HeroPoint from './HeroPoint.vue';

const text = [
    "William Brooks",
    "20 ans",
    "France/Royaume-Uni",
    "Développeur Web",
    "Photographe",
    "Passionné de transports en commun (bus, trains, trams, etc)",
    "Amateur de jeux vidéo (principalement Team Fortress 2)",
    "Fan de musique (Hard Rock/Métal, Rock et Britpop)"
];
</script>

<style scoped>
/* Ajoutez vos styles spécifiques ici */
</style>