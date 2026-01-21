
<template>
    <div class="contact-infos flex flex-col gap-2 items-start">
        <h3 class="text-left gap-2 flex flex-row justify-center items-center "> <i :class="icon" v-if="icon"></i>{{ label }}</h3>
        <p class="body-text text-left">{{ content }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    icon : {
        type: String,
        required: false,
    },
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