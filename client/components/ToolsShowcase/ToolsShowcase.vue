<template>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-8">
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
        icon: '/assets/icons/tools/aftereffects.svg',
        label: 'After Effects'
    },
    {
        icon: '/assets/icons/tools/bootstrap.svg',
        label: 'Bootstrap'
    },
    {
        icon: '/assets/icons/tools/copilot.svg',
        label: 'Copilot'
    },
    {
        icon: '/assets/icons/tools/css.svg',
        label: 'CSS'
    },
    {
        icon: '/assets/icons/tools/docker.svg',
        label: 'Docker'
    },
    {
        icon: '/assets/icons/tools/doctrine.svg',
        label: 'Doctrine'
    },
    {
        icon: '/assets/icons/tools/figma.svg',
        label: 'Figma'
    },
    {
        icon: '/assets/icons/tools/filezilla.svg',
        label: 'FileZilla'
    },
    {
        icon: '/assets/icons/tools/github.svg',
        label: 'GitHub'
    },
    {
        icon: '/assets/icons/tools/html.svg',
        label: 'HTML'
    },
    {
        icon: '/assets/icons/tools/illustrator.svg',
        label: 'Illustrator'
    },
    {
        icon: '/assets/icons/tools/js.svg',
        label: 'JavaScript'
    },
    {
        icon: '/assets/icons/tools/lightroom.svg',
        label: 'Lightroom'
    },
    {
        icon: '/assets/icons/tools/linux.svg',
        label: 'Linux'
    },
    {
        icon: '/assets/icons/tools/nodejs.svg',
        label: 'Node.js'
    },
    {
        icon: '/assets/icons/tools/nuxt.svg',
        label: 'Nuxt'
    },
    {
        icon: '/assets/icons/tools/photoshop.svg',
        label: 'Photoshop'
    },
    {
        icon: '/assets/icons/tools/php.svg',
        label: 'PHP'
    },
    {
        icon: '/assets/icons/tools/postman.svg',
        label: 'Postman'
    },
    {
        icon: '/assets/icons/tools/premiere.svg',
        label: 'Premiere'
    },
    {
        icon: '/assets/icons/tools/react.svg',
        label: 'React'
    },
    {
        icon: '/assets/icons/tools/skill-icons_sass.svg',
        label: 'Sass'
    },
    {
        icon: '/assets/icons/tools/symfony.svg',
        label: 'Symfony'
    },
    {
        icon: '/assets/icons/tools/tailwindcss.svg',
        label: 'Tailwind CSS'
    },
    {
        icon: '/assets/icons/tools/typescript.svg',
        label: 'TypeScript'
    },
    {
        icon: '/assets/icons/tools/vitejs.svg',
        label: 'Vite'
    },
    {
        icon: '/assets/icons/tools/vscode.svg',
        label: 'VS Code'
    },
    {
        icon: '/assets/icons/tools/vuejs.svg',
        label: 'Vue.js'
    }
]
</script>

<style scoped>

</style>