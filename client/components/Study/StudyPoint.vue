<template>
    <div class="space-y-8 mt-15 flex flex-col items-center">
        <div class="flex flex-col gap-5">
            <div>
                <h3>{{ name }} <small>({{ year }})</small></h3>
                <p class="text-2xl font-medium text-secondary"> {{ type }}</p>
            </div>
            <p class="body-text text-justify">
                {{ content }}
            </p>
        </div>
        <client-only>
            <img v-if="displayImage" :src="displayImage" :alt="name" class="w-100 h-auto" />
        </client-only>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useTheme } from '~/composables/useTheme.js'

const props = defineProps({
    name: { type: String, required: true },
    year: { type: String, required: true },
    type: { type: String, required: false },
    content: { type: String, required: true },
    image: { type: String, required: false },
    imageDark: { type: String, required: false }
})

const { isDark } = useTheme()

const displayImage = computed(() => {
    return isDark.value && props.imageDark ? props.imageDark : props.image
})
</script>

<style scoped></style>