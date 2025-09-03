<template>
    <div class="contact-infos">
        <h2 class="contact-infos-label">{{ label }}</h2>
        <p class="contact-infos-content">{{ content }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    content: {
        type: String,
        required: true,
    }
});
</script>

<style scoped>

</style>