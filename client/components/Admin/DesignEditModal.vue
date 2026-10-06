<template>
  <Teleport to="body">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-200 flex items-center justify-center bg-black/50 p-4"
      @click.self="close"
    >
      <div
        class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-light shadow-2xl"
      >
        <header
          class="flex items-center justify-between border-b border-border-grey px-6 py-5"
        >
          <div>
            <h2 class="text-2xl font-bold text-dark">
              Modifier le design
            </h2>

            <p class="mt-1 text-sm text-dark/60">
              {{ design?.title || 'Design' }}
            </p>
          </div>

          <button
            type="button"
            class="flex h-10 w-10 items-center justify-center rounded-lg text-2xl text-dark/50 transition hover:bg-hover hover:text-dark"
            :disabled="isSubmitting"
            aria-label="Fermer"
            @click="close"
          >
            ×
          </button>
        </header>

        <div class="overflow-y-auto p-6">
          <DesignForm
            v-if="design"
            :key="design.id"
            :initial-value="design"
            :edit-mode="true"
            :api-base-url="apiBaseUrl"
            :is-submitting="isSubmitting"
            submit-label="Enregistrer le design"
            loading-label="Enregistrement..."
            image-label="Image"
            :image-input-id="`edit-design-image-${design.id}`"
            preview-image-label="Image de prévisualisation"
            :preview-image-input-id="`edit-design-preview-image-${design.id}`"
            @submit="submit"
          />

          <div
            v-else
            class="py-8 text-center text-sm text-dark/60"
          >
            Aucun design sélectionné.
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import DesignForm from './DesignForm.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },

  design: {
    type: Object,
    default: null,
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