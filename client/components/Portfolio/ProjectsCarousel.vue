<template>
    <div
        class="flex w-full min-w-0 max-w-full flex-col items-center space-y-4 md:space-y-8"
    >
        <!-- Categories -->
        <div class="w-full min-w-0 max-w-full">
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
                <!-- Mobile arrows -->
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

                <!-- Mobile indicators -->
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
                class="flex w-full min-w-0 max-w-full items-center justify-center gap-2 sm:gap-4 md:gap-6"
            >
                <!-- Desktop left arrow -->
                <div class="hidden w-10 shrink-0 md:block">
                    <CarouselButton
                        direction="left"
                        label="Projet précédent"
                        :disabled="currentIndex === 0"
                        @click="previous"
                    />
                </div>

                <!-- Carousel viewport -->
                <div
                    class="min-w-0 max-w-full flex-1 overflow-hidden"
                >
                    <!-- Carousel track -->
                    <div
                        class="flex transition-transform duration-500 ease-out"
                        :style="{
                            transform: `translate3d(-${currentIndex * 100}%, 0, 0)`,
                        }"
                    >
                        <!-- Slide -->
                        <div
                            v-for="project in selectedProjects"
                            :key="project.id"
                            class="w-full min-w-0 shrink-0"
                        >
                            <ProjectCard
                                :project="project"
                                :category-name="
                                    getCategoryName(project)
                                "
                                :api-base-url="apiBaseUrl"
                            />
                        </div>
                    </div>
                </div>

                <!-- Desktop right arrow -->
                <div class="hidden w-10 shrink-0 md:block">
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
</template>

<script setup>
import { computed, ref, watch } from 'vue'
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

watch(
    selectedProjects,
    projects => {
        if (currentIndex.value >= projects.length) {
            currentIndex.value = Math.max(
                projects.length - 1,
                0
            )
        }
    },
    {
        immediate: true,
    }
)

watch(selectedCategoryId, () => {
    currentIndex.value = 0
})
</script>