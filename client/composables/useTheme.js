export function useTheme() {
  const theme = useCookie('theme', {
    default: () => null
  })

  const isDark = useState(
    'theme-is-dark',
    () => theme.value === 'dark'
  )

  const setTheme = (dark) => {
    isDark.value = dark
    theme.value = dark ? 'dark' : 'light'
  }

  const toggleTheme = () => {
    setTheme(!isDark.value)
  }

  // Première visite uniquement :
  // aucun choix utilisateur n'existe encore.
  if (import.meta.client && theme.value === null) {
    const prefersDark = window.matchMedia(
      '(prefers-color-scheme: dark)'
    ).matches

    setTheme(prefersDark)
  }

  return {
    isDark,
    toggleTheme,
    setTheme
  }
}