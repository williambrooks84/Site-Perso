import { ref, watchEffect } from 'vue'

const isDark = ref(false)

// Initialize theme from localStorage or system preference
if (typeof window !== 'undefined') {
  const savedTheme = localStorage.getItem('theme')
  isDark.value = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)
}

// Watch for changes and update localStorage and html class
watchEffect(() => {
  if (typeof window !== 'undefined') {
    if (isDark.value) {
      document.documentElement.classList.add('dark')
      localStorage.setItem('theme', 'dark')
    } else {
      document.documentElement.classList.remove('dark')
      localStorage.setItem('theme', 'light')
    }
  }
})

export function useTheme() {
  return { isDark }
}
