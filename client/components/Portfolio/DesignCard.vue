<template>
    <article
        class="flex h-full w-full min-w-0 flex-col overflow-hidden rounded-2xl border-2 border-primary/50 bg-light shadow-sm transition duration-300 hover:shadow-md"
    >
        <!-- Image -->
        <div
            class="relative aspect-video min-w-0 w-full shrink-0 overflow-hidden"
        >
            <ImagePreview
                v-if="designImage"
                :src="designImage"
                :alt="design.title"
            >
                <img
                    :src="designImage"
                    :alt="design.title"
                    class="block h-full w-full object-cover transition duration-500 hover:scale-105"
                />
            </ImagePreview>

            <div
                v-else
                class="flex h-full min-h-48 w-full items-center justify-center bg-hover text-dark/40"
            >
                Aucune image
            </div>
        </div>

        <!-- Content -->
        <div
            class="flex min-w-0 w-full flex-1 flex-col p-4 sm:p-5"
        >
            <div class="min-w-0 w-full">
                <!-- Title -->
                <h3
                    class="w-full min-w-0 wrap-break-word text-lg font-bold uppercase leading-tight text-dark sm:text-xl"
                >
                    {{ design.title }}
                </h3>

                <!-- Description -->
                <p
                    v-if="design.description"
                    class="mt-3 w-full min-w-0 wrap-break-word text-left text-sm leading-6 text-dark sm:text-justify"
                >
                    {{ design.description }}
                </p>
            </div>

            <!-- Preview -->
            <div class="mt-auto pt-4">
                <DesignPreview
                    v-if="designPreviewImage"
                    :src="designPreviewImage"
                    :alt="`Aperçu de ${design.title}`"
                >
                    <span
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-white transition hover:opacity-90"
                    >
                        <i
                            class="bi bi-eye"
                            aria-hidden="true"
                        ></i>

                        Aperçu
                    </span>
                </DesignPreview>

                <span
                    v-else
                    class="text-sm text-dark/50"
                >
                    Aucun aperçu disponible
                </span>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed } from 'vue'
import ImagePreview from './ImagePreview.vue'
import DesignPreview from './DesignPreview.vue'

const props = defineProps({
    design: {
        type: Object,
        required: true,
    },

    apiBaseUrl: {
        type: String,
        required: true,
    },
})

const getImageUrl = path => {
    if (!path) {
        return ''
    }

    if (/^https?:\/\//i.test(path)) {
        return path
    }

    return `${props.apiBaseUrl}${path.startsWith('/') ? '' : '/'}${path}`
}

const designImage = computed(() => {
    return getImageUrl(props.design?.imagePath)
})

const designPreviewImage = computed(() => {
    return getImageUrl(props.design?.previewPath)
})
</script>