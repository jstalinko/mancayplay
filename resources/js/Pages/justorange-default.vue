<template>
  <Navbar/>
  
  <div :class="{'dark': isDarkMode}" class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
      
      <div class="flex flex-col sm:flex-row justify-between items-center mb-10 gap-4">
        <div class="text-center sm:text-left">
          <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">
            Koleksi Game Sharing
          </h1>
          <p class="mt-2 text-base text-gray-600 dark:text-gray-400"> Koleksi Game Sharing untuk kamu!✨
Beli sekarang, nikmati keseruan main game tanpa batas.
          </p>
        </div>

        <button 
          @click="toggleDarkMode" 
          class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-colors duration-300"
        >
          <svg v-if="isDarkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" /></svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.071 14.95l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zm-.707-4.243a1 1 0 010-1.414l.707-.707a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414z" clip-rule="evenodd" /></svg>
          <span>{{ isDarkMode ? 'Light Mode' : 'Dark Mode' }}</span>
        </button>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        <div 
          v-for="(product,index) in products" 
          :key="product.id" 
          class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl flex flex-col"
        >
          <div class="relative">
            
            <img class="w-full h-40 object-cover object-center" :src="imageUrl(product.image)" :alt="product.name">
            <span class="absolute top-3 left-3 inline-block bg-blue-500 text-white text-xs font-semibold px-2 py-1 rounded-full uppercase tracking-wider">
              {{ product.category ?? 'no category' }}
            </span>
          </div>

          <div class="p-4 flex flex-col flex-grow">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1">
              {{ product.name }}
            </h2>
            
            
            
            <div class="mt-auto flex items-center justify-between">
              <span class="text-xl font-extrabold text-gray-900 dark:text-gray-100">
              {{ product.price == 0 ? 'Chat admin' : formatCurrency(product.price) }}
              </span>
              <a :href="product.link" target="_blank" class="bg-indigo-600 text-white font-semibold px-3 py-1.5 text-sm rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-colors duration-300">
                Beli
              </a>
            </div>
          </div>
        </div>
        
      </div>

    </div>
  </div>
</template>

<script setup>
// The script section remains the same as before
import Navbar from './Components/Navbar.vue';
import { formatCurrency, imageUrl } from '../utils/helpers';
import { ref, onMounted } from 'vue';

const isDarkMode = ref(false);
const prop = defineProps({products:Object});


const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  localStorage.setItem('darkMode', isDarkMode.value);
  
  updateHtmlClass();
};

const updateHtmlClass = () => {
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

onMounted(() => {
  const savedMode = localStorage.getItem('darkMode');
  if (savedMode !== null) {
    isDarkMode.value = JSON.parse(savedMode);
  } else {
    isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
  }
  updateHtmlClass();

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (localStorage.getItem('darkMode') === null) {
      isDarkMode.value = event.matches;
      updateHtmlClass();
    }
  });
});
</script>