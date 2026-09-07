<template>
    <Teleport to="body">
        <div
            v-if="isOpen"
            class="fixed inset-0 z-[200] flex items-center justify-center bg-black/50 p-4"
            @click.self="close"
        >
            <div class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-light shadow-2xl">
                <header class="flex items-center justify-between border-b border-border-grey px-6 py-5">
                    <div>
                        <h2 class="text-2xl font-bold text-dark">
                            Modifier le projet
                        </h2>

                        <p class="mt-1 text-sm text-dark/60">
                            {{ project?.title }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-lg text-2xl text-dark/50 transition hover:bg-hover hover:text-dark"
                        :disabled="isSubmitting"
                        @click="close"
                    >
                        ×
                    </button>
                </header>

                <div class="overflow-y-auto p-6">
                    <AdminProjectForm
                        v-if="project"
                        :key="project.id"
                        :initial-value="form"
                        :categories="categories"
                        :technologies="technologies"
                        :api-base-url="apiBaseUrl"
                        :is-submitting="isSubmitting"
                        edit-mode
                        submit-label="Enregistrer les modifications"
                        loading-label="Modification..."
                        image-label="Nouvelle image"
                        image-input-id="edit-project-image"
                        @submit="submit"
                    />
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
    project: {
        type: Object,
        default: null,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    technologies: {
        type: Array,
        default: () => [],
    },
    apiBaseUrl: {
        type: String,
        required: true,
    },
    isSubmitting: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close', 'submit'])

const form = ref({
    title: '',
    description: '',
    projectLink: '',
    siteLink: '',
    categoryId: '',
    technologyIds: [],
})

const resetForm = () => {
    form.value = {
        title: '',
        description: '',
        projectLink: '',
        siteLink: '',
        categoryId: '',
        technologyIds: [],
    }
}

watch(
    () => props.project,
    project => {
        if (!project) {
            resetForm()
            return
        }

        form.value = {
            title: project.title || '',
            description: project.description || '',
            projectLink: project.projectLink || '',
            siteLink: project.siteLink || '',
            categoryId: project.category?.id
                ? String(project.category.id)
                : '',
            technologyIds:
                project.technologies?.map(
                    technology => Number(technology.id)
                ) || [],
        }
    },
    { immediate: true }
)

watch(
    () => props.isOpen,
    isOpen => {
        if (!isOpen) {
            resetForm()
        }
    }
)

const close = () => {
    if (props.isSubmitting) {
        return
    }

    emit('close')
}

const submit = value => {
    emit('submit', value)
}
</script>