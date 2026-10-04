<template>
    <article
        class="grid w-full min-w-0 overflow-hidden rounded-2xl border-2 border-primary/50 bg-light shadow-sm md:h-125 md:grid-cols-2"
    >
        <!-- Image -->
        <div
            class="relative aspect-video min-w-0 w-full overflow-hidden md:aspect-auto md:h-full"
        >
            <ImagePreview
                v-if="projectImage"
                :src="projectImage"
                :alt="project.title"
            >
                <img
                    :src="projectImage"
                    :alt="project.title"
                    class="block h-full w-full object-cover transition duration-500 hover:scale-105"
                />
            </ImagePreview>

            <div
                v-else
                class="flex h-full min-h-56 w-full items-center justify-center bg-hover text-dark/40"
            >
                Aucune image
            </div>
        </div>

        <!-- Content -->
        <div
            class="flex min-w-0 w-full flex-col justify-between p-4 sm:p-5 md:p-8"
        >
            <div class="min-w-0 w-full">
                <!-- Title -->
                <h3
                    class="w-full min-w-0 wrap-break-word text-lg font-bold uppercase leading-tight text-dark sm:text-xl md:text-2xl"
                >
                    {{ project.title }}
                </h3>

                <!-- Description -->
                <p
                    class="mt-3 w-full min-w-0 wrap-break-word text-left text-sm leading-6 text-dark sm:text-justify md:mt-4 md:leading-7 lg:text-base"
                >
                    {{ project.description }}
                </p>

                <!-- Technologies -->
                <div
                    v-if="project.technologies?.length"
                    class="mt-4 min-w-0 w-full md:mt-6"
                >
                    <p
                        class="mb-2 text-center text-sm font-semibold uppercase text-secondary sm:text-base md:mb-3 md:text-left md:text-lg"
                    >
                        Technologies utilisées
                    </p>

                    <div
                        class="flex min-w-0 w-full flex-wrap justify-center gap-2 md:justify-start"
                    >
                        <span
                            v-for="technology in project.technologies"
                            :key="technology.id"
                            class="group flex max-w-full min-w-0 shrink items-center justify-center gap-1.5 rounded-lg bg-secondary px-2 py-1.5 text-xs font-semibold text-dark transition duration-200 hover:shadow-md sm:gap-2 sm:px-2.5 sm:text-sm md:px-3 md:py-2 md:text-lg"
                        >
                            <img
                                v-if="getTechnologyIcon(technology)"
                                :src="
                                    getTechnologyIcon(
                                        technology
                                    )
                                "
                                :alt="technology.name"
                                class="h-4 w-4 shrink-0 object-contain transition duration-200 group-hover:scale-110 md:h-5 md:w-5"
                            />

                            <span
                                class="min-w-0 max-w-full wrap-break-word text-center"
                            >
                                {{ technology.name }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Links -->
            <div
                class="mt-5 flex min-w-0 w-full shrink-0 flex-wrap justify-center gap-2 sm:mt-6 md:mt-8 md:gap-3"
            >
                <a
                    v-if="project.siteLink"
                    :href="project.siteLink"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-primary btn-sm max-w-full"
                >
                    Voir le site
                </a>

                <a
                    v-if="project.projectLink"
                    :href="project.projectLink"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-secondary btn-sm max-w-full"
                >
                    Voir le projet
                </a>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue'
import ImagePreview from './ImagePreview.vue'

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