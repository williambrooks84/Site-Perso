<template>
  <main class="mx-auto w-200 max-w-full px-4 py-12">
    <section class="rounded-2xl border border-border-grey bg-light p-8 shadow-sm">
      <header class="flex flex-col items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-dark">
          Administration des projets
        </h1>

        <NuxtLink
          to="/admin/projects/new"
          class="btn-primary text-sm"
        >
          Ajouter un projet
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

      <AdminProjectsList
        :projects="projects"
        :removing-project-id="removingProjectId"
        :api-base-url="apiBaseUrl"
        @refresh="loadProjects"
        @delete="deleteProject"
        @edit="openEditModal"
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
import { updateProject, deleteProject as deleteProjectRequest } from '~/utils/projectApi'
import { getTechnologies } from '~/utils/technologyApi'
import { getCategories } from '~/utils/categoryApi'
import AdminProjectsList from '~/components/Admin/ProjectsList.vue'
import AdminProjectEditModal from '~/components/Admin/ProjectEditModal.vue'

definePageMeta({
  middleware: 'admin',
})

const runtimeConfig = useRuntimeConfig()

const apiBaseUrl =
  runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const projects = ref([])
const categories = ref([])
const technologies = ref([])

const message = ref(null)
const removingProjectId = ref(null)

const isEditModalOpen = ref(false)
const editingProject = ref(null)
const isUpdatingProject = ref(false)

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

const deleteProject = async (project) => {
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

const openEditModal = (project) => {
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

const closeEditModalAfterUpdate = () => {
  isEditModalOpen.value = false
  editingProject.value = null
}

const updateProjectFromModal = async form => {
  if (!editingProject.value) {
    return
  }

  isUpdatingProject.value = true
  message.value = null

  try {
    const updatedProject = await updateProject(
      editingProject.value.id,
      {
        title: form.title.trim(),
        description: form.description.trim(),
        projectLink: form.projectLink?.trim() || null,
        siteLink: form.siteLink?.trim() || null,
        categoryId: Number(form.categoryId),
        technologyIds: form.technologyIds.map(id => Number(id)),
        image: form.image,
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

    closeEditModalAfterUpdate()
  } catch (error) {
    message.value = {
      type: 'error',
      text: error instanceof Error
        ? error.message
        : 'Impossible de modifier le projet.',
    }
  } finally {
    isUpdatingProject.value = false
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