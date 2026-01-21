<template>
    <a 
        :href="href || '#'" 
        class="text-light text-xl font-semibold uppercase hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover px-3 py-2 rounded transition flex items-center gap-3"
    >
        <span>{{ name }}</span>
        <i v-if="icon" :class="[icon, 'text-xl']" aria-hidden="true"></i>
    </a>
</template>

<script setup lang="ts">

const props = defineProps<{
  href?: string;
  name: string;
  icon?: string;
}>();

</script>

<style scoped>

</style>