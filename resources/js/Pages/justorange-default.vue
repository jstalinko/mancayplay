<template>
  <MainLayout :title="'MancayPlay - Gaming Store'">
    <div class="max-w-7xl mx-auto py-12 px-2 sm:px-6 lg:px-8">
      
      <!-- Hero Section -->
      <div class="relative overflow-hidden mb-8 md:mb-16 rounded-3xl md:rounded-[2rem] bg-indigo-600 dark:bg-indigo-900 shadow-2xl">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative px-4 py-10 md:px-16 md:py-24 flex flex-col items-center text-center">
            <h1 class="text-2xl md:text-6xl font-black tracking-tight text-white mb-4 md:mb-6 leading-tight">
                Koleksi Game <span class="text-indigo-200">Sharing</span> Terbaik
            </h1>
            <p class="max-w-2xl text-sm md:text-xl text-indigo-100 mb-6 md:mb-10 leading-relaxed font-medium">
                Nikmati keseruan main game premium tanpa batas dengan harga terjangkau. 
                Pilih game favoritmu dan mulai petualangan sekarang!
            </p>
            
            <!-- Modern Search Bar -->
            <div class="w-full max-w-xl group relative">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl border border-white/20 shadow-2xl transition-all duration-300 group-focus-within:bg-white/20 group-focus-within:scale-[1.02]"></div>
                <div class="relative flex items-center px-4 py-3 md:px-6 md:py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 text-indigo-200 mr-3 md:mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input 
                        type="text" 
                        v-model="searchQuery"
                        placeholder="Cari game..."
                        class="w-full bg-transparent border-none text-white placeholder-indigo-200 focus:ring-0 text-base md:text-lg font-bold outline-none"
                    />
                </div>
            </div>
        </div>
      </div>

      <!-- Content Section -->
      <div class="flex items-center justify-between mb-6 md:mb-10 px-2 md:px-0">
        <h2 class="text-lg md:text-2xl font-black text-gray-900 dark:text-gray-100 flex items-center">
            <span class="w-6 md:w-10 h-1 md:h-1.5 bg-indigo-600 rounded-full mr-2 md:mr-4"></span>
            Tersedia
        </h2>
        <span class="text-[10px] md:text-sm font-bold text-gray-400 dark:text-gray-600 uppercase tracking-widest bg-gray-100 dark:bg-gray-800 px-3 py-1 md:px-4 md:py-1.5 rounded-full">
            {{ filteredProducts.length }} Games
        </span>
      </div>

      <!-- Grid Layout -->
      <div v-if="displayedProducts.length > 0" class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-8">
        <ProductCard 
          v-for="product in displayedProducts" 
          :key="product.id" 
          :product="product"
        />
      </div>

      <!-- Empty State -->
      <div v-else class="py-20 text-center flex flex-col items-center">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Game tidak ditemukan</h3>
            <p class="text-gray-500 dark:text-gray-400">Coba gunakan kata kunci pencarian yang lain.</p>
      </div>
      
      <!-- Pagination / Load More -->
      <div v-if="hasMoreProducts" class="mt-20 text-center">
        <button 
          @click="loadMore"
          class="group relative inline-flex items-center justify-center px-10 py-4 font-black transition-all duration-300 bg-white dark:bg-gray-800 border-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 rounded-2xl hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 shadow-xl overflow-hidden"
        >
          <span class="relative z-10">Lihat Lebih Banyak Games</span>
          <div class="absolute inset-0 -translate-x-full group-hover:translate-x-0 bg-indigo-600 transition-transform duration-300"></div>
        </button>
      </div>

    </div>
  </MainLayout>
</template>

<script setup>
import MainLayout from '../Layouts/MainLayout.vue';
import ProductCard from '../Components/ProductCard.vue';
import { ref, computed, watch } from 'vue';

const prop = defineProps({products:Object});

const ITEMS_PER_PAGE = 8;
const searchQuery = ref('');
const visibleCount = ref(ITEMS_PER_PAGE);

const filteredProducts = computed(() => {
  if (!searchQuery.value) {
    return prop.products;
  }
  return prop.products.filter(product => 
    product.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const displayedProducts = computed(() => {
  return filteredProducts.value.slice(0, visibleCount.value);
});

const hasMoreProducts = computed(() => {
  return visibleCount.value < filteredProducts.value.length;
});

const loadMore = () => {
  visibleCount.value += ITEMS_PER_PAGE;
};

watch(searchQuery, () => {
  visibleCount.value = ITEMS_PER_PAGE;
});

</script>