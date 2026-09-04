<template>
  <main class="mx-auto max-w-3xl px-4 py-12">
    <section class="rounded-2xl border border-border-grey bg-light p-8 shadow-sm">
      <header class="flex flex-col items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-dark">Administration des projets</h1>
        <NuxtLink to="/admin/projects/new"
          class="btn-primary text-sm">
          Ajouter un projet
        </NuxtLink>
      </header>

      <div v-if="message" class="mb-6 rounded-xl border px-4 py-3 text-sm"
        :class="message.type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700'">
        {{ message.text }}
      </div>

      <AdminProjectsList 
        :projects="projects"
        :removing-project-id="removingProjectId"
        :api-base-url="apiBaseUrl"
        @refresh="loadProjects"
        @delete="deleteProject"
      />
    </section>
  </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { deleteProject as deleteProjectRequest } from '~/utils/projectApi'
import AdminProjectsList from '~/components/Admin/ProjectsList.vue'

definePageMeta({
  middleware: 'admin',
})

const runtimeConfig = useRuntimeConfig()
const apiBaseUrl = runtimeConfig.public.apiUrl || 'https://api.willbrooks.fr'

const form = ref({
  title: '',
  description: '',
  projectLink: '',
  siteLink: '',
})

const selectedImageFile = ref(null)
const isSubmitting = ref(false)
const removingProjectId = ref(null)
const message = ref(null)
const projects = ref([])

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

const deleteProject = async (project) => {
  if (!window.confirm(`Supprimer le projet « ${project.title} » ?`)) return

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
      text: error instanceof Error ? error.message : 'Impossible de supprimer le projet.',
    }
  } finally {
    removingProjectId.value = null
  }
}

const onImageSelected = (event) => {
  const file = event.target.files?.[0]
  if (!file) {
    selectedImageFile.value = null
    return
  }

  if (file.size > 10 * 1024 * 1024) {
    selectedImageFile.value = null
    event.target.value = ''
    message.value = {
      type: 'error',
      text: 'L’image ne doit pas dépasser 10 Mo.',
    }
    return
  }

  selectedImageFile.value = file
}

const submitProject = async () => {
  isSubmitting.value = true
  message.value = null

  try {
    const payload = {
      title: form.value.title.trim(),
      description: form.value.description.trim(),
      projectLink: form.value.projectLink.trim() || null,
      siteLink: form.value.siteLink.trim() || null,
      image: selectedImageFile.value,
    }

    await createProject(payload, apiBaseUrl)

    message.value = {
      type: 'success',
      text: 'Le projet a bien été créé.',
    }

    form.value = {
      title: '',
      description: '',
      projectLink: '',
      siteLink: '',
    }
    selectedImageFile.value = null

    const input = document.getElementById('image')
    if (input) input.value = ''

    await loadProjects()
  } catch (error) {
    message.value = {
      type: 'error',
      text: error instanceof Error ? error.message : 'Une erreur est survenue.',
    }
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  loadProjects()
})
</script>

<style scoped>
input,
textarea {
  font: inherit;
}
</style>
