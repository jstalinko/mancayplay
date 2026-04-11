<template>
  <button
    @click="toggleTheme"
    class="relative inline-flex h-9 w-16 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 shadow-inner"
    :class="isDark ? 'bg-gray-700' : 'bg-indigo-100'"
    aria-label="Toggle theme"
  >
    <span class="sr-only">Toggle theme</span>
    
    <!-- Sun/Moon Icon background -->
    <div 
        class="absolute inset-0 flex items-center justify-between px-2 text-xs opacity-50 transition-opacity duration-300 pointer-events-none"
        :class="isDark ? 'opacity-100' : 'opacity-100'"
    >
        <span v-if="!isDark">☀️</span>
        <span v-else class="ml-auto">🌙</span>
    </div>

    <!-- Toggle Slider -->
    <span
      class="inline-block h-7 w-7 transform rounded-full bg-white shadow-lg transition-transform duration-300 ease-in-out flex items-center justify-center overflow-hidden"
      :class="isDark ? 'translate-x-[32px]' : 'translate-x-1'"
    >
        <transition name="icon-fade" mode="out-in">
            <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707ZM12 8a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
        </transition>
    </span>
  </button>
</template>

<script setup>
import { useTheme } from '../Composables/useTheme';

const { isDark, toggleTheme } = useTheme();
</script>

<style scoped>
.icon-fade-enter-active,
.icon-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.icon-fade-enter-from,
.icon-fade-leave-to {
  opacity: 0;
  transform: scale(0.5);
}
</style>
