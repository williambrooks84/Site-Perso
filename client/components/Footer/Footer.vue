<template>
    <button
        v-if="!isOpen"
        class="fixed bottom-0 left-1/2 transform -translate-x-1/2 bg-secondary text-dark rounded-full p-2 z-50 transition hover:bg-hover"
        @click="toggleFooter"
        aria-label="Ouvrir le footer"
    >
        <i class="bi bi-chevron-up text-2xl"></i>
    </button>

    <footer
        :class="[
            'fixed left-0 w-full z-40 bg-secondary text-dark transition-all duration-300',
            isOpen ? 'bottom-0' : '-bottom-22'
        ]"
    >
        <button
            v-if="isOpen"
            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-secondary text-dark rounded-full p-2 transition hover:bg-hover"
            @click="toggleFooter"
            aria-label="Fermer le footer"
        >
            <i class="bi bi-chevron-down text-2xl"></i>
        </button>
        <div class="pt-8 pb-6">
            <div class="flex flex-col items-center font-semibold">
                <span class="mb-2 text-center">
                    © {{ currentYear }} William Brooks. Tous droits réservés.
                </span>
                <div class="flex flex-row gap-6">
                    <a href="/mentionslegales" class="text-primary text-xl hover:underline">
                        Mentions légales
                    </a>
                    <a href="/contact" class="text-primary text-xl hover:underline">
                        Me contacter
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const isOpen = ref(false);
const toggleFooter = () => {
    isOpen.value = !isOpen.value;
};

const currentYear = new Date().getFullYear();
</script>

<style scoped>
</style>