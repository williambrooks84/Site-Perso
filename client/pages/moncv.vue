<template>
    <div class="w-full flex flex-col justify-center items-center gap-10">
        <DownloadCvButton :href="buttonProps[0].href" :download="buttonProps[0].download" :label="buttonProps[0].label" />
        <Cv />
    </div>
</template>

<script setup>
import Cv from '~/components/CV/Cv.vue'
import DownloadCvButton from '~/components/CV/DownloadCvButton.vue'

const buttonProps = [
    {
        href: '/assets/pdf/cv.pdf',
        download: 'William-Brooks-CV.pdf',
        label: 'Télécharger mon CV'
    }
]
</script>

<style scoped>

</style>