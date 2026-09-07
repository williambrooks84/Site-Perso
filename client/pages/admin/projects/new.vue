<template>
  <main class="mx-auto w-200 max-w-full px-4 py-12">
    <section class="rounded-2xl border border-border-grey bg-light p-8 shadow-sm">
      <header class="flex flex-col items-center justify-between gap-4">
        <h1 class="mt-2 text-3xl font-bold text-dark">
          Ajouter un projet
        </h1>

        <NuxtLink to="/admin/projects" class="btn-primary text-sm">
          Voir l'ensemble des projets
        </NuxtLink>
      </header>

      <div
        v-if="message"
        class="mb-6 rounded-xl border px-4 py-3 text-sm"
        :class="
          message.type === 'success'
            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
            : 'border-red-200 bg-red-50 text-red-700'
        "
      >
        {{ message.text }}
      </div>

      <AdminProjectForm
        :categories="categories"
        :technologies="technologies"
        :api-base-url="apiBaseUrl"
        :is-submitting="isSubmitting"
        :reset-key="projectFormResetKey"
        submit-label="Enregistrer le projet"
        loading-label="Enregistrement..."
        image-label="Image"
        image-input-id="project-image"
        @submit="submitProject"
      />

      <AdminProjectsList
        :projects="projects"
        :removing-project-id="removingProjectId"
        :api-base-url="apiBaseUrl"
        @refresh="loadProjects"
        @delete="deleteProject"
        @edit="openEditModal"
      />

      <div class="mb-2 mt-8 flex items-end gap-2">
        <div class="flex-1">
          <label
            for="newCategory"
            class="mb-2 block text-sm font-medium text-dark"
          >
            Nouvelle catégorie
          </label>

          <input
            id="newCategory"
            v-model="newCategoryName"
            type="text"
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
          />
        </div>

        <button
          type="button"
          :disabled="isCreatingCategory"
          class="btn-primary btn-sm w-fit disabled:cursor-not-allowed disabled:opacity-60"
          @click="createCategory"
        >
          {{ isCreatingCategory ? 'Ajout...' : 'Ajouter' }}
        </button>
      </div>

      <div class="mb-2 flex flex-col gap-2">
        <div class="flex-1">
          <label
            for="newTechnology"
            class="mb-2 block text-sm font-medium text-dark"
          >
            Nouvelle technologie
          </label>

          <input
            id="newTechnology"
            v-model="newTechnologyName"
            type="text"
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
          />
        </div>

        <div class="flex flex-col">
          <label
            for="technologyIcon"
            class="mb-2 block text-sm font-medium text-dark"
          >
            Icon
          </label>

          <input
            id="technologyIcon"
            type="file"
            accept=".svg,image/svg+xml"
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark file:mr-4 file:rounded-md file:border-0 file:bg-light file:px-3 file:py-2 file:text-sm file:font-medium"
            @change="onIconSelected"
          />
        </div>

        <button
          type="button"
          :disabled="isCreatingTechnology"
          class="btn-primary btn-sm w-fit disabled:cursor-not-allowed disabled:opacity-60"
          @click="createTechnology"
        >
          {{ isCreatingTechnology ? 'Ajout...' : 'Ajouter' }}
        </button>
      </div>

      <TechnologiesList
        :technologies="technologies"
        :removing-technology-id="removingTechnologyId"
        :api-base-url="apiBaseUrl"
        @refresh="loadTechnologies"
        @delete="deleteTechnology"
      />
    </section>

    <AdminProjectEditModal
      :is-open="isEditModalOpen"
      :project="editingProject"
      :categories="categories"
      :technologies="technologies"
      :api-base-url="apiBaseUrl"
      :is-submitting="isUpdatingProject"
      @close="closeEditModal"
      @submit="updateProjectFromModal"
    />
  </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import {
  createProject,
  updateProject,
  deleteProject as deleteProjectRequest,
} from '~/utils/projectApi'
import {
  getTechnologies,
  createTechnology as createTechnologyRequest,
  deleteTechnology as deleteTechnologyRequest,
} from '~/utils/technologyApi'
import {
  getCategories,
  createCategory as createCategoryRequest,
} from '~/utils/categoryApi'
import AdminProjectForm from '~/components/Admin/ProjectForm.vue'
import AdminProjectsList from '~/components/Admin/ProjectsList.vue'
import AdminProjectEditModal from '~/components/Admin/ProjectEditModal.vue'
import TechnologiesList from '~/components/Admin/TechnologiesList.vue'

definePageMeta({
  middleware: 'admin',
})

const runtimeConfig = useRuntimeConfig()

const apiBaseUrl =
  runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const isSubmitting = ref(false)
const removingProjectId = ref(null)
const message = ref(null)

const projects = ref([])
const categories = ref([])
const technologies = ref([])

const newCategoryName = ref('')
const newTechnologyName = ref('')

const isCreatingCategory = ref(false)
const isCreatingTechnology = ref(false)

const selectedTechnologyIconFile = ref(null)
const removingTechnologyId = ref(null)

const isEditModalOpen = ref(false)
const editingProject = ref(null)
const isUpdatingProject = ref(false)

const projectFormResetKey = ref(0)

const loadProjects = async () => {
  try {
    const response = await fetch(`${apiBaseUrl}/api/projects`, {
      headers: {
        Accept: 'application/ld+json',
      },
    })

    if (!response.ok) {
      throw new Error('Impossible de charger les projets')
    }

    const data = await response.json()

    projects.value = data.member || data
  } catch (error) {
    console.error('Erreur chargement projets:', error)
  }
}

const loadCategories = async () => {
  try {
    categories.value = await getCategories(apiBaseUrl)
  } catch (error) {
    console.error('Erreur chargement catégories:', error)
  }
}

const loadTechnologies = async () => {
  try {
    technologies.value = await getTechnologies(apiBaseUrl)
  } catch (error) {
    console.error('Erreur chargement technologies:', error)
  }
}

const submitProject = async projectForm => {
  isSubmitting.value = true
  message.value = null

  try {
    await createProject(
      {
        title: projectForm.title.trim(),
        description: projectForm.description.trim(),
        projectLink: projectForm.projectLink?.trim() || null,
        siteLink: projectForm.siteLink?.trim() || null,
        categoryId: Number(projectForm.categoryId),
        technologyIds: projectForm.technologyIds.map(
          technologyId => Number(technologyId)
        ),
        image: projectForm.image,
      },
      apiBaseUrl
    )

    projectFormResetKey.value++

    message.value = {
      type: 'success',
      text: 'Le projet a bien été créé.',
    }

    await loadProjects()
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Une erreur est survenue.',
    }
  } finally {
    isSubmitting.value = false
  }
}

const deleteProject = async project => {
  if (!window.confirm(`Supprimer le projet « ${project.title} » ?`)) {
    return
  }

  removingProjectId.value = project.id
  message.value = null

  try {
    await deleteProjectRequest(project.id, apiBaseUrl)

    message.value = {
      type: 'success',
      text: 'Le projet a bien été supprimé.',
    }

    await loadProjects()
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Impossible de supprimer le projet.',
    }
  } finally {
    removingProjectId.value = null
  }
}

const openEditModal = project => {
  editingProject.value = project
  isEditModalOpen.value = true
  message.value = null
}

const closeEditModal = () => {
  if (isUpdatingProject.value) {
    return
  }

  isEditModalOpen.value = false
  editingProject.value = null
}

const updateProjectFromModal = async projectForm => {
  if (!editingProject.value) {
    return
  }

  isUpdatingProject.value = true
  message.value = null

  try {
    const updatedProject = await updateProject(
      editingProject.value.id,
      {
        title: projectForm.title.trim(),
        description: projectForm.description.trim(),
        projectLink: projectForm.projectLink?.trim() || null,
        siteLink: projectForm.siteLink?.trim() || null,
        categoryId: Number(projectForm.categoryId),
        technologyIds: projectForm.technologyIds.map(
          technologyId => Number(technologyId)
        ),
        image: projectForm.image,
      },
      apiBaseUrl
    )

    const index = projects.value.findIndex(
      project => project.id === updatedProject.id
    )

    if (index !== -1) {
      projects.value[index] = updatedProject
    }

    message.value = {
      type: 'success',
      text: 'Le projet a bien été modifié.',
    }

    isEditModalOpen.value = false
    editingProject.value = null
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Impossible de modifier le projet.',
    }
  } finally {
    isUpdatingProject.value = false
  }
}

const createCategory = async () => {
  const name = newCategoryName.value.trim()

  if (!name) {
    message.value = {
      type: 'error',
      text: 'Le nom de la catégorie est obligatoire.',
    }

    return
  }

  isCreatingCategory.value = true
  message.value = null

  try {
    await createCategoryRequest(name, apiBaseUrl)

    message.value = {
      type: 'success',
      text: 'La catégorie a bien été créée.',
    }

    newCategoryName.value = ''

    await loadCategories()
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Impossible de créer la catégorie.',
    }
  } finally {
    isCreatingCategory.value = false
  }
}

const onIconSelected = event => {
  const file = event.target.files?.[0]

  if (!file) {
    selectedTechnologyIconFile.value = null
    return
  }

  const isSvg =
    file.type === 'image/svg+xml' ||
    file.name.toLowerCase().endsWith('.svg')

  if (!isSvg) {
    selectedTechnologyIconFile.value = null
    event.target.value = ''

    message.value = {
      type: 'error',
      text: 'Seuls les fichiers SVG sont acceptés.',
    }

    return
  }

  if (file.size > 10 * 1024 * 1024) {
    selectedTechnologyIconFile.value = null
    event.target.value = ''

    message.value = {
      type: 'error',
      text: 'L’icône SVG ne doit pas dépasser 10 Mo.',
    }

    return
  }

  selectedTechnologyIconFile.value = file
}

const createTechnology = async () => {
  const name = newTechnologyName.value.trim()

  if (!name) {
    message.value = {
      type: 'error',
      text: 'Le nom de la technologie est obligatoire.',
    }

    return
  }

  if (!selectedTechnologyIconFile.value) {
    message.value = {
      type: 'error',
      text: 'Une icône SVG est obligatoire.',
    }

    return
  }

  isCreatingTechnology.value = true
  message.value = null

  try {
    const technology = await createTechnologyRequest(
      name,
      selectedTechnologyIconFile.value,
      apiBaseUrl
    )

    technologies.value.push(technology)

    newTechnologyName.value = ''
    selectedTechnologyIconFile.value = null

    const input = document.getElementById('technologyIcon')

    if (input) {
      input.value = ''
    }

    message.value = {
      type: 'success',
      text: 'Technologie créée avec succès.',
    }
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Impossible de créer la technologie.',
    }
  } finally {
    isCreatingTechnology.value = false
  }
}

const deleteTechnology = async technology => {
  if (
    !window.confirm(
      `Supprimer la technologie « ${technology.name} » ?`
    )
  ) {
    return
  }

  removingTechnologyId.value = technology.id
  message.value = null

  try {
    await deleteTechnologyRequest(
      technology.id,
      apiBaseUrl
    )

    message.value = {
      type: 'success',
      text: 'La technologie a bien été supprimée.',
    }

    await loadTechnologies()
  } catch (error) {
    message.value = {
      type: 'error',
      text:
        error instanceof Error
          ? error.message
          : 'Impossible de supprimer la technologie.',
    }
  } finally {
    removingTechnologyId.value = null
  }
}

onMounted(() => {
  loadProjects()
  loadCategories()
  loadTechnologies()
})
</script>

<style scoped>
input,
textarea {
  font: inherit;
}
</style>