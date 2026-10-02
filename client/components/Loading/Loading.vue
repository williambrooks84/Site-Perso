<template>
  <section
    id="loading"
    class="fixed inset-0 z-50 flex flex-col items-center justify-center gap-3"
    role="status"
    aria-live="polite"
  >
    <div
      class="size-24 animate-spin rounded-full border-8 border-primary border-t-transparent"
      aria-hidden="true"
    ></div>

    <span class="text-4xl text-primary">
      Chargement...
    </span>
</section>
</template>