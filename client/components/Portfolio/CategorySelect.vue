<template>
    <div
        ref="dropdownRef"
        class="relative w-full"
    >
        <!-- Trigger -->
        <button
            type="button"
            class="btn-primary relative flex w-full items-center justify-center rounded-lg px-4 py-3 font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50"

            :aria-expanded="isOpen"
            aria-haspopup="listbox"
            @click="isOpen = !isOpen"
        >
            <span>
                {{ selectedCategory?.name ?? allLabel }}
            </span>

            <i
                class="bi absolute right-4 text-sm transition-transform duration-200"
                :class="
                    isOpen
                        ? 'bi-chevron-up'
                        : 'bi-chevron-down'
                "
            ></i>
        </button>

        <!-- Dropdown -->
        <Transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="translate-y-[-4px] opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-[-4px] opacity-0"
        >
            <div
                v-show="isOpen"
                class="absolute left-0 top-10 z-50 mt-2 w-full overflow-hidden rounded-b-lg bg-primary p-1 shadow-xl ring-1 ring-black/10"
                role="listbox"
            >
                <!-- Tous -->
                <button
                    type="button"
                    class="flex w-full items-center justify-between rounded-md px-4 py-3 text-center transition-colors duration-150"
                    :class="
                        selectedCategoryId === null
                            ? 'bg-light/15 text-light'
                            : 'text-light hover:bg-secondary'
                    "
                    role="option"
                    :aria-selected="selectedCategoryId === null"
                    @click="selectCategory(null)"
                >
                    <span class="flex-1 text-center uppercase">
                        {{ allLabel }}
                    </span>

                    <i
                        v-if="selectedCategoryId === null"
                        class="bi bi-check-lg"
                    ></i>

                    <span v-else class="w-4"></span>
                </button>

                <!-- Categories -->
                <button
                    v-for="category in categories"
                    :key="category.id"
                    type="button"
                    class="flex w-full items-center justify-between rounded-md px-4 py-3 text-center transition-colors duration-150"
                    :class="
                        selectedCategoryId === category.id
                            ? 'bg-light/15 text-light'
                            : 'text-light hover:bg-secondary'
                    "
                    role="option"
                    :aria-selected="
                        selectedCategoryId === category.id
                    "
                    @click="selectCategory(category.id)"
                >
                    <span class="flex-1 text-center uppercase">
                        {{ category.name }}
                    </span>

                    <i
                        v-if="
                            selectedCategoryId ===
                            category.id
                        "
                        class="bi bi-check-lg"
                    ></i>

                    <span v-else class="w-4"></span>
                </button>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [Number, String],
        default: null,
    },
    allLabel: {
        type: String,
        default: 'Tous',
    },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const dropdownRef = ref(null)

const selectedCategoryId = computed(() => props.modelValue)

const selectedCategory = computed(() => {
    return props.categories.find(
        (category) => category.id === props.modelValue
    )
})

const selectCategory = (categoryId) => {
    emit('update:modelValue', categoryId)
    isOpen.value = false
}

const handleClickOutside = (event) => {
    if (
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target)
    ) {
        isOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>