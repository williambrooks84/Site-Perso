<template>
    <NavBar/>
    <div class="p-10 lg:p-20">
        <slot/>
    </div>
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
</script>

<style scoped>

</style>