<template>
    <div class="h-full w-full">
        <!-- Preview trigger -->
        <button
            type="button"
            class="block h-full w-full cursor-zoom-in"
            :aria-label="`Agrandir ${alt}`"
            @click="open"
        >
            <slot />
        </button>

        <!-- Fullscreen preview -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="isOpen"
                    class="fixed inset-0 z-100 flex items-center justify-center bg-black/90 p-4"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="alt"
                    @click.self="close"
                >
                    <!-- Close button -->
                    <button
                        type="button"
                        class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/50 text-xl text-white transition hover:bg-black/70 focus:outline-none focus:ring-2 focus:ring-white/50"
                        aria-label="Fermer"
                        @click="close"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                    <!-- Fullscreen image -->
                    <img
                        :src="src"
                        :alt="alt"
                        class="max-h-[90vh] max-w-[95vw] object-contain"
                        @click.stop
                    />
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import {
    onBeforeUnmount,
    ref,
    watch,
} from 'vue'

defineProps({
    src: {
        type: String,
        required: true,
    },

    alt: {
        type: String,
        default: '',
    },
})

const isOpen = ref(false)

const open = () => {
    isOpen.value = true
}

const close = () => {
    isOpen.value = false
}

const handleKeydown = event => {
    if (event.key === 'Escape') {
        close()
    }
}

watch(isOpen, open => {
    if (open) {
        document.addEventListener(
            'keydown',
            handleKeydown
        )

        document.body.style.overflow = 'hidden'
    } else {
        document.removeEventListener(
            'keydown',
            handleKeydown
        )

        document.body.style.overflow = ''
    }
})

onBeforeUnmount(() => {
    document.removeEventListener(
        'keydown',
        handleKeydown
    )

    document.body.style.overflow = ''
})
</script>