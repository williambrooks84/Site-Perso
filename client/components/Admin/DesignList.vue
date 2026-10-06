<template>
  <section class="mt-10 border-t border-slate-200 pt-8">
    <header class="mb-4 flex items-center justify-between gap-4">
      <h2 class="text-xl font-bold text-dark">
        Designs enregistrés
      </h2>

      <button
        type="button"
        class="btn-secondary btn-sm"
        @click="emit('refresh')"
      >
        Rafraîchir
      </button>
    </header>

    <div
      v-if="designs.length === 0"
      class="rounded-xl bg-light px-4 py-6 text-sm text-dark/60"
    >
      Aucun design pour le moment.
    </div>

    <ul v-else class="space-y-3">
      <li
        v-for="design in designs"
        :key="design.id"
        class="rounded-xl border border-border-grey bg-light p-4"
      >
        <div
          class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
        >
          <!-- Illustration -->
          <img
            v-if="getDesignImage(design)"
            :src="getDesignImage(design)"
            :alt="`Image de ${design.title}`"
            class="h-32 w-full shrink-0 rounded-lg object-cover sm:w-48"
          />

          <!-- Design information -->
          <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-dark">
              {{ design.title }}
            </h3>

            <p class="mt-1 text-sm text-dark/70">
              {{ design.description }}
            </p>

            <!-- Preview -->
            <div class="mt-4">
              <DesignPreview
                v-if="getDesignPreviewImage(design)"
                :src="getDesignPreviewImage(design)"
                :alt="`Aperçu de ${design.title}`"
              >
                <span
                  class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-white transition hover:opacity-90"
                >
                  <i
                    class="bi bi-eye"
                    aria-hidden="true"
                  ></i>

                  Aperçu
                </span>
              </DesignPreview>

              <span
                v-else
                class="text-sm text-dark/50"
              >
                Aucun aperçu disponible
              </span>
            </div>
          </div>

          <!-- Design ID -->
          <span
            class="shrink-0 rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700"
          >
            #{{ design.id }}
          </span>

          <!-- Actions -->
          <div class="flex shrink-0 items-center gap-2">
            <!-- Edit -->
            <button
              type="button"
              title="Modifier le design"
              aria-label="Modifier le design"
              class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white transition hover:opacity-90"
              @click="emit('edit', design)"
            >
              <i
                class="bi bi-pencil"
                aria-hidden="true"
              ></i>
            </button>

            <!-- Delete -->
            <button
              type="button"
              title="Supprimer le design"
              aria-label="Supprimer le design"
              class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-600 text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
              :disabled="removingDesignId === design.id"
              @click="emit('delete', design)"
            >
              <i
                class="bi bi-trash"
                aria-hidden="true"
              ></i>
            </button>
          </div>
        </div>
      </li>
    </ul>
  </section>
</template>

<script setup>
import DesignPreview from '~/components/Portfolio/DesignPreview.vue'

const props = defineProps({
  designs: {
    type: Array,
    required: true,
  },

  removingDesignId: {
    type: [Number, null],
    default: null,
  },

  apiBaseUrl: {
    type: String,
    required: true,
  },
})

const emit = defineEmits([
  'refresh',
  'delete',
  'edit',
])

const getImageUrl = path => {
  if (!path) {
    return ''
  }

  if (/^https?:\/\//i.test(path)) {
    return path
  }

  return `${props.apiBaseUrl}${path.startsWith('/') ? '' : '/'}${path}`
}

const getDesignImage = design => {
  return getImageUrl(design?.imagePath)
}

const getDesignPreviewImage = design => {
  return getImageUrl(design?.previewPath)
}
</script>

<style scoped>
</style>