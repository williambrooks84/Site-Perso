<template>
    <li class="flex items-center text-md lg:text-xl font-semibold text-dark">
        <i :class="['bi', icon]" class="mr-3 text-secondary" aria-hidden="true"></i>
        {{ text }}
    </li>
</template>

<script setup>
const props = defineProps({

    icon: {
        type: String,
        required: true
    },

    text: {
        type: String,
        required: true
    }
})

</script>

<style scoped></style>