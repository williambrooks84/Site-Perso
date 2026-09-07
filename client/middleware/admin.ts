import type { RouteLocationNormalized } from 'vue-router'

type AuthResponse = {
  authenticated: boolean
  roles?: string[]
}

export default defineNuxtRouteMiddleware(async (to: RouteLocationNormalized) => {
  const isLoginPage = to.path === '/admin' || to.path === '/admin/'
  const config = useRuntimeConfig()
  const apiUrl = config.public.apiUrl || 'https://api.willbrooks.fr'

  if (import.meta.client) {
    const nuxtApp = useNuxtApp()

    if (nuxtApp.isHydrating && nuxtApp.payload.serverRendered) {
      return
    }
  }

  try {
    const response = await $fetch<AuthResponse>(`${apiUrl}/api/me`, {
      credentials: 'include',
      headers: import.meta.server
        ? useRequestHeaders(['cookie'])
        : undefined,
    })

    const isAdmin =
      response.authenticated === true &&
      response.roles?.includes('ROLE_ADMIN') === true

    if (isLoginPage && isAdmin) {
      return navigateTo('/admin/projects')
    }

    if (!isLoginPage && !isAdmin) {
      return navigateTo('/admin')
    }
  } catch {
    if (!isLoginPage) {
      return navigateTo('/admin')
    }
  }
})