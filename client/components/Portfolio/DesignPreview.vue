<template>
    <div class="h-full w-full">
        <!-- Preview trigger -->
        <button
            type="button"
            class="block h-full w-full cursor-pointer"
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
                    class="fixed inset-0 z-100 overflow-hidden bg-black/90"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="alt"
                >
                    <!-- Close -->
                    <button
                        type="button"
                        class="absolute right-4 top-4 z-40 flex h-10 w-10 items-center justify-center rounded-full bg-black/50 text-xl text-white transition hover:bg-black/70 focus:outline-none focus:ring-2 focus:ring-white/50"
                        aria-label="Fermer"
                        @click="close"
                    >
                        <i
                            class="bi bi-x-lg"
                            aria-hidden="true"
                        ></i>
                    </button>

                    <!-- Scrollable image viewport -->
                    <div
                        ref="viewport"
                        class="h-full w-full overflow-auto overscroll-contain"
                        @pointermove="movePan"
                        @pointerup="endPan"
                        @pointercancel="endPan"
                    >
                        <div
                            class="flex min-h-full min-w-full items-center justify-center p-8"
                            :class="{
                                'cursor-grabbing': isPanning,
                                'cursor-grab': !isPanning,
                            }"
                        >
                            <img
                                :src="src"
                                :alt="alt"
                                class="block h-auto max-w-none select-none object-contain"
                                :style="imageStyle"
                                draggable="false"
                                @pointerdown="startPan"
                            />
                        </div>
                    </div>

                    <!-- Help -->
                    <div
                        class="pointer-events-none absolute bottom-4 left-1/2 z-20 hidden -translate-x-1/2 rounded-lg bg-black/50 px-3 py-2 text-center text-xs text-white/70 sm:block"
                    >
                        Faites glisser pour déplacer · Molette pour faire défiler · Échap pour fermer
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>

<script setup>
import {
    nextTick,
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

const viewport = ref(null)

const isPanning = ref(false)

const panStart = ref({
    x: 0,
    y: 0,
})

const scrollStart = ref({
    left: 0,
    top: 0,
})

const imageStyle = {
    width: '400%',
    height: 'auto',
}

const open = async () => {
    isOpen.value = true

    await nextTick()

    if (viewport.value) {
        viewport.value.scrollTop = 0
        viewport.value.scrollLeft = 0
    }
}

const close = () => {
    isOpen.value = false
}

const startPan = event => {
    if (!viewport.value) {
        return
    }

    isPanning.value = true

    panStart.value = {
        x: event.clientX,
        y: event.clientY,
    }

    scrollStart.value = {
        left: viewport.value.scrollLeft,
        top: viewport.value.scrollTop,
    }

    event.currentTarget?.setPointerCapture?.(
        event.pointerId
    )
}

const movePan = event => {
    if (!isPanning.value || !viewport.value) {
        return
    }

    const deltaX =
        event.clientX - panStart.value.x

    const deltaY =
        event.clientY - panStart.value.y

    viewport.value.scrollLeft =
        scrollStart.value.left - deltaX

    viewport.value.scrollTop =
        scrollStart.value.top - deltaY
}

const endPan = event => {
    if (!isPanning.value) {
        return
    }

    isPanning.value = false

    event.currentTarget?.releasePointerCapture?.(
        event.pointerId
    )
}

const handleKeydown = event => {
    if (!isOpen.value) {
        return
    }

    if (event.key === 'Escape') {
        close()
    }
}

watch(isOpen, openState => {
    if (openState) {
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