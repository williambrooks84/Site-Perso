<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="$emit('close')">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full relative">
      <button
        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl"
        @click="$emit('close')"
        aria-label="Fermer"
      >
        &times;
      </button>
      <ContactInfos />
    </div>
  </div>
</template>

<script setup>
// import ContactForm from './ContactForm.vue';
import ContactInfos from './ContactInfos.vue';
</script>

<style scoped>

</style>