<template>
  <div class="flex flex-col">
    <NavBar />

    <main class="w-full px-2 pt-4 pb-4 md:px-6 md:pt-8 md:pb-8">
      <slot />
    </main>

    <Footer />
  </div>
</template>

<script setup>
import NavBar from '~/components/Navbar/NavBar.vue'
import Footer from '~/components/Footer/Footer.vue'
</script>
