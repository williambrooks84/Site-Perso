<template>
    <NavBar/>
    <div class="pt-40 p-10 lg:p-32">
        <slot/>
    </div>
    <Footer/>
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
import Footer from '~/components/Footer/Footer.vue'
</script>

<style scoped>

</style>