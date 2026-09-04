<template>
  <main class="mx-auto max-w-3xl px-4 py-12">
    <section class="rounded-2xl border border-border-grey bg-light p-8 shadow-sm">
      <header class="flex flex-col items-center justify-between gap-4">
        <h1 class="mt-2 text-3xl font-bold text-dark">Ajouter un projet</h1>
        <NuxtLink to="/admin/projects" class="btn-primary text-sm">
          Voir l'ensemble des projets
        </NuxtLink>
      </header>

      <div v-if="message" class="mb-6 rounded-xl border px-4 py-3 text-sm"
        :class="message.type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700'">
        {{ message.text }}
      </div>

      <form class="space-y-6" @submit.prevent="submitProject">
        <div>
          <label for="title" class="mb-2 block text-sm font-medium text-dark">Titre</label>
          <input id="title" v-model="form.title" type="text" required
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover" />
        </div>

        <div>
          <label for="description" class="mb-2 block text-sm font-medium text-dark">Description</label>
          <textarea id="description" v-model="form.description" rows="6" required
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover" />
        </div>

        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label for="projectLink" class="mb-2 block text-sm font-medium text-dark">Lien du projet</label>
            <input id="projectLink" v-model="form.projectLink" type="url"
              class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
              placeholder="https://..." />
          </div>

          <div>
            <label for="siteLink" class="mb-2 block text-sm font-medium text-dark">Lien du site</label>
            <input id="siteLink" v-model="form.siteLink" type="url"
              class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
              placeholder="https://..." />
          </div>
        </div>

        <div>
          <label for="category" class="mb-2 block text-sm font-medium text-dark">
            Catégorie
          </label>

          <select id="category" v-model="form.categoryId" required
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover">
            <option value="" disabled>
              Sélectionner une catégorie
            </option>

            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <div>
          <label for="image" class="mb-2 block text-sm font-medium text-dark">Image</label>
          <input id="image" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" @change="onImageSelected"
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark file:mr-4 file:rounded-md file:border-0 file:bg-light file:px-3 file:py-2 file:text-sm file:font-medium" />
        </div>

        <div class="flex items-center justify-end gap-4">
          <button type="submit" :disabled="isSubmitting"
            class="btn-primary btn-sm disabled:cursor-not-allowed disabled:opacity-60">
            {{ isSubmitting ? 'Enregistrement...' : 'Enregistrer le projet' }}
          </button>
        </div>
      </form>

      <AdminProjectsList :projects="projects" :removing-project-id="removingProjectId" :api-base-url="apiBaseUrl"
        @refresh="loadProjects" @delete="deleteProject" />

      <div class="mb-2 flex items-end gap-2">
        <div class="flex-1">
          <label for="newCategory" class="mb-2 block text-sm font-medium text-dark">
            Nouvelle catégorie
          </label>

          <input id="newCategory" v-model="newCategoryName" type="text" placeholder="Ex: E-commerce"
            class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover" />
        </div>

        <button type="button" :disabled="isCreatingCategory || !newCategoryName.trim()"
          class="btn-primary btn-sm disabled:cursor-not-allowed disabled:opacity-60" @click="createCategory">
          {{ isCreatingCategory ? '...' : 'Ajouter' }}
        </button>
      </div>
    </section>
  </main>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { createProject, deleteProject as deleteProjectRequest } from '~/utils/projectApi'
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
  categoryId: '',
})

const selectedImageFile = ref(null)
const isSubmitting = ref(false)
const removingProjectId = ref(null)
const message = ref(null)
const projects = ref([])
const categories = ref([])
const newCategoryName = ref('')
const isCreatingCategory = ref(false)

//Charger les projets
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

//Supprimer les projets
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

//Charger les catégories
const loadCategories = async () => {
  try {
    const response = await fetch(`${apiBaseUrl}/admin/categories`, {
      headers: {
        Accept: 'application/json',
      },
    })

    if (!response.ok) {
      throw new Error('Impossible de charger les catégories')
    }

    categories.value = await response.json()
  } catch (error) {
    console.error('Erreur chargement catégories:', error)
  }
}

//Créer des catégories
const createCategory = async () => {
  const name = newCategoryName.value.trim()

  if (!name) return

  isCreatingCategory.value = true

  try {
    const formData = new FormData()
    formData.append('description', name)

    const response = await fetch(`${apiBaseUrl}/api/categories/submit`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      credentials: 'include',
      body: formData,
    })

    const data = await response.json()

    if (!response.ok) {
      throw new Error(
        data.error || 'Impossible de créer la catégorie'
      )
    }

    const category = {
      id: data.id,
      name: data.title,
    }

    categories.value.push(category)
    form.value.categoryId = category.id
    newCategoryName.value = ''
  } catch (error) {
    message.value = {
      type: 'error',
      text: error instanceof Error
        ? error.message
        : 'Impossible de créer la catégorie.',
    }
  } finally {
    isCreatingCategory.value = false
  }
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
      categoryId: form.value.categoryId,
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
  loadCategories()
})
</script>

<style scoped></style>
