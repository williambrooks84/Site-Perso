<template>
    <footer>
        <div>
            <ul class="flex flex-row md:flex-col text-center text-sm lg:text-base text-dark">
                <li v-for="(item, index) in footerData" :key="index" class="mb-2">
                    <a v-if="item.link" :href="item.link" class="text-secondary hover:underline">
                        {{ item.text }}
                    </a>
                    <span v-else>{{ item.text }}</span>
                </li>
            </ul>
        </div>
    </footer>
</template>

<script setup>

const currentYear = new Date().getFullYear();

const footerData = computed(() => [
    {
        text: `© ${currentYear} William Brooks. Tous droits réservés.`,
        link: null
    },
    {
        text: `Mentions légales`,
        link: `/mentionslegales`
    },
    {
        text: `Me contacter`,
        link: `/contact`
    },
]);
</script>

<style scoped>

</style>