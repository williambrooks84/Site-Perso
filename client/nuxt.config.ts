// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: true,
  baseURL: '/client/',
  nitro: {
    preset: 'static'
  },
  compatibilityDate: '2024-11-01',
  devtools: { enabled: false },
  modules: ['@nuxt/ui', 'nuxt-ripple', '@nuxtjs/sitemap'],
  css: ['./assets/css/main.css', 'bootstrap-icons/font/bootstrap-icons.css'],

  site: {
    url: 'https://willbrooks.fr'
  },

  sitemap: {
    gzip: true,
    exclude: [],
    defaults: {
      changefreq: 'weekly',
      priority: 0.7,
      lastmod: new Date().toISOString()
    },
    xsl: false // ✅ pour éviter l’erreur /__sitemap__/style.xsl
  }
});