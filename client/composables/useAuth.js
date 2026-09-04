export const useAuth = () => {
  const isAuthenticated = useState('isAuthenticated', () => false)
  const config = useRuntimeConfig()
  const apiUrl = config.public.apiUrl || 'https://api.willbrooks.fr'

  const checkAuthentication = async () => {
    try {
      const response = await $fetch(`${apiUrl}/api/me`, {
        credentials: 'include',
      })
      isAuthenticated.value = response?.authenticated === true && response?.roles?.includes('ROLE_ADMIN')
    } catch {
      isAuthenticated.value = false
    }

    return isAuthenticated.value
  }

  const logout = async () => {
    try {
      await $fetch(`${apiUrl}/api/logout`, {
        method: 'POST',
        credentials: 'include',
      })
    } finally {
      isAuthenticated.value = false
    }
  }

  return {
    isAuthenticated,
    checkAuthentication,
    logout,
  }
}
