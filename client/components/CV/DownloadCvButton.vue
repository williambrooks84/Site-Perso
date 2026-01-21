<template>
    <a
      :href="href"
      :download="download"
      class="btn-primary w-fit"
    >
      {{label}}
    </a>
</template>

<script setup>
const props = defineProps({
    href: {
        type: String,
    },
    download: {
        type: String,
    },
    label: {
        type: String,
    }
});
</script>

<style scoped>

</style>