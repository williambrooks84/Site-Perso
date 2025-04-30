<template>
    <ul>
        <li class="flex items-center text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <img :src="icon" alt="">
            {{ text }}
        </li>
    </ul>
</template>

<script setup>
const props = defineProps({

    text: {
        type: String,
        required: true
    }
})

</script>

<style scoped>

</style>