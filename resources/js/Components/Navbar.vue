<template>
  <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md sticky top-0 z-50 transition-all duration-300 border-b border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <div class="flex items-center">
          <a href="/" class="flex-shrink-0 flex items-center gap-3 group">
            <div class="relative">
              <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
              <img src="/icon.png" alt="mancayplay logo" class="relative w-9 h-9 transform group-hover:rotate-12 transition-transform duration-300">
            </div>
            <span class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 tracking-tight">MancayPlay</span>
          </a>
        </div>
        
        <div class="hidden md:block">
          <div class="ml-4 flex items-center gap-6 md:ml-6">
            <ThemeToggle />
            <Link href="/confirm-order"
             class="relative inline-flex items-center justify-center px-5 py-2 overflow-hidden font-bold text-white transition-all duration-300 bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            >
            <span class="relative">Konfirmasi Pesanan</span>
          </Link>
            <a 
              href="/dashboard" 
              class="relative inline-flex items-center justify-center px-5 py-2 overflow-hidden font-bold text-white transition-all duration-300 bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            >
              <span class="relative">Login</span>
            </a>
          </div>
        </div>

        <div class="flex items-center gap-4 md:hidden">
          <ThemeToggle />
          <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button" class="bg-gray-100 dark:bg-gray-800 inline-flex items-center justify-center p-2 rounded-xl text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-300 focus:outline-none">
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

    <!-- Mobile menu -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="transform -translate-y-4 opacity-0"
      enter-to-class="transform translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="transform translate-y-0 opacity-100"
      leave-to-class="transform -translate-y-4 opacity-0"
    >
      <div v-if="isMobileMenuOpen" class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 shadow-xl">
        <div class="px-4 pt-4 pb-6 space-y-3">
          <a 
            href="/dashboard" 
            class="flex items-center justify-center w-full px-4 py-3 font-bold text-white bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all duration-300"
          >
            Login Dashboard
          </a>
        </div>
      </div>
    </transition>
  </nav>
</template>

<script setup>
import { ref } from 'vue';
import ThemeToggle from './ThemeToggle.vue';
import { Link } from '@inertiajs/vue3';

const isMobileMenuOpen = ref(false);
</script>