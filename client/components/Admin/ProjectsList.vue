<template>
  <section class="mt-10 border-t border-slate-200 pt-8">
    <header class="mb-4 flex items-center justify-between gap-4">
      <h2 class="text-xl font-bold text-dark">Projets enregistrés</h2>
      <button type="button" @click="emit('refresh')"
        class="btn-secondary btn-sm">
        Rafraîchir
      </button>
    </header>

    <div v-if="projects.length === 0" class="rounded-xl bg-light px-4 py-6 text-sm text-dark/60">
      Aucun projet pour le moment.
    </div>

    <ul v-else class="space-y-3">
      <article v-for="project in projects" :key="project.id"
        class="rounded-xl border border-border-grey bg-light p-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
          <img v-if="getProjectImage(project)" :src="getProjectImage(project)" :alt="`Image de ${project.title}`"
            class="h-32 w-full rounded-lg object-cover sm:w-48" />

          <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-dark">{{ project.title }}</h3>
            <p class="mt-1 text-sm text-dark/70">{{ project.description }}</p>
            <p class="mt-1 text-lg"><span class="font-medium">Catégorie : </span>{{ project.category.name }}</p>
            <div v-if="project.projectLink || project.siteLink" class="mt-4 flex flex-wrap gap-3">
              <a v-if="project.projectLink" :href="project.projectLink" target="_blank" rel="noopener noreferrer"
                class="btn-secondary btn-sm">
                Code source
              </a>
              <a v-if="project.siteLink" :href="project.siteLink" target="_blank" rel="noopener noreferrer"
                class="btn-secondary btn-sm">
                Voir le site
              </a>
            </div>
          </div>
          <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">#{{ project.id
            }}</span>
          <button type="button" title="Supprimer le projet" aria-label="Supprimer le projet"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
            :disabled="removingProjectId === project.id" @click="emit('delete', project)">
            <i class="bi bi-trash" aria-hidden="true"></i>
          </button>
        </div>
      </article>
    </ul>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  projects: {
    type: Array,
    required: true,
  },
  removingProjectId: {
    type: [Number, null],
    default: null,
  },
  apiBaseUrl: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['refresh', 'delete'])

const getProjectImage = (project) => {
  if (!project.imagePath) return ''
  if (/^https?:\/\//.test(project.imagePath)) return project.imagePath
  return `${props.apiBaseUrl}${project.imagePath.startsWith('/') ? '' : '/'}${project.imagePath}`
}
</script>

<style scoped>
</style>
