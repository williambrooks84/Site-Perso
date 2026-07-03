<template>
  <div class="cv-preview-shell">
    <div class="cv-preview-frame">
      <iframe
        :src="pdfSource"
        title="CV preview"
        class="cv-preview"
      />
    </div>
  </div>
</template>

<script setup>
const pdfSource = '/assets/pdf/cv.pdf'
</script>

<style scoped>
.cv-preview-shell {
  width: 100%;
  display: flex;
  justify-content: center;
  padding: 1rem 0;
}

.cv-preview-frame {
  width: min(100%, 520px);
  aspect-ratio: 595 / 841;
  display: flex;
}

.cv-preview {
  width: 100%;
  height: 100%;
  border: 0;
  display: block;
  background: #fff;
}
</style>