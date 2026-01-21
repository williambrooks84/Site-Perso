<template>
    <div class="w-full max-w-3xl flex flex-col items-center lg:items-start gap-6">
        <h1 class="w-full text-center">Mes informations de contact</h1>
        <div class="w-full flex flex-col gap-6">
            <ContactInfo
                v-for="(info, index) in infos" 
                :key="index"
                :label="info.label" 
                :content="info.content" 
                :icon="info.icon"
            />
        </div>
    </div>
</template>

<script setup>
import ContactInfo from './ContactInfo.vue';

const infos = [
    { icon: 'bi-envelope-fill', label: 'Mail', content: 'william.brooks@etu.unilim.fr' },
    { icon: 'bi-telephone-fill', label: 'Téléphone', content: '+33 7 81 47 13 04' },
];
</script>

<style scoped>

</style>