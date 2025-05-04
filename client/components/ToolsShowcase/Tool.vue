<template>
    <div class="flex flex-col items-center gap-2">
        <img :src="icon" alt="" class="w-16 h-16" />
        <p>{{ label }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    }
})
</script>

<style scoped>

</style>