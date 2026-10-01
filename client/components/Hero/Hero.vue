<template>
    <section id="hero" class="flex flex-col justify-center items-center gap-8 lg:gap-10">
        <h2>Qui suis-je ?</h2>
        <div class="flex flex-col lg:flex-row gap-7 lg:gap-15 items-center justify-center">
            <img class="w-75 xl:w-auto h-auto rounded-3xl xl:rounded-4xl" src="/assets/img/will.jpg" alt="will" />
            <div>
                <ul role="list" class="space-y-5">
                    <HeroPoint v-for="(item, index) in items" :key="index" :icon="item.icon" :text="item.text" />
                </ul>
            </div>
        </div>
        <a href="/quisuisje"
            class="btn-primary">
            En savoir plus
        </a>
    </section>
</template>

<script setup>
import HeroPoint from './HeroPoint.vue';

const items = [
    { icon: 'bi-person-fill', text: 'William Brooks' },
    { icon: 'bi-calendar-fill', text: '22 ans' },
    { icon: 'bi-geo-alt-fill', text: 'Janailhac (près de Limoges), France' },
    { icon: 'bi-translate', text: 'Français & Anglais (binational)' },
    { icon: 'bi-code-slash', text: 'Développeur Web Junior' },
    { icon: 'bi-camera-fill', text: 'Photographe de transports en commun (bus, trains, trams) & paysages' },
];

</script>

<style scoped>
</style>