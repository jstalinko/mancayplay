<template>
  <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-500">
    <Head :title="title" />
    
    <Navbar />

    <main class="flex-grow">
      <!-- Flash Messages -->
      <div v-if="$page.props.flash?.success" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between animate-bounce">
            <span class="font-bold">{{ $page.props.flash.success }}</span>
            <button @click="$page.props.flash.success = null" class="text-white hover:text-emerald-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
      </div>
      <slot />
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import { useTheme } from '../Composables/useTheme';

const { initTheme } = useTheme();

defineProps({
  title: {
    type: String,
    default: 'MancayPlay - Koleksi Game Sharing'
  }
});

onMounted(() => {
  initTheme();
});
</script>

<style>
/* Global smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Custom selection color */
::selection {
  background-color: rgba(79, 70, 229, 0.2);
  color: #4f46e5;
}

.dark ::selection {
  background-color: rgba(129, 140, 248, 0.3);
  color: #818cf8;
}
</style>
