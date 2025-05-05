<template>
    <ul>
        <li class="flex items-center text-md lg:text-xl font-semibold text-dark dark:text-light">
            <i :class="['bi', icon]" class="mr-3 text-secondary"></i>
            {{ text }}
        </li>
    </ul>
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

<style scoped>

</style>