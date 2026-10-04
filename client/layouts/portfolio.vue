<template>
    <NavBar />

    <main class="px-2 pt-25 pb-10 md:px-6 md:pt-20 lg:px-8">
        <slot />
    </main>

    <Footer />
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
import Footer from '~/components/Footer/Footer.vue'
</script>