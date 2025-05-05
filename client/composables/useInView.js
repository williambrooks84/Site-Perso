import { ref, onMounted, onUnmounted } from 'vue'

export function useInView(threshold = 0.1) {
  const elementRef = ref(null)
  const isVisible = ref(false)
  let observer = null

  onMounted(() => {
    observer = new IntersectionObserver(
      ([entry]) => {
        isVisible.value = entry.isIntersecting
      },
      { threshold }
    )
    if (elementRef.value) {
      observer.observe(elementRef.value)
    }
  })

  onUnmounted(() => {
    if (elementRef.value) {
      observer?.unobserve(elementRef.value)
    }
  })

  return {
    elementRef,
    isVisible
  }
}
