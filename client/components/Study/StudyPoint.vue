<template>

    <div class="space-y-8 mt-15 flex flex-col items-center">
        <div class="flex flex-col gap-5">
            <h3>{{ name }} <small>({{ year }})</small></h3>
            <p class="body-text">
                {{ content }}
            </p>
        </div>
        <img v-if="image" :src="image" :alt="name" class="w-100 h-auto" />
    </div>
</template>

<script setup>

const studyProps = defineProps({
    name: {
        type: String,
        required: true
    },

    year: {
        type: String,
        required: true
    },

    content: {
        type: String,
        required: true
    },

    image: {
        type: String,
        required: false
    }
});

</script>

<style scoped></style>