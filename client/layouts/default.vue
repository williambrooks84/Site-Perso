<template>
  <NavBar />

  <main class="pt-30 p-10 lg:p-32">
    <slot />
  </main>

  <Footer />
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
import Footer from '~/components/Footer/Footer.vue'
</script>

<style scoped>
</style>