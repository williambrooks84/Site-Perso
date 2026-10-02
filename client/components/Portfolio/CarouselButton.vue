<template>
    <button
        type="button"
        :aria-label="label"
        :disabled="disabled"
        class="btn-unselected btn-unselected-small shrink-0 disabled:opacity-50"
        @click="$emit('click')"
    >
        <i
            class="bi"
            :class="
                direction === 'left'
                    ? 'bi-caret-left-fill'
                    : 'bi-caret-right-fill'
            "
        ></i>
    </button>
</template>

<script setup>
defineProps({
    direction: {
        type: String,
        required: true,
        validator: value => ['left', 'right'].includes(value),
    },

    label: {
        type: String,
        required: true,
    },

    disabled: {
        type: Boolean,
        default: false,
    },
})

defineEmits(['click'])
</script>