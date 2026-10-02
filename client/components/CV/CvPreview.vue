<template>
  <div class="cv-preview-shell">
    <div ref="containerRef" class="cv-preview-frame">
      <canvas ref="canvasRef" class="cv-preview"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue'

const emit = defineEmits(['loaded'])

const canvasRef = ref(null)
const containerRef = ref(null)

let pdf = null
let resizeObserver = null
let rendering = false

const renderPdf = async () => {
  if (!pdf || !containerRef.value || !canvasRef.value || rendering) {
    return
  }

  rendering = true

  try {
    const page = await pdf.getPage(1)

    const containerWidth = containerRef.value.clientWidth

    if (!containerWidth) {
      return
    }

    const baseViewport = page.getViewport({
      scale: 1
    })

    const scale = containerWidth / baseViewport.width

    const viewport = page.getViewport({
      scale
    })

    const canvas = canvasRef.value
    const context = canvas.getContext('2d')

    const pixelRatio = window.devicePixelRatio || 1

    canvas.width = Math.floor(viewport.width * pixelRatio)
    canvas.height = Math.floor(viewport.height * pixelRatio)

    canvas.style.width = `${viewport.width}px`
    canvas.style.height = `${viewport.height}px`

    context.setTransform(1, 0, 0, 1, 0, 0)
    context.clearRect(0, 0, canvas.width, canvas.height)

    await page.render({
      canvasContext: context,
      viewport,
      transform: [
        pixelRatio,
        0,
        0,
        pixelRatio,
        0,
        0
      ]
    }).promise
  } finally {
    rendering = false
  }
}

onMounted(async () => {
  try {
    const pdfjsLib = await import('pdfjs-dist')

    const worker = await import(
      'pdfjs-dist/build/pdf.worker.mjs?url'
    )

    pdfjsLib.GlobalWorkerOptions.workerSrc = worker.default

    pdf = await pdfjsLib.getDocument({
      url: '/assets/pdf/cv.pdf'
    }).promise

    await nextTick()

    await renderPdf()

    emit('loaded')

    resizeObserver = new ResizeObserver(() => {
      renderPdf()
    })

    if (containerRef.value) {
      resizeObserver.observe(containerRef.value)
    }
  } catch (error) {
    console.error('ERREUR PDF :', error)
  }
})

onBeforeUnmount(() => {
  resizeObserver?.disconnect()
})
</script>

<style scoped>
.cv-preview-shell {
  width: 100%;
  display: flex;
  justify-content: center;
}

.cv-preview-frame {
  width: 100%;
  max-width: 520px;
  margin: 0 auto;
}

.cv-preview {
  display: block;
  width: 100%;
  height: auto;
  margin: 0 auto;
}

@media (min-width: 576px) {
  .cv-preview-frame {
    max-width: 480px;
  }
}

</style>