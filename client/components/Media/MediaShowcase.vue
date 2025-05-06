<template>
    <div class="flex flex-col gap-8">
        <h2>Venez voir mes réseaux sociaux</h2>
        <div class="flex flex-wrap gap-6 lg:flex-row justify-between items-center">
            <Media v-for="(media, index) in media" :key="index" :icon="media.icon" :name="media.name" :link="media.link"
                size="large" />
        </div>
    </div>
</template>

<script setup>

import Media from './Media.vue'

const media = [
    {
        icon: '/assets/icons/media/facebook.svg',
        name: 'Facebook',
        link: 'https://www.facebook.com/profile.php?id=100026596052394'
    },
    {
        icon: '/assets/icons/media/github.svg',
        name: 'GitHub',
        link: 'https://github.com/williambrooks84'
    },
    {
        icon: '/assets/icons/media/instagram.svg',
        name: 'Instagram',
        link: 'https://www.instagram.com/photostransports87/'
    },
    {
        icon: '/assets/icons/media/linkedin.svg',
        name: 'LinkedIn',
        link: 'https://www.linkedin.com/in/william-brooks-60408b272/'
    },
    {
        icon: '/assets/icons/media/spotify.svg',
        name: 'Spotify',
        link: 'https://open.spotify.com/user/wfjb04?si=3a341ab99db84bfd'
    },
    {
        icon: '/assets/icons/media/steam.svg',
        name: 'Steam',
        link: 'https://steamcommunity.com/id/strangeco05/'
    },
    {
        icon: '/assets/icons/media/x-twitter.svg',
        name: 'X-Twitter',
        link: 'https://x.com/Strange0488'
    },
    {
        icon: '/assets/icons/media/youtube.svg',
        name: 'YouTube',
        link: 'https://www.youtube.com/channel/UC3u-t_nbl1A9rPIw0qYT4XQ'
    }
]

</script>

<style scoped></style>
