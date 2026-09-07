<template>
    <section class="space-y-4 md:space-y-8">
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button type="button" :class="[
                selectedCategoryId === null
                    ? 'btn-primary'
                    : 'btn-unselected',
                'btn-category'
            ]" @click="selectCategory(null)">
                Tous
            </button>

            <button v-for="category in categoriesWithProjects" :key="category.id" type="button" :class="[
                selectedCategoryId === category.id
                    ? 'btn-primary'
                    : 'btn-unselected',
                'btn-category'
            ]" @click="selectCategory(category.id)">
                {{ category.name }}
            </button>
        </div>

        <div v-if="selectedProjects.length" class="space-y-3 md:space-y-5">
            <div class="flex justify-center gap-4">
                <div v-if="selectedProjects.length > 1" class="flex items-center gap-2">
                    <button type="button" :class="currentIndex === 0
                        ? 'btn-disabled'
                        : 'btn-unselected btn-unselected-small'
                        " :disabled="currentIndex === 0" @click="previous">
                        <i class="bi bi-caret-left-fill"></i>
                    </button>

                    <button type="button" :class="currentIndex === selectedProjects.length - 1
                        ? 'btn-disabled'
                        : 'btn-unselected btn-unselected-small'
                        " :disabled="currentIndex === selectedProjects.length - 1" @click="next">
                        <i class="bi bi-caret-right-fill"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-out" :style="{
                    transform: `translateX(-${currentIndex * 100}%)`,
                }">
                    <div v-for="project in selectedProjects" :key="project.id" class="w-full shrink-0">
                        <ProjectCard :project="project" :category-name="getCategoryName(project)"
                            :api-base-url="apiBaseUrl" />
                    </div>
                </div>
            </div>

            <div v-if="selectedProjects.length > 1" class="flex justify-center gap-2">
                <button v-for="(_, index) in selectedProjects" :key="index" type="button"
                    class="h-2.5 rounded-full transition-all" :class="currentIndex === index
                        ? 'w-8 bg-primary'
                        : 'w-2.5 bg-border-grey'
                        " :aria-label="`Afficher le projet ${index + 1}`" @click="goTo(index)"></button>
            </div>
        </div>

        <div v-else class="py-12 text-center text-dark/50">
            Aucun projet disponible.
        </div>
    </section>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import ProjectCard from '~/components/Portfolio/ProjectCard.vue'

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

const selectedCategory = computed(() => {
    if (selectedCategoryId.value === null) {
        return null
    }

    return categoriesWithProjects.value.find(
        category =>
            Number(category.id) ===
            Number(selectedCategoryId.value)
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

const selectCategory = categoryId => {
    selectedCategoryId.value = categoryId
    currentIndex.value = 0
}

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

watch(
    categoriesWithProjects,
    categories => {
        if (
            selectedCategoryId.value !== null &&
            !categories.some(
                category =>
                    Number(category.id) ===
                    Number(selectedCategoryId.value)
            )
        ) {
            selectedCategoryId.value = null
            currentIndex.value = 0
        }
    },
    {
        immediate: true,
    }
)
</script>