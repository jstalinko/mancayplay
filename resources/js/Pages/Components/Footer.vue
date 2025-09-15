<template>
  <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 w-full">
    <span>&copy; {{ year }} Mancaplay. All rights reserved.</span>
  </footer>
</template>

<script setup>
const year = new Date().getFullYear();
</script>

<style scoped>
footer {
  border-top: 1px solid #e5e7eb;
}
</style>
