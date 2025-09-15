<template>
  <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <div class="flex items-center">
          <a href="#" class="flex-shrink-0 flex items-center gap-2">
          
            <img src="/icon.png" alt="mancayplay logo" class="w-8 h-8">
            <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">MancayPlay</span>
          </a>
        </div>
        
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <a 
              href="/dashboard" 
              class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-colors duration-300"
            >
              Login
            </a>
          </div>
        </div>

        <div class="-mr-2 flex md:hidden">
          <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button" class="bg-gray-100 dark:bg-gray-700 inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-indigo-500">
            <span class="sr-only">Buka menu</span>
            <svg v-if="!isMobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

      </div>
    </div>

    <div v-if="isMobileMenuOpen" class="md:hidden border-t border-gray-200 dark:border-gray-700">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a 
          href="#" 
          class="block w-full text-left bg-indigo-600 text-white font-semibold px-4 py-3 rounded-md hover:bg-indigo-700 transition-colors duration-300"
        >
          Login
        </a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

const isMobileMenuOpen = ref(false);
</script>

<style scoped>
/* Style tambahan jika diperlukan */
</style>