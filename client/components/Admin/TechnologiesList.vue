<template>
  <section class="mt-10 border-t border-slate-200 pt-8">
    <header class="mb-4 flex items-center justify-between gap-4">
      <h2 class="text-xl font-bold text-dark">Technologies enregistrées</h2>

      <button
        type="button"
        @click="emit('refresh')"
        class="btn-secondary btn-sm"
      >
        Rafraîchir
      </button>
    </header>

    <div
      v-if="technologies.length === 0"
      class="rounded-xl bg-light px-4 py-6 text-sm text-dark/60"
    >
      Aucune technologie pour le moment.
    </div>

    <ul v-else class="space-y-3">
      <article
        v-for="technology in technologies"
        :key="technology.id"
        class="rounded-xl border border-border-grey bg-light p-4"
      >
        <div class="flex items-center gap-4">
          <!-- SVG icon -->
          <img
            v-if="getTechnologyIcon(technology)"
            :src="getTechnologyIcon(technology)"
            :alt="`Icône ${technology.name}`"
            class="h-16 w-16 shrink-0 object-contain"
          />

          <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-dark">
              {{ technology.name }}
            </h3>
          </div>

          <span
            class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700"
          >
            #{{ technology.id }}
          </span>

          <button
            type="button"
            title="Supprimer la technologie"
            aria-label="Supprimer la technologie"
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-600 text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
            :disabled="removingTechnologyId === technology.id"
            @click="emit('delete', technology)"
          >
            <i class="bi bi-trash" aria-hidden="true"></i>
          </button>
        </div>
      </article>
    </ul>
  </section>
</template>

<script setup>
const props = defineProps({ technologies: { type: Array, required: true, }, removingTechnologyId: { type: [Number, String], default: null, }, apiBaseUrl: { type: String, required: true, }, })

const emit = defineEmits(['refresh', 'delete'])

const getTechnologyIcon = (technology) => {
  if (!technology.iconPath) return ''

  if (/^https?:\/\//.test(technology.iconPath)) {
    return technology.iconPaths
  }

  return `${props.apiBaseUrl}${technology.iconPath.startsWith('/') ? '' : '/'}${technology.iconPath}`
}


</script>

<style scoped>
</style>