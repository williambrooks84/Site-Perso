<template>
    <nav class="shadow-md w-full">
        <div class="bg-primary">  
            <div class="container mx-auto p-4 flex items-center justify-between">
            <img src="" alt="logo">
            <a href="#" class="flex items-center">
                <svg width="133" height="48" viewBox="0 0 133 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG paths stay the same -->
                </svg>
            </a>

            <span id="slogan" class="mx-auto hidden sm:inline-flex xl:hidden text-light ">Impossible n'est pas possible</span>

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
    <div v-if="isMobileMenuOpen" class="xl:hidden absolute w-2/3 bg-primary flex flex-col px-4 pb-4 gap-2 space-y-2 right-0 transition">
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

const showModal = ref(false)

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