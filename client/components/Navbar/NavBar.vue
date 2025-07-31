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
                <div class="flex items-center flex-1 justify-end xl:justify-center space-x-4">
                    <!-- Desktop nav links and theme toggle -->
                    <div class="hidden xl:flex space-x-8 items-center">
                        <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" class="px-3 py-2 rounded" />
                        <!-- Theme toggle button (desktop, left of contact) -->
                        <ThemeButton class="ml-4 mr-2" />
                        <!-- Me contacter button -->
                        <button class="px-4 py-2 bg-secondary text-white rounded hover:bg-secondary-dark transition"
                            @click="showContactModal = true">
                            <i class="bi bi-pencil-fill"></i>
                            Me contacter
                        </button>
                    </div>
                    <!-- Mobile theme toggle (left of burger) -->
                    <ThemeButton class="ml-4 mr-2 xl:hidden" />
                    <!-- Mobile menu button -->
                    <button class="xl:hidden focus:outline-none"
                        @click="isMobileMenuOpen = !isMobileMenuOpen">
                        <i :class="isMobileMenuOpen ? 'bi bi-x-lg text-4xl text-secondary' : 'bi bi-list text-4xl text-white'"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile nav links -->
    <div v-show="isMobileMenuOpen"
        class="xl:hidden absolute w-2/3 bg-primary flex flex-col px-4 pb-4 gap-2 space-y-2 right-0 transition mt-20">
        <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" />
        <button class="mt-2 px-4 py-2 bg-secondary text-white rounded hover:bg-secondary-dark w-fit transition"
            @click="showContactModal = true">
            <i class="bi bi-pencil-fill"></i>
            Me contacter
        </button>
    </div>
    <!-- Contact Modal -->
    <Contact v-if="showContactModal" @close="showContactModal = false" />
</template>

<script setup>
import { ref} from 'vue';
import NavLink from './NavLink.vue';
import Contact from '../Contact/Contact.vue';
import ThemeButton from './ThemeButton.vue';

const navLinks = [
    { name: 'Accueil', href: '/' },
    { name: 'Qui suis-je ?', href: '/quisuisje' },
    { name: 'Mon portfolio', href: '/#' },
    { name: 'Voir mon CV', href: '/moncv' }
];

const isMobileMenuOpen = ref(false);
const showContactModal = ref(false);

</script>

<style scoped>
@import "tailwindcss";
@import "@nuxt/ui";
</style>