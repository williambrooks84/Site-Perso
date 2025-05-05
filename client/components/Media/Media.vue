<template>
    <a :href="link">
        <img :src="icon" :alt="name" :class="sizeClass" />
    </a>
</template>

<script setup>

const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    link: {
        type: String,
        required: true
    },
    size: {
        type: String,
        default: 'default', 
        validator: (value) => ['default', 'large'].includes(value)
    }
});

const sizeClass = {
    default: 'w-10',
    large: 'w-20'
}[props.size] || 'w-10';

</script>

<style scoped>
img {
    height: auto;
}
</style>