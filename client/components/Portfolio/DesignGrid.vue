<template>
    <div
        class="grid w-full items-stretch gap-6"
        :class="
            designs.length < 3
                ? 'lg:grid-cols-2 lg:justify-center'
                : 'lg:grid-cols-3'
        "
    >
        <DesignCard
            v-for="design in designs"
            :key="design.id"
            :design="design"
            :api-base-url="apiBaseUrl"
        />
    </div>
</template>

<script setup>
import DesignCard from './DesignCard.vue'

defineProps({
    designs: {
        type: Array,
        required: true,
    },

    apiBaseUrl: {
        type: String,
        required: true,
    },
})
</script>