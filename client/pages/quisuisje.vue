<template>
    <div>
        <div class="flex flex-col justify-center items-center gap-8 lg:gap-10">
            <img src="/assets/img/will.jpg" class="w-48 h-auto rounded-xl" alt="">
            <p class="body-text">Je suis William Brooks (ou tout simplement Will). J'ai 20 ans et je suis un étudiant en
                BUT MMI (Métiers du Multimédia et de l'Internet) dans le parcours du développement web. Depuis tout
                jeune, je suis très intéressé par l'informatique.</p>
            <p class="body-text">En dehors de ma formation, je suis passionné des transports en commun (surtout les bus
                et les trains) et je fais de la photographie dessus, en plus des paysages. Je suis contributeur sur
                l'association en ligne <a class="body-link" href="https://tc-infos.fr" target="_blank"
                    rel="noopener noreferrer">TC Infos</a>.</p>
            <p class="body-text">J'écoute beaucoup de musique, surtout du hard rock/métal comme Iron Maiden et Guns N'
                Roses et du Britpop comme Oasis. J'aime aussi les groupes de rock classique comme les Rolling Stones.
            </p>
        </div>
        <Study />
        <div class="my-10">
            <MediaShowcase />
        </div>
    </div>
</template>

<script setup>
import MediaShowcase from '~/components/Media/MediaShowcase.vue';
import Study from '~/components/Study/Study.vue';
</script>

<style scoped></style>