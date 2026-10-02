export function useTheme() {
  const theme = useCookie('theme', {
    default: () => null
  })

  const isDark = useState(
    'theme-is-dark',
    () => theme.value === 'dark'
  )

  const applyTheme = (dark) => {
    const newTheme = dark ? 'dark' : 'light'

    isDark.value = dark
    theme.value = newTheme

    if (import.meta.client) {
      document.documentElement.classList.toggle(
        'dark',
        dark
      )
    }
  }

  const toggleTheme = () => {
    applyTheme(!isDark.value)
  }

  if (import.meta.client) {
    if (theme.value === 'dark') {
      isDark.value = true
      document.documentElement.classList.add('dark')
    } else if (theme.value === 'light') {
      isDark.value = false
      document.documentElement.classList.remove('dark')
    } else {
      const prefersDark = window.matchMedia(
        '(prefers-color-scheme: dark)'
      ).matches

      applyTheme(prefersDark)
    }
  }

  return {
    isDark,
    toggleTheme,
    setTheme: applyTheme
  }
}