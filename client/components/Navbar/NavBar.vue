<template>
  <header>
    <nav class="fixed top-0 left-0 z-50 w-full shadow-md">
      <div class="bg-[var(--color-primary)]">
        <div class="container mx-auto flex items-center justify-between px-6 py-4 xl:p-4">

          <!-- Navigation -->
          <div class="flex flex-1 items-center justify-between space-x-4 xl:justify-center">
            <!-- Logo central -->
            <ClientOnly>
              <a href="/" class="flex items-center mr-10" aria-label="Accueil">
                <img :src="isDark
                  ? '/assets/img/logo-dark.svg'
                  : '/assets/img/logo.svg'
                  " alt="Logo" class="h-8" />
              </a>
            </ClientOnly>
            <!-- Navigation desktop -->
            <div class="hidden items-center space-x-8 xl:flex">
              <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" :icon="link.icon"
                class="rounded px-3 py-2" />

              <!-- Bouton thème -->
              <ClientOnly>
                <ThemeButton class="ml-4 mr-2" />
              </ClientOnly>

              <!-- Déconnexion -->
              <button v-if="isAuthenticated" type="button" class="text-light" aria-label="Se déconnecter"
                @click="logout">
                <i class="bi bi-box-arrow-left"></i>
              </button>
            </div>

            <!-- Navigation mobile -->
            <div class="flex flex-row items-center gap-4 xl:hidden">
              <!-- Bouton thème -->
              <ClientOnly>
                <ThemeButton />
              </ClientOnly>

              <!-- Bouton menu burger-->
              <button type="button" class="flex items-center justify-center p-0 transition focus:outline-none"
                :aria-expanded="isMobileMenuOpen" aria-label="Ouvrir le menu"
                @click="isMobileMenuOpen = !isMobileMenuOpen">
                <i :class="isMobileMenuOpen
                  ? 'bi bi-x-lg text-4xl text-light'
                  : 'bi bi-list text-4xl text-light'
                  "></i>
              </button>
            </div>

          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Menu mobile -->
  <div v-show="isMobileMenuOpen"
    class="fixed top-18 right-0 z-50 flex w-2/3 flex-col gap-2 space-y-2 bg-[var(--color-primary)] px-4 pb-4 xl:hidden">
    <NavLink v-for="link in navLinks" :key="link.name" :href="link.href" :name="link.name" :icon="link.icon" />

    <!-- Déconnexion mobile -->
    <button v-if="isAuthenticated" type="button" class="mt-2 w-fit text-light" aria-label="Se déconnecter"
      @click="logout">
      <i class="bi bi-box-arrow-left"></i>
    </button>
  </div>
  <div v-show="isMobileMenuOpen" class="fixed inset-0 z-40 bg-black/80 xl:hidden" @click="isMobileMenuOpen = false">
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

import { useTheme } from '~/composables/useTheme.js'

import NavLink from './NavLink.vue'
import ThemeButton from './ThemeButton.vue'

const navLinks = [
  {
    name: 'Accueil',
    href: '/'
  },
  {
    name: 'Qui suis-je ?',
    href: '/quisuisje'
  },
  {
    name: 'Mes réalisations',
    href: '/portfolio'
  },
  {
    name: 'Mon CV',
    href: '/moncv'
  },
  {
    name: 'Me contacter',
    href: '/contact',
    icon: 'bi-pencil-fill'
  }
]

const isMobileMenuOpen = ref(false)

const { isDark } = useTheme()

const {
  isAuthenticated,
  checkAuthentication,
  logout: logoutUser
} = useAuth()

onMounted(() => {
  checkAuthentication()
})

const logout = async () => {
  try {
    await logoutUser()
  } catch {
    // La session peut déjà être expirée.
  } finally {
    isAuthenticated.value = false
    isMobileMenuOpen.value = false

    await navigateTo('/admin')
  }
}
</script>

<style scoped></style>