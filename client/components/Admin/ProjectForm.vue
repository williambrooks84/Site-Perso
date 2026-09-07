<template>
  <form class="space-y-6" @submit.prevent="submit">
    <div>
      <label
        for="project-title"
        class="mb-2 block text-sm font-medium text-dark"
      >
        Titre
      </label>

      <input
        id="project-title"
        v-model="form.title"
        type="text"
        required
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
      />
    </div>

    <div>
      <label
        for="project-description"
        class="mb-2 block text-sm font-medium text-dark"
      >
        Description
      </label>

      <textarea
        id="project-description"
        v-model="form.description"
        rows="6"
        required
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
      ></textarea>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
      <div>
        <label
          for="project-link"
          class="mb-2 block text-sm font-medium text-dark"
        >
          Lien du projet
        </label>

        <input
          id="project-link"
          v-model="form.projectLink"
          type="url"
          class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
          placeholder="https://..."
        />
      </div>

      <div>
        <label
          for="site-link"
          class="mb-2 block text-sm font-medium text-dark"
        >
          Lien du site
        </label>

        <input
          id="site-link"
          v-model="form.siteLink"
          type="url"
          class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
          placeholder="https://..."
        />
      </div>
    </div>

    <div>
      <label
        for="project-category"
        class="mb-2 block text-sm font-medium text-dark"
      >
        Catégorie
      </label>

      <select
        id="project-category"
        v-model="form.categoryId"
        required
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark outline-none transition focus:border-primary focus:ring-2 focus:ring-hover"
      >
        <option value="" disabled>
          Sélectionner une catégorie
        </option>

        <option
          v-for="category in categories"
          :key="category.id"
          :value="String(category.id)"
        >
          {{ category.name }}
        </option>
      </select>
    </div>

    <div>
      <label class="mb-2 block text-sm font-medium text-dark">
        Technologies
      </label>

      <div class="relative">
        <button
          type="button"
          class="flex min-h-[52px] w-full items-center justify-between gap-3 rounded-xl border border-border-grey bg-light px-4 py-3 text-left text-dark outline-none transition hover:border-primary focus:border-primary focus:ring-2 focus:ring-hover"
          @click="showTechnologyDropdown = !showTechnologyDropdown"
        >
          <span
            v-if="form.technologyIds.length === 0"
            class="text-sm text-dark/50"
          >
            Sélectionner les technologies
          </span>

          <div
            v-else
            class="flex flex-1 flex-wrap gap-2"
          >
            <span
              v-for="technologyId in form.technologyIds"
              :key="technologyId"
              class="flex items-center gap-2 rounded-lg border border-border-grey bg-light px-2.5 py-1.5"
            >
              <img
                v-if="getTechnologyIcon(technologyId)"
                :src="getTechnologyIcon(technologyId)"
                :alt="getTechnologyName(technologyId)"
                class="h-5 w-5 object-contain"
              />

              <span class="text-sm font-medium text-dark">
                {{ getTechnologyName(technologyId) }}
              </span>

              <span
                class="cursor-pointer text-dark/40 transition hover:text-red-500"
                @click.stop="toggleTechnology(technologyId)"
              >
                ×
              </span>
            </span>
          </div>

          <span
            class="shrink-0 text-dark/50 transition"
            :class="{
              'rotate-180': showTechnologyDropdown,
            }"
          >
            ⌄
          </span>
        </button>

        <div
          v-if="showTechnologyDropdown"
          class="absolute left-0 top-full z-[210] mt-2 w-full rounded-xl border border-border-grey bg-light p-2 shadow-xl"
        >
          <div class="max-h-64 overflow-y-auto">
            <button
              v-for="technology in technologies"
              :key="technology.id"
              type="button"
              class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-dark transition hover:bg-hover"
              :class="{
                'bg-light': form.technologyIds.includes(
                  Number(technology.id)
                ),
              }"
              @click="toggleTechnology(technology.id)"
            >
              <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-border-grey bg-light"
              >
                <img
                  v-if="getTechnologyIconUrl(technology)"
                  :src="getTechnologyIconUrl(technology)"
                  :alt="technology.name"
                  class="h-6 w-6 object-contain"
                />
              </span>

              <span class="flex-1 text-sm font-medium">
                {{ technology.name }}
              </span>

              <span
                v-if="
                  form.technologyIds.includes(
                    Number(technology.id)
                  )
                "
                class="flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs text-white"
              >
                ✓
              </span>
            </button>

            <div
              v-if="technologies.length === 0"
              class="px-3 py-4 text-center text-sm text-dark/50"
            >
              Aucune technologie disponible.
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <label
        :for="imageInputId"
        class="mb-2 block text-sm font-medium text-dark"
      >
        {{ imageLabel }}
      </label>

      <input
        :id="imageInputId"
        type="file"
        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        class="w-full rounded-xl border border-border-grey bg-light px-4 py-3 text-dark file:mr-4 file:rounded-md file:border-0 file:bg-light file:px-3 file:py-2 file:text-sm file:font-medium"
        @change="onImageSelected"
      />

      <p
        v-if="editMode"
        class="mt-2 text-xs text-dark/50"
      >
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
      projectLink: '',
      siteLink: '',
      categoryId: '',
      technologyIds: [],
    }),
  },
  categories: {
    type: Array,
    default: () => [],
  },
  technologies: {
    type: Array,
    default: () => [],
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
    default: 'project-image',
  },
})

const emit = defineEmits(['submit'])

const showTechnologyDropdown = ref(false)
const selectedImageFile = ref(null)

const createEmptyForm = () => ({
  title: '',
  description: '',
  projectLink: '',
  siteLink: '',
  categoryId: '',
  technologyIds: [],
})

const normalizeForm = value => ({
  title: value?.title || '',
  description: value?.description || '',
  projectLink: value?.projectLink || '',
  siteLink: value?.siteLink || '',
  categoryId: value?.categoryId
    ? String(value.categoryId)
    : '',
  technologyIds: Array.isArray(value?.technologyIds)
    ? value.technologyIds.map(id => Number(id))
    : [],
})

const form = ref(normalizeForm(props.initialValue))

const resetForm = () => {
  form.value = createEmptyForm()
  selectedImageFile.value = null
  showTechnologyDropdown.value = false

  const input = document.getElementById(props.imageInputId)

  if (input) {
    input.value = ''
  }
}

const setInitialValue = value => {
  form.value = normalizeForm(value)
  selectedImageFile.value = null
  showTechnologyDropdown.value = false

  const input = document.getElementById(props.imageInputId)

  if (input) {
    input.value = ''
  }
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

const toggleTechnology = technologyId => {
  const id = Number(technologyId)

  if (form.value.technologyIds.includes(id)) {
    form.value.technologyIds =
      form.value.technologyIds.filter(
        technologyId => technologyId !== id
      )
  } else {
    form.value.technologyIds = [
      ...form.value.technologyIds,
      id,
    ]
  }
}

const getTechnologyName = technologyId => {
  return (
    props.technologies.find(
      technology =>
        Number(technology.id) === Number(technologyId)
    )?.name || ''
  )
}

const getTechnologyIconUrl = technology => {
  if (!technology) {
    return ''
  }

  const icon = technology.icon || technology.iconPath

  if (!icon) {
    return ''
  }

  if (/^https?:\/\//.test(icon)) {
    return icon
  }

  return `${props.apiBaseUrl}${icon.startsWith('/') ? '' : '/'}${icon}`
}

const getTechnologyIcon = technologyId => {
  const technology = props.technologies.find(
    technology =>
      Number(technology.id) === Number(technologyId)
  )

  return getTechnologyIconUrl(technology)
}

const submit = () => {
  emit('submit', {
    ...form.value,
    categoryId: Number(form.value.categoryId),
    technologyIds: form.value.technologyIds.map(
      id => Number(id)
    ),
    image: selectedImageFile.value,
  })
}
</script>