<template>
    <section class="space-y-4 md:space-y-8">
        <div class="md:flex md:items-center md:justify-center md:gap-2">
            <div
                v-if="desktopCategories.length >= 3"
                class="hidden items-center justify-center gap-2 md:flex"
            >
                <button
                    type="button"
                    :class="
                        desktopCategoryIndex === 0
                            ? 'btn-disabled'
                            : 'btn-unselected btn-unselected-small'
                    "
                    :disabled="desktopCategoryIndex === 0"
                    @click="previousDesktopCategory"
                >
                    <i class="bi bi-caret-left-fill"></i>
                </button>

                <div class="max-w-full overflow-hidden">
                    <div
                        class="flex transition-transform duration-300 ease-out"
                        :style="{
                            transform: `translateX(-${desktopCategoryIndex * 100}%)`,
                        }"
                    >
                        <div
                            v-for="(page, pageIndex) in desktopCategoryPages"
                            :key="pageIndex"
                            class="flex w-full shrink-0 items-center justify-center gap-6"
                        >
                            <button
                                v-for="category in page"
                                :key="category.id ?? 'all'"
                                type="button"
                                :class="[
                                    selectedCategoryId === category.id
                                        ? 'btn-primary'
                                        : 'btn-unselected',
                                    'btn-category whitespace-nowrap'
                                ]"
                                @click="selectCategory(category.id)"
                            >
                                {{ category.name }}
                            </button>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    :class="
                        desktopCategoryIndex === desktopMaxIndex
                            ? 'btn-disabled'
                            : 'btn-unselected btn-unselected-small'
                    "
                    :disabled="desktopCategoryIndex === desktopMaxIndex"
                    @click="nextDesktopCategory"
                >
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>

            <div
                v-else
                class="hidden items-center justify-center gap-3 md:flex"
            >
                <button
                    v-for="category in desktopCategories"
                    :key="category.id ?? 'all'"
                    type="button"
                    :class="[
                        selectedCategoryId === category.id
                            ? 'btn-primary'
                            : 'btn-unselected',
                        'btn-category whitespace-nowrap'
                    ]"
                    @click="selectCategory(category.id)"
                >
                    {{ category.name }}
                </button>
            </div>

            <div class="flex items-center justify-center gap-2 md:hidden">
                <button
                    type="button"
                    :class="
                        mobileCategoryIndex === 0
                            ? 'btn-disabled'
                            : 'btn-unselected btn-unselected-small'
                    "
                    :disabled="mobileCategoryIndex === 0"
                    @click="previousCategory"
                >
                    <i class="bi bi-caret-left-fill"></i>
                </button>

                <div class="min-w-0 flex-1 overflow-hidden">
                    <div
                        class="flex transition-transform duration-300 ease-out"
                        :style="{
                            transform: `translateX(-${mobileCategoryIndex * 100}%)`,
                        }"
                    >
                        <div
                            v-for="category in mobileCategories"
                            :key="category.id ?? 'all'"
                            class="flex w-full shrink-0 justify-center"
                        >
                            <button
                                type="button"
                                :class="[
                                    selectedCategoryId === category.id
                                        ? 'btn-primary'
                                        : 'btn-unselected',
                                    'btn-category w-full min-w-0 whitespace-nowrap'
                                ]"
                                @click="selectCategory(category.id)"
                            >
                                {{ category.name }}
                            </button>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    :class="
                        mobileCategoryIndex === mobileCategories.length - 1
                            ? 'btn-disabled'
                            : 'btn-unselected btn-unselected-small'
                    "
                    :disabled="
                        mobileCategoryIndex === mobileCategories.length - 1
                    "
                    @click="nextCategory"
                >
                    <i class="bi bi-caret-right-fill"></i>
                </button>
            </div>
        </div>

        <div
            v-if="selectedProjects.length"
            class="space-y-3 md:space-y-5"
        >
            <div class="flex justify-center gap-4">
                <div
                    v-if="selectedProjects.length > 1"
                    class="flex items-center gap-2"
                >
                    <button
                        type="button"
                        :class="
                            currentIndex === 0
                                ? 'btn-disabled'
                                : 'btn-unselected btn-unselected-small'
                        "
                        :disabled="currentIndex === 0"
                        @click="previous"
                    >
                        <i class="bi bi-caret-left-fill"></i>
                    </button>

                    <button
                        type="button"
                        :class="
                            currentIndex === selectedProjects.length - 1
                                ? 'btn-disabled'
                                : 'btn-unselected btn-unselected-small'
                        "
                        :disabled="
                            currentIndex === selectedProjects.length - 1
                        "
                        @click="next"
                    >
                        <i class="bi bi-caret-right-fill"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-hidden">
                <div
                    class="flex transition-transform duration-500 ease-out"
                    :style="{
                        transform: `translateX(-${currentIndex * 100}%)`,
                    }"
                >
                    <div
                        v-for="project in selectedProjects"
                        :key="project.id"
                        class="w-full shrink-0"
                    >
                        <ProjectCard
                            :project="project"
                            :category-name="getCategoryName(project)"
                            :api-base-url="apiBaseUrl"
                        />
                    </div>
                </div>
            </div>

            <div
                v-if="selectedProjects.length > 1"
                class="flex justify-center gap-2"
            >
                <button
                    v-for="(_, index) in selectedProjects"
                    :key="index"
                    type="button"
                    class="h-2.5 rounded-full transition-all"
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

        <div
            v-else
            class="py-12 text-center text-dark/50"
        >
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
const mobileCategoryIndex = ref(0)
const desktopCategoryIndex = ref(0)

const categoriesWithProjects = computed(() => {
    return props.categories.filter(category =>
        props.projects.some(
            project =>
                Number(project.category?.id) ===
                Number(category.id)
        )
    )
})

const desktopCategories = computed(() => {
    return [
        {
            id: null,
            name: 'Tous',
        },
        ...categoriesWithProjects.value,
    ]
})

const desktopCategoryPages = computed(() => {
    const pages = []

    for (
        let index = 0;
        index < desktopCategories.value.length;
        index += 3
    ) {
        pages.push(
            desktopCategories.value.slice(index, index + 3)
        )
    }

    return pages
})

const mobileCategories = computed(() => {
    return desktopCategories.value
})

const desktopMaxIndex = computed(() => {
    return Math.max(
        desktopCategoryPages.value.length - 1,
        0
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

    const mobileIndex = mobileCategories.value.findIndex(
        category =>
            Number(category.id) === Number(categoryId)
    )

    if (mobileIndex !== -1) {
        mobileCategoryIndex.value = mobileIndex
    }

    const desktopIndex = desktopCategories.value.findIndex(
        category =>
            Number(category.id) === Number(categoryId)
    )

    if (desktopIndex !== -1) {
        desktopCategoryIndex.value = Math.floor(
            desktopIndex / 3
        )
    }
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

const previousCategory = () => {
    if (mobileCategoryIndex.value > 0) {
        const index = mobileCategoryIndex.value - 1
        const category = mobileCategories.value[index]

        selectCategory(category.id)
    }
}

const nextCategory = () => {
    if (
        mobileCategoryIndex.value <
        mobileCategories.value.length - 1
    ) {
        const index = mobileCategoryIndex.value + 1
        const category = mobileCategories.value[index]

        selectCategory(category.id)
    }
}

const previousDesktopCategory = () => {
    if (desktopCategoryIndex.value > 0) {
        desktopCategoryIndex.value--
    }
}

const nextDesktopCategory = () => {
    if (
        desktopCategoryIndex.value <
        desktopMaxIndex.value
    ) {
        desktopCategoryIndex.value++
    }
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
            mobileCategoryIndex.value = 0
            desktopCategoryIndex.value = 0
        }

        const maxIndex = Math.max(
            Math.ceil((categories.length + 1) / 3) - 1,
            0
        )

        if (desktopCategoryIndex.value > maxIndex) {
            desktopCategoryIndex.value = maxIndex
        }
    },
    {
        immediate: true,
    }
)
</script>