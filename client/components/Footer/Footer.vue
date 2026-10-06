<template>
    <button v-if="!isOpen"
        class="fixed bottom-0 left-1/2 -translate-x-1/2 bg-secondary text-dark rounded-full p-2 z-50 transition hover:bg-hover"
        @click="toggleFooter" aria-label="Ouvrir le footer" :aria-expanded="isOpen">
        <i class="bi bi-chevron-up text-2xl" aria-hidden="true"></i>
    </button>

    <footer :class="[
        'fixed left-0 w-full z-40 bg-secondary text-dark transition-all duration-300',
        isOpen ? 'bottom-0' : '-bottom-35'
    ]">
        <button v-if="isOpen"
            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-secondary text-dark rounded-full p-2 transition hover:bg-hover"
            @click="toggleFooter" aria-label="Fermer le footer">
            <i class="bi bi-chevron-down text-2xl" aria-hidden="true"></i>
        </button>

        <div class="flex flex-col pt-6 pb-4 gap-4">
            <div class="flex flex-col items-center font-semibold">

                <span class="mb-2 text-center">
                    © {{ currentYear }} William Brooks. Tous droits réservés.
                </span>

                <div class="flex flex-row gap-6">
                    <a href="/mentionslegales" class="text-primary text-base hover:underline">
                        Mentions légales
                    </a>
                    <a href="/contact" class="text-primary text-base hover:underline">
                        Me contacter
                    </a>
                </div>
            </div>
            <!-- Réseaux sociaux -->
            <nav aria-label="Réseaux sociaux" class="flex flex-row justify-center items-center gap-4 mb-4">
                <Media v-for="mediaItem in media" :key="mediaItem.name" :icon="mediaItem.icon" :name="mediaItem.name"
                    :link="mediaItem.link" size="default" />
            </nav>
        </div>
    </footer>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import Media from '../Media/Media.vue'

const isOpen = ref(false)
const isDark = ref(false)

const toggleFooter = () => {
    isOpen.value = !isOpen.value
}

const currentYear = new Date().getFullYear()

onMounted(() => {
    const observer = new MutationObserver(() => {
        isDark.value = document.documentElement.classList.contains('dark')
    })

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    })

    isDark.value = document.documentElement.classList.contains('dark')
})

const media = computed(() => [
    {
        icon: isDark.value
            ? '/assets/icons/media/github-dark.svg'
            : '/assets/icons/media/github.svg',
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
        icon: '/assets/icons/media/youtube.svg',
        name: 'YouTube',
        link: 'https://www.youtube.com/channel/UC3u-t_nbl1A9rPIw0qYT4XQ'
    }
])
</script>