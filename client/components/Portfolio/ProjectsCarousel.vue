<template>
    <div
        class="flex w-full min-w-0 max-w-full flex-col items-center space-y-4 md:space-y-5"
    >
        <!-- Categories -->
        <div class="w-full min-w-0 md:max-w-1/4">
            <CategorySelect
                v-model="selectedCategoryId"
                :categories="categoriesWithProjects"
            />
        </div>

        <!-- Projects -->
        <div
            v-if="selectedProjects.length"
            class="w-full min-w-0 max-w-full space-y-3 md:space-y-5"
        >
            <!-- Mobile controls -->
            <div
                v-if="selectedProjects.length > 1"
                class="flex flex-col items-center gap-3 md:hidden"
            >
                <div class="flex justify-center gap-4">
                    <CarouselButton
                        direction="left"
                        label="Projet précédent"
                        :disabled="currentIndex === 0"
                        @click="previous"
                    />

                    <CarouselButton
                        direction="right"
                        label="Projet suivant"
                        :disabled="
                            currentIndex ===
                            selectedProjects.length - 1
                        "
                        @click="next"
                    />
                </div>

                <div
                    class="flex max-w-full flex-wrap justify-center gap-2"
                >
                    <button
                        v-for="(_, index) in selectedProjects"
                        :key="index"
                        type="button"
                        class="h-2.5 shrink-0 rounded-full transition-all"
                        :class="
                            currentIndex === index
                                ? 'w-8 bg-primary'
                                : 'w-2.5 bg-border-grey'
                        "
                        :aria-label="`Afficher le projet ${index + 1}`"
                        @click="goTo(index)"
                    ></button>
                </div>
            </div>

            <!-- Project carousel -->
            <div
                class="flex w-full min-w-0 max-w-full items-stretch justify-center gap-2 sm:gap-4 md:gap-6"
            >
                <!-- Desktop left arrow -->
                <div
                    class="hidden w-10 shrink-0 md:flex md:items-center"
                >
                    <CarouselButton
                        direction="left"
                        label="Projet précédent"
                        :disabled="currentIndex === 0"
                        @click="previous"
                    />
                </div>

                <!-- Carousel viewport -->
                <div
                    ref="viewportRef"
                    class="relative min-w-0 max-w-full flex-1 overflow-hidden xl:h-150"
                    :style="{
                        height:
                            maxHeight > 0
                                ? `${maxHeight}px`
                                : undefined,
                    }"
                >
                    <!-- Track -->
                    <div
                        class="flex h-full items-stretch transition-transform duration-500 ease-out"
                        :style="{
                            transform: `translate3d(-${currentIndex * 100}%, 0, 0)`,
                        }"
                    >
                        <!-- Slides -->
                        <div
                            v-for="project in selectedProjects"
                            :key="project.id"
                            class="flex h-full w-full min-w-0 shrink-0 items-stretch"
                        >
                            <ProjectCard
                                :project="project"
                                :category-name="
                                    getCategoryName(project)
                                "
                                :api-base-url="apiBaseUrl"
                                class="h-full"
                            />
                        </div>
                    </div>
                </div>

                <!-- Desktop right arrow -->
                <div
                    class="hidden w-10 shrink-0 md:flex md:items-center"
                >
                    <CarouselButton
                        direction="right"
                        label="Projet suivant"
                        :disabled="
                            currentIndex ===
                            selectedProjects.length - 1
                        "
                        @click="next"
                    />
                </div>
            </div>

            <!-- Desktop indicators -->
            <div
                v-if="selectedProjects.length > 1"
                class="hidden justify-center gap-2 md:flex"
            >
                <button
                    v-for="(_, index) in selectedProjects"
                    :key="index"
                    type="button"
                    class="h-2.5 shrink-0 rounded-full transition-all"
                    :class="
                        currentIndex === index
                            ? 'w-8 bg-primary'
                            : 'w-2.5 bg-border-grey'
                    "
                    :aria-label="`Afficher le projet ${index + 1}`"
                    @click="goTo(index)"
                ></button>
            </div>
        </div>

        <!-- No projects -->
        <div
            v-else
            class="w-full min-w-0 max-w-full py-12 text-center text-dark/50"
        >
            Aucun projet disponible.
        </div>
    </div>

    <!-- Hidden measurement -->
    <div
        ref="measureRef"
        class="pointer-events-none fixed left-0 top-0 invisible"
        :style="{
            width: `${measurementWidth}px`,
        }"
        aria-hidden="true"
    >
        <div
            v-for="project in selectedProjects"
            :key="`measure-${project.id}`"
            class="w-full"
        >
            <ProjectCard
                :project="project"
                :category-name="getCategoryName(project)"
                :api-base-url="apiBaseUrl"
            />
        </div>
    </div>
</template>

<script setup>
import {
    computed,
    nextTick,
    onMounted,
    onUnmounted,
    ref,
    watch,
} from 'vue'

import ProjectCard from '~/components/Portfolio/ProjectCard.vue'
import CarouselButton from './CarouselButton.vue'
import CategorySelect from './CategorySelect.vue'

const props = defineProps({
    projects: {
        type: Array,
        default: () => [],
    },

    categories: {
        type: Array,
        default: () => [],
    },

    apiBaseUrl: {
        type: String,
        required: true,
    },
})

const selectedCategoryId = ref(null)
const currentIndex = ref(0)

const viewportRef = ref(null)
const measureRef = ref(null)

const maxHeight = ref(0)
const measurementWidth = ref(0)

let resizeObserver = null

const categoriesWithProjects = computed(() => {
    return props.categories.filter(category =>
        props.projects.some(
            project =>
                Number(project.category?.id) ===
                Number(category.id)
        )
    )
})

const selectedProjects = computed(() => {
    if (selectedCategoryId.value === null) {
        return props.projects
    }

    return props.projects.filter(
        project =>
            Number(project.category?.id) ===
            Number(selectedCategoryId.value)
    )
})

const previous = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--
    }
}

const next = () => {
    if (
        currentIndex.value <
        selectedProjects.value.length - 1
    ) {
        currentIndex.value++
    }
}

const goTo = index => {
    currentIndex.value = index
}

const getCategoryName = project => {
    return project.category?.name || ''
}

const waitForLayout = async () => {
    await nextTick()

    if (document.fonts?.ready) {
        await document.fonts.ready
    }

    await new Promise(resolve => {
        requestAnimationFrame(() => {
            requestAnimationFrame(resolve)
        })
    })
}

const updateMaxHeight = async () => {
    await waitForLayout()

    if (!viewportRef.value || !measureRef.value) {
        return
    }

    /*
     * At XL and above the height is fixed to 600px.
     * No dynamic measurement is necessary.
     */
    if (
        window.matchMedia('(min-width: 1280px)').matches
    ) {
        maxHeight.value = 600
        return
    }

    const width = viewportRef.value.clientWidth

    if (!width) {
        return
    }

    measurementWidth.value = width

    await waitForLayout()

    const cards = Array.from(
        measureRef.value.children
    )

    if (!cards.length) {
        return
    }

    const heights = cards
        .map(card =>
            Math.ceil(
                card.getBoundingClientRect().height
            )
        )
        .filter(height => height > 0)

    if (!heights.length) {
        return
    }

    maxHeight.value = Math.max(...heights)
}

watch(
    selectedProjects,
    async projects => {
        if (currentIndex.value >= projects.length) {
            currentIndex.value = Math.max(
                projects.length - 1,
                0
            )
        }

        await updateMaxHeight()
    },
    {
        immediate: true,
        deep: true,
    }
)

watch(selectedCategoryId, async () => {
    currentIndex.value = 0

    await nextTick()
    await updateMaxHeight()
})

onMounted(async () => {
    await updateMaxHeight()

    resizeObserver = new ResizeObserver(() => {
        updateMaxHeight()
    })

    if (viewportRef.value) {
        resizeObserver.observe(viewportRef.value)
    }
})

onUnmounted(() => {
    resizeObserver?.disconnect()
})
</script>