<template>
    <nav class="fixed top-0 left-0 z-50 w-full shadow-md">
        <div class="bg-primary">  
            <div class="container mx-auto p-4 flex items-center justify-between">
            <img src="/assets/img/logo.svg" alt="logo" class="h-8" />
            <a href="#" class="flex items-center">
                <svg width="133" height="48" viewBox="0 0 133 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths stay the same -->
                </svg>
            </a>

            <!-- Mobile menu button (optional if you want responsiveness later) -->
            <button class="xl:hidden text-gray-600 focus:outline-none" @click="isMobileMenuOpen = !isMobileMenuOpen">
                <img src="/assets/icons/burger.svg" alt="burger" class="w-6 h-6" />
            </button>

            <!-- Navigation Links -->
            <div class="hidden xl:flex space-x-8 items-center justify-center flex-1">
                <NavLink 
                v-for="link in navLinks" 
                :key="link.name" 
                :href="link.href" 
                :name="link.name" 
                class="px-3 py-2 rounded"
                />
            </div>

            </div>
        </div>    
    </nav>
    <!-- Mobile nav links -->
    <div v-show="isMobileMenuOpen" class="xl:hidden absolute w-2/3 bg-primary flex flex-col px-4 pb-4 gap-2 space-y-2 right-0 transition">
        <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import NavLink from './NavLink.vue';
//import ContactModal from './ContactModal.vue';  
import { defineProps } from 'vue';

defineProps({
    show: Boolean
});

// Removed unused showModal variable

const navLinks = [
    { name: 'Accueil', href: '/' },
    { name: 'Qui suis-je ?', href: '/quisuisje' },
    { name: 'Mon portfolio', href: '/#' },
    { name: 'Voir mon CV', href: '/#' }
];

const isMobileMenuOpen = ref(false);

</script>

<style scoped>
@import "tailwindcss";
@import "@nuxt/ui";
</style>