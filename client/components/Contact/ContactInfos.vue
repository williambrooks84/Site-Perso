<template>
    <div>
        <h3>Ou utilisez les informations ci-dessous pour me contacter :</h3>
        <div>
            <ContactInfo
                v-for="(info, index) in infos" 
                :label="info.label" 
                :content="info.content" 
            />
        </div>
    </div>
</template>

<script setup>
import ContactInfo from './ContactInfo.vue';

const infos = [
    { label: 'Addresse', content: '10 Rue des Mouettes, 87000 Limoges' },
    { label: 'Mail', content: 'william.brooks@etu.unilim.fr' },
    { label: 'Téléphone', content: '07 81 47 13 04' },
];
</script>

<style scoped>

</style>