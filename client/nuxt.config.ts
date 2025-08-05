// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  baseURL: '/client/',
  nitro: {
    preset: 'static'
  },
  compatibilityDate: '2024-11-01',
  devtools: { enabled: false },
  modules: ['@nuxt/ui', 'nuxt-ripple'],
  css: ['./assets/css/main.css', 'bootstrap-icons/font/bootstrap-icons.css'], 
});