<template>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <Tool 
            v-for="(tool, index) in tools" 
            :key="index" 
            :icon="tool.icon" 
            :label="tool.label" 
        />
    </div>
</template>

<script setup>
import Tool from './Tool.vue'

const tools = [
    {
        icon: '/assets/icons/laravel.svg',
        label: 'Laravel'
    },
    {
        icon: '/assets/icons/vuejs.svg',
        label: 'Vue.js'
    },
    {
        icon: '/assets/icons/tailwindcss.svg',
        label: 'Tailwind CSS'
    },
    {
        icon: '/assets/icons/figma.svg',
        label: 'Figma'
    },
    {
        icon: '/assets/icons/github.svg',
        label: 'GitHub'
    },
    {
        icon: '/assets/icons/wordpress.svg',
        label: 'WordPress'
    }
]
</script>

<style scoped>

</style>