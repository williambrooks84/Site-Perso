<template>
    <NavBar/>
    <div class="pt-40 p-10 lg:p-32">
        <slot/>
    </div>
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
</script>

<style scoped>

</style>