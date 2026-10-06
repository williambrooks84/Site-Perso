<template>
    <div class="flex flex-col gap-5 sm:pl-10 sm:pb-10">
        <h4>{{ title }}</h4>

        <div class="flex flex-wrap justify-center sm:justify-start gap-5">
            <Tool
                v-for="(tool, index) in tools"
                :key="`${title}-${index}`"
                :icon="tool.icon"
                :icon-dark="tool.iconDark"
                :label="tool.label"
                class="w-1/4 xl:w-1/8"
            />
        </div>
    </div>
</template>

<script setup>
import Tool from './Tool.vue'

defineProps({
    title: {
        type: String,
        required: false,
    },
    tools: {
        type: Array,
        required: true,
    },
})
</script>