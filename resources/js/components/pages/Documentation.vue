<template>
  <iframe src="/api/documentation"></iframe>
</template>
<style scoped>
iframe {
  margin-top:20px;
  display: block;       /* iframes are inline by default */
  border: none;         /* Reset default border */
  height: 90vh;        /* Viewport-relative units */
  width: 100vw;
  overflow: hidden;
}
</style>