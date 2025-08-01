<template>
    <button
        class="px-3 py-2 bg-light text-primary text-xl font-semibold uppercase rounded transition hover:underline hover:decoration-primary hover:decoration-2 underline-offset-7 hover:text-primary hover:bg-hover"
        @click="$emit('click')"
    >
        <i class="bi bi-pencil-fill"></i>
        Me contacter
    </button>
</template>