import type { RouteLocationNormalized } from 'vue-router'

type AuthResponse = {
  authenticated: boolean
  roles?: string[]
}

export default defineNuxtRouteMiddleware(async (to: RouteLocationNormalized) => {
  const isLoginPage = to.path === '/admin' || to.path === '/admin/'
  const config = useRuntimeConfig()
  const apiUrl = config.public.apiUrl || 'https://api.willbrooks.fr'

  try {
    const headers = import.meta.server ? useRequestHeaders(['cookie']) : {}
    
    const response = await $fetch<AuthResponse>(`${apiUrl}/api/me`, {
      credentials: 'include',
      headers,
    })

    if (isLoginPage && response?.authenticated === true && response?.roles?.includes('ROLE_ADMIN')) {
      return navigateTo('/admin/projects')
    }

    if (!isLoginPage && response?.authenticated !== true) {
      return navigateTo('/admin')
    }
  } catch {
    if (!isLoginPage) {
      return navigateTo('/admin')
    }
  }
})
