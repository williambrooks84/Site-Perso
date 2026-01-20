<template>
    <nav class="fixed top-0 left-0 z-50 w-full shadow-md">
        <div class="bg-[var(--color-primary)]">
            <div class="container mx-auto p-4 flex items-center justify-between">
                <client-only>
                    <img :src="logoSrc" alt="logo" class="h-8" />
                </client-only>
                <a href="#" class="flex items-center">
                    <svg width="133" height="48" viewBox="0 0 133 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- SVG paths stay the same -->
                    </svg>
                </a>
                <div class="flex items-center flex-1 justify-end xl:justify-center space-x-4">
                    <!-- Desktop nav links and theme toggle -->
                    <div class="hidden xl:flex space-x-8 items-center">
                        <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name"
                            class="px-3 py-2 rounded" />
                        <!-- Theme toggle button (desktop, left of contact) -->
                        <client-only>
                            <ThemeButton class="ml-4 mr-2" />
                        </client-only>
                        <!-- Me contacter button -->
                        <!--<ContactButton @click="showContactModal = true" />-->
                    </div>
                    <!-- Mobile theme toggle (left of burger) -->
                    <client-only>
                      <ThemeButton class="ml-4 mr-2 xl:hidden" />
                    </client-only>
                    <!-- Mobile menu button -->
                    <button class="xl:hidden focus:outline-none transition" @click="isMobileMenuOpen = !isMobileMenuOpen">
                        <i
                            :class="isMobileMenuOpen ? 'bi bi-x-lg text-4xl text-light' : 'bi bi-list text-4xl text-light'"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile nav links -->
    <div v-show="isMobileMenuOpen"
        class="xl:hidden fixed top-20 right-0 w-2/3 bg-primary flex flex-col px-4 pb-4 gap-2 space-y-2 z-50 transition">
        <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" />
        <!--<ContactButton class="mt-2 w-fit" @click="showContactModal = true" />-->
    </div>
    <!-- Contact Modal -->
    <!--<Contact v-if="showContactModal" @close="showContactModal = false" />-->
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useTheme } from '~/composables/useTheme.js';
import NavLink from './NavLink.vue';
import Contact from '../Contact/Contact.vue';
import ThemeButton from './ThemeButton.vue';
import ContactButton from './ContactButton.vue'; 

const navLinks = [
  { name: 'Accueil', href: '/' },
  { name: 'Qui suis-je ?', href: '/quisuisje' },
  { name: 'Mon portfolio', href: '/portfolio' },
  { name: 'Mon CV', href: '/moncv' }
];

const isMobileMenuOpen = ref(false);
const showContactModal = ref(false);
const { isDark } = useTheme();
const logoSrc = ref(isDark.value ? '/assets/img/logo-dark.svg' : '/assets/img/logo.svg');

// Met à jour le logo si isDark change dynamiquement côté client
watch(isDark, (val) => {
    logoSrc.value = val ? '/assets/img/logo-dark.svg' : '/assets/img/logo.svg';
});
onMounted(() => {
    logoSrc.value = isDark.value ? '/assets/img/logo-dark.svg' : '/assets/img/logo.svg';
});
</script>

<style scoped>
@import "tailwindcss";
@import "@nuxt/ui";
</style>