<template>
    <article
        class="grid h-150 overflow-hidden rounded-2xl border-2 border-primary/50 bg-light shadow-sm md:h-125 md:grid-cols-2">
        <div class="aspect-video overflow-hidden md:aspect-auto">
            <img v-if="projectImage" :src="projectImage" :alt="project.title"
                class="h-full w-full object-cover transition duration-500 hover:scale-105" />

            <div v-else class="flex h-full min-h-64 items-center justify-center bg-hover text-dark/40">
                Aucune image
            </div>
        </div>

        <div class="flex min-h-0 flex-col justify-between p-4 md:p-8">
            <div>
                <h3 class="text-xl font-bold text-dark md:text-2xl uppercase">
                    {{ project.title }}
                </h3>

                <p class="mt-3 text-sm leading-6 text-dark md:mt-4 md:text-base md:leading-7">
                    {{ project.description }}
                </p>

                <div v-if="project.technologies?.length" class="mt-4 md:mt-6">
                    <p class="mb-2 text-base font-semibold uppercase text-secondary md:mb-3 md:text-lg">
                        Technologies utilisées
                    </p>

                    <div class="flex flex-wrap gap-2">
                        <span v-for="technology in project.technologies" :key="technology.id"
                            class="group flex items-center justify-center gap-2 rounded-lg bg-secondary px-2.5 py-1.5 text-sm font-semibold text-dark transition duration-200 hover:scale-150 hover:shadow-md md:px-3 md:py-2 md:text-lg">
                            <img v-if="getTechnologyIcon(technology)" :src="getTechnologyIcon(technology)"
                                :alt="technology.name"
                                class="h-4 w-4 object-contain transition duration-200 group-hover:scale-110 md:h-5 md:w-5" />

                            <span>
                                {{ technology.name }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex shrink-0 flex-row justify-center gap-2 md:mt-8 md:gap-3">
                <a v-if="project.siteLink" :href="project.siteLink" target="_blank" rel="noopener noreferrer"
                    class="btn-primary btn-sm">
                    Voir le site
                </a>

                <a v-if="project.projectLink" :href="project.projectLink" target="_blank" rel="noopener noreferrer"
                    class="btn-secondary btn-sm">
                    Voir le projet
                </a>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    categoryName: {
        type: String,
        default: '',
    },
    apiBaseUrl: {
        type: String,
        required: true,
    },
})

const projectImage = computed(() => {
    const image =
        props.project.image ||
        props.project.imagePath ||
        props.project.imageUrl

    if (!image) {
        return ''
    }

    if (/^https?:\/\//.test(image)) {
        return image
    }

    return `${props.apiBaseUrl}${image.startsWith('/') ? '' : '/'}${image}`
})

const getTechnologyIcon = technology => {
    const icon =
        technology.icon ||
        technology.iconPath

    if (!icon) {
        return ''
    }

    if (/^https?:\/\//.test(icon)) {
        return icon
    }

    return `${props.apiBaseUrl}${icon.startsWith('/') ? '' : '/'}${icon}`
}
</script>