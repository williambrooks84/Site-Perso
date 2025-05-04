<template>
    <a 
        :href="href || '#'" 
        class="text-light text-xl font-semibold uppercase hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover px-3 py-2 rounded transition"
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

</style>