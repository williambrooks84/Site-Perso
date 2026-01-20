<template>
    <div class="space-y-8 mt-15">
        <h2>Mon environnement technique</h2>

        <div class="flex flex-col gap-30 pb-20">
            <div class="flex flex-col gap-5">
                <h3>Développement :</h3>

                <div class="flex flex-col gap-5">
                    <h4>Langages</h4>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Tool v-for="(devTool, index) in devTools.languages" :key="`lang-${index}`" :icon="devTool.icon"
                            :label="devTool.label" class="w-1/4 xl:w-1/8" />
                    </div>
                </div>

                <div class="flex flex-col gap-5">
                    <h4>Frameworks</h4>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Tool v-for="(devTool, index) in devTools.frameworks" :key="`fw-${index}`" :icon="devTool.icon"
                            :label="devTool.label" class="w-1/4 xl:w-1/8" />
                    </div>
                </div>

                <div class="flex flex-col gap-5">
                    <h4>Outils & environnements</h4>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Tool v-for="(devTool, index) in devTools.tools" :key="`tool-${index}`" :icon="devTool.icon"
                            :label="devTool.label" class="w-1/4 xl:w-1/8" />
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-5">
                <h3>Design et graphisme :</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    <Tool v-for="(designTool, index) in designTools" :key="index" :icon="designTool.icon"
                        :label="designTool.label" class="w-1/4 xl:w-1/8" />
                </div>
            </div>

            <div class="flex flex-col gap-5">
                <h3>En cours d'acquisition :</h3>

                <div class="flex flex-col gap-5">
                    <h4>Technologies & frameworks</h4>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Tool v-for="(pendingTool, index) in pendingTools.tech" :key="`pending-tech-${index}`"
                            :icon="pendingTool.icon" :label="pendingTool.label" class="w-1/4 xl:w-1/8" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-3 pb-20">
            <p class="body-text">Vous souhaitez voir mes compétences mises en application ?</p>
            <a href="/portfolio" class="btn-primary">
                Consultez mes projets
            </a>
        </div>
    </div>
</template>

<script setup>
import Tool from './Tool.vue'

const devTools = {
    languages: [
        { icon: '/assets/icons/tools/html.svg', label: 'HTML' },
        { icon: '/assets/icons/tools/css.svg', label: 'CSS' },
        { icon: '/assets/icons/tools/js.svg', label: 'JavaScript' },
        { icon: '/assets/icons/tools/typescript.svg', label: 'TypeScript' },
        { icon: '/assets/icons/tools/php.svg', label: 'PHP' },
    ],
    frameworks: [
        { icon: '/assets/icons/tools/tailwindcss.svg', label: 'Tailwind CSS' },
        { icon: '/assets/icons/tools/react.svg', label: 'React' },
        { icon: '/assets/icons/tools/nextjs.svg', label: 'Next.js' },
        { icon: '/assets/icons/tools/nuxt.svg', label: 'Nuxt' },
        { icon: '/assets/icons/tools/symfony.svg', label: 'Symfony' },
    ],
    tools: [
        { icon: '/assets/icons/tools/github.svg', label: 'GitHub' },
        { icon: '/assets/icons/tools/vscode.svg', label: 'VS Code' },
        { icon: '/assets/icons/tools/docker.svg', label: 'Docker' },
        { icon: '/assets/icons/tools/filezilla.svg', label: 'FileZilla' },
        { icon: '/assets/icons/tools/linux.svg', label: 'Linux' },
        { icon: '/assets/icons/tools/postman.svg', label: 'Postman' },
        { icon: '/assets/icons/tools/copilot.svg', label: 'Copilot' },
    ],
}

const pendingTools = {
    tech: [
        { icon: '/assets/icons/tools/sass.svg', label: 'Sass' },
        { icon: '/assets/icons/tools/bootstrap.svg', label: 'Bootstrap' },
        { icon: '/assets/icons/tools/flutter.svg', label: 'Flutter' },
        { icon: '/assets/icons/tools/dart.svg', label: 'Dart' },
        { icon: '/assets/icons/tools/nodejs.svg', label: 'Node.js' },
        { icon: '/assets/icons/tools/mongodb.svg', label: 'MongoDB' }, { icon: '/assets/icons/tools/wordpress.svg', label: 'Wordpress' },
    ],
}

const designTools = [
    { icon: '/assets/icons/tools/figma.svg', label: 'Figma' },
    { icon: '/assets/icons/tools/lightroom.svg', label: 'Lightroom' },
    { icon: '/assets/icons/tools/illustrator.svg', label: 'Illustrator' },
    { icon: '/assets/icons/tools/photoshop.svg', label: 'Photoshop' },
    { icon: '/assets/icons/tools/premiere.svg', label: 'Premiere Pro' },
    { icon: '/assets/icons/tools/aftereffects.svg', label: 'After Effects' },
]
</script>

<style scoped></style>