<template>
  <div class="mx-auto max-w-3xl px-4 py-12">
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
      <div class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Admin</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">Ajouter un projet</h1>
      </div>

      <div v-if="message" class="mb-6 rounded-xl border px-4 py-3 text-sm" :class="message.type === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700'">
        {{ message.text }}
      </div>

      <form class="space-y-6" @submit.prevent="submitProject">
        <div>
          <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Titre</label>
          <input id="title" v-model="form.title" type="text" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
        </div>

        <div>
          <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
          <textarea id="description" v-model="form.description" rows="6" required class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100" />
        </div>

        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label for="projectLink" class="mb-2 block text-sm font-medium text-slate-700">Lien du projet</label>
            <input id="projectLink" v-model="form.projectLink" type="url" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100" placeholder="https://..." />
          </div>

          <div>
            <label for="siteLink" class="mb-2 block text-sm font-medium text-slate-700">Lien du site</label>
            <input id="siteLink" v-model="form.siteLink" type="url" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100" placeholder="https://..." />
          </div>
        </div>

        <div>
          <label for="illustration" class="mb-2 block text-sm font-medium text-slate-700">Illustration</label>
          <input id="illustration" v-model="form.illustration" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100" placeholder="/assets/img/projet.jpg" />
        </div>

        <div>
          <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
          <input id="image" type="file" accept="image/*" @change="onImageSelected" class="w-full rounded-xl border border-slate-300 px-4 py-3 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium" />
        </div>

        <div class="flex items-center justify-end gap-4">
          <button type="submit" :disabled="isSubmitting" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60">
            {{ isSubmitting ? 'Enregistrement...' : 'Enregistrer le projet' }}
          </button>
        </div>
      </form>

      <div class="mt-10 border-t border-slate-200 pt-8">
        <div class="mb-4 flex items-center justify-between gap-4">
          <h2 class="text-xl font-bold text-slate-900">Projets enregistrés</h2>
          <button type="button" @click="loadProjects" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Rafraîchir
          </button>
        </div>

        <div v-if="projects.length === 0" class="rounded-xl bg-slate-50 px-4 py-6 text-sm text-slate-500">
          Aucun projet pour le moment.
        </div>

        <ul v-else class="space-y-3">
          <li v-for="project in projects" :key="project.id" class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="font-semibold text-slate-900">{{ project.title }}</p>
                <p class="mt-1 text-sm text-slate-600">{{ project.description }}</p>
              </div>
              <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">#{{ project.id }}</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { createProject } from '~/utils/projectApi'

const runtimeConfig = useRuntimeConfig()
const apiBaseUrl = runtimeConfig.public.apiUrl || 'http://localhost:8000'

const form = ref({
  title: '',
  description: '',
  projectLink: '',
  siteLink: '',
  illustration: '',
})

const selectedImage = ref(null)
const isSubmitting = ref(false)
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

const onImageSelected = async (event) => {
  const file = event.target.files?.[0]
  if (!file) {
    selectedImage.value = null
    return
  }

  selectedImage.value = await fileToBase64(file)
}

const fileToBase64 = (file) => new Promise((resolve, reject) => {
  const reader = new FileReader()
  reader.onload = () => resolve(reader.result)
  reader.onerror = () => reject(new Error('Impossible de lire l’image.'))
  reader.readAsDataURL(file)
})

const submitProject = async () => {
  isSubmitting.value = true
  message.value = null

  try {
    const payload = {
      title: form.value.title.trim(),
      description: form.value.description.trim(),
      projectLink: form.value.projectLink.trim() || null,
      siteLink: form.value.siteLink.trim() || null,
      illustration: form.value.illustration.trim() || null,
      imageBase64: selectedImage.value || null,
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
      illustration: '',
    }
    selectedImage.value = null

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
input, textarea {
  font: inherit;
}
</style>
