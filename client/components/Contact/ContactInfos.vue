<template>
  <div class="contact max-w-3xl flex flex-col items-center md:items-start gap-10">
    <div class="flex flex-col items-center gap-1 w-full">
      <h1 class="text-center">Contactez-moi</h1>
      <p class="text-center text-base md:text-xl">N'hésitez pas à me contacter pour toute question, projet ou collaboration.</p>
    </div>

    <ul class="w-full flex flex-col gap-6 list-none p-0 md:hidden">
      <ContactInfo
        v-for="(info, index) in infos"
        :key="index"
        :label="info.label"
        :content="info.content"
        :icon="info.icon"
      />
    </ul>

    <div class="hidden md:block w-full border-2 border-primary rounded-3xl px-5 py-4">
      <ul class="md:grid md:grid-cols-2 md:divide-x md:divide-primary list-none p-0 m-0">
        <li class="w-full px-6">
          <ContactInfo
            :label="infos[0].label"
            :content="infos[0].content"
            :icon="infos[0].icon"
            :unstyled="true"
          />
        </li>

        <li class="w-full px-6">
          <ContactInfo
            :label="infos[1].label"
            :content="infos[1].content"
            :icon="infos[1].icon"
            :unstyled="true"
          />
        </li>
      </ul>
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
.contact > * {
  width: 100%;
}
</style>