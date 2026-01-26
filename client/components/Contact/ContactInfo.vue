<template>
  <div
    class="flex flex-col gap-2 items-center w-full"
    :class="unstyled ? '' : 'border-2 border-primary rounded-3xl px-5 py-4 contact-infos'"
  >
    <h3 class="flex items-center md:items-end gap-2 md:gap-3">
      <i :class="[icon, 'text-4xl']" v-if="icon" aria-hidden="true"></i>
      <span class="text-sm md:text-xl mt-1">{{ label }}</span>
    </h3>

    <hr class="border-t border-primary w-full my-2" />

    <p class="body-text text-left">
      <a v-if="isEmail" :href="`mailto:${content}`" class="underline">{{ content }}</a>
      <a v-else-if="isTel" :href="telHref" class="underline">{{ formattedTel }}</a>
      <span v-else>{{ content }}</span>
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  icon: { type: String, required: false },
  label: { type: String, required: true },
  content: { type: String, required: true },
  unstyled: { type: Boolean, default: false },
});

const isEmail = computed(() => /\S+@\S+\.\S+/.test(props.content));
const isTel = computed(() => /^[+\d()\s.-]{6,}$/.test(props.content));
const telHref = computed(() => `tel:${props.content.trim().replace(/[^\d+]/g, '')}`);
const formattedTel = computed(() => props.content.replace(/\s+/g, ' ').trim());
</script>

<style scoped>
.contact-infos h3 i { line-height: 1; display: inline-block; }
</style>