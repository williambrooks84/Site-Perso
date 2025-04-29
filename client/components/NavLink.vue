<template>
    <a 
        :href="href || '#'" 
        class="text-gray-700 uppercase transition hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7"
    >
        {{name}}
    </a>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps({
    href: String,
    name: String,
})
</script>

<style scoped>
@import "tailwindcss";
@import "@nuxt/ui";
</style>