<template>
    <NavBar />

    <div class="px-2 pt-25 pb-10 md:px-6 md:pt-18 lg:px-8">
        <slot />
    </div>

    <Footer />
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
import Footer from '~/components/Footer/Footer.vue'
</script>