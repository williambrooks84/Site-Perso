<template>
  <form class="space-y-6" @submit.prevent="submit">
    <div>
      <label for="design-title" class="mb-2 block text-sm font-medium text-dark">
        Titre
      </label>

      <input
        id="design-title"
        v-model="form.title"
        type="text"
        required
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
      />
    </div>

    <div>
      <label for="design-description" class="mb-2 block text-sm font-medium text-dark">
        Description
      </label>

      <textarea
        id="design-description"
        v-model="form.description"
        rows="6"
        required
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
      ></textarea>
    </div>

    <div>
      <label :for="imageInputId" class="mb-2 block text-sm font-medium text-dark">
        {{ imageLabel }}
      </label>

      <input
        :id="imageInputId"
        type="file"
        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark file:mr-4 file:rounded-md file:border-0 file:bg-light file:px-3 file:py-2 file:text-sm file:font-medium"
        @change="onImageSelected"
      />

      <p v-if="editMode" class="mt-2 text-xs text-dark/50">
        Laissez vide pour conserver l’image actuelle.
      </p>
    </div>

    <div>
      <label :for="previewImageInputId" class="mb-2 block text-sm font-medium text-dark">
        {{ previewImageLabel }}
      </label>

      <input
        :id="previewImageInputId"
        type="file"
        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark file:mr-4 file:rounded-md file:border-0 file:bg-light file:px-3 file:py-2 file:text-sm file:font-medium"
        @change="onPreviewImageSelected"
      />

      <p v-if="editMode" class="mt-2 text-xs text-dark/50">
        Laissez vide pour conserver l’image actuelle.
      </p>
    </div>

    <div class="flex items-center justify-end gap-4">
      <button
        type="submit"
        :disabled="isSubmitting"
        class="btn-primary btn-sm disabled:cursor-not-allowed disabled:opacity-60"
      >
        {{ isSubmitting ? loadingLabel : submitLabel }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  resetKey: {
    type: Number,
    default: 0,
  },

  initialValue: {
    type: Object,
    default: () => ({
      title: '',
      description: '',
    }),
  },

  apiBaseUrl: {
    type: String,
    required: true,
  },

  isSubmitting: {
    type: Boolean,
    default: false,
  },

  editMode: {
    type: Boolean,
    default: false,
  },

  submitLabel: {
    type: String,
    default: 'Enregistrer le projet',
  },

  loadingLabel: {
    type: String,
    default: 'Enregistrement...',
  },

  imageLabel: {
    type: String,
    default: 'Image',
  },

  imageInputId: {
    type: String,
    default: 'design-image',
  },

  previewImageLabel: {
    type: String,
    default: 'Image de prévisualisation',
  },

  previewImageInputId: {
    type: String,
    default: 'design-preview-image',
  },
})

const emit = defineEmits(['submit'])

const selectedImageFile = ref(null)
const selectedPreviewImageFile = ref(null)

const createEmptyForm = () => ({
  title: '',
  description: '',
})

const normalizeForm = value => ({
  title: value?.title || '',
  description: value?.description || '',
})

const form = ref(normalizeForm(props.initialValue))

const clearFileInputs = () => {
  const imageInput = document.getElementById(props.imageInputId)
  const previewImageInput = document.getElementById(props.previewImageInputId)

  if (imageInput) {
    imageInput.value = ''
  }

  if (previewImageInput) {
    previewImageInput.value = ''
  }
}

const resetForm = () => {
  form.value = createEmptyForm()

  selectedImageFile.value = null
  selectedPreviewImageFile.value = null

  clearFileInputs()
}

const setInitialValue = value => {
  form.value = normalizeForm(value)

  selectedImageFile.value = null
  selectedPreviewImageFile.value = null

  clearFileInputs()
}

watch(
  () => props.resetKey,
  (newValue, oldValue) => {
    if (
      newValue !== oldValue &&
      !props.editMode
    ) {
      resetForm()
    }
  }
)

watch(
  () => props.initialValue,
  value => {
    if (props.editMode) {
      setInitialValue(value)
    }
  },
  { deep: true }
)

const onImageSelected = event => {
  const file = event.target.files?.[0]

  if (!file) {
    selectedImageFile.value = null
    return
  }

  const isImage =
    file.type === 'image/jpeg' ||
    file.type === 'image/png' ||
    file.name.toLowerCase().endsWith('.jpg') ||
    file.name.toLowerCase().endsWith('.jpeg') ||
    file.name.toLowerCase().endsWith('.png')

  if (!isImage) {
    selectedImageFile.value = null
    event.target.value = ''
    return
  }

  if (file.size > 10 * 1024 * 1024) {
    selectedImageFile.value = null
    event.target.value = ''
    return
  }

  selectedImageFile.value = file
}

const onPreviewImageSelected = event => {
  const file = event.target.files?.[0]

  if (!file) {
    selectedPreviewImageFile.value = null
    return
  }

  const isImage =
    file.type === 'image/jpeg' ||
    file.type === 'image/png' ||
    file.name.toLowerCase().endsWith('.jpg') ||
    file.name.toLowerCase().endsWith('.jpeg') ||
    file.name.toLowerCase().endsWith('.png')

  if (!isImage) {
    selectedPreviewImageFile.value = null
    event.target.value = ''
    return
  }

  if (file.size > 20 * 1024 * 1024) {
    selectedPreviewImageFile.value = null
    event.target.value = ''
    return
  }

  selectedPreviewImageFile.value = file
}

const submit = () => {
  emit('submit', {
    title: form.value.title,
    description: form.value.description,
    image: selectedImageFile.value,
    previewImage: selectedPreviewImageFile.value,
  })
}
</script>