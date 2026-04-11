<template>
  <MainLayout :title="`Inbox - ${product ? product.name : 'MancayPlay'}`">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 min-h-screen">
      
      <div class="mb-8 flex items-center justify-between">
          <div>
              <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center tracking-tight">
                  <span class="w-8 h-12 bg-indigo-600 rounded-lg mr-4 hidden md:block"></span>
                  Inbox OTP
              </h1>
              <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium" v-if="product">
                  Pesan masuk untuk: <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ product.name }}</span>
              </p>
          </div>
          <a :href="hasAccess ? '/dashboard/pembelian-saya' : '/'" class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 select-none">
              Kembali
          </a>
      </div>

      <!-- Access Denied -->
      <div v-if="errorMsg" class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-center text-center md:text-left gap-4 shadow-sm mb-6">
          <div class="w-16 h-16 bg-red-100 dark:bg-red-800/50 text-red-600 dark:text-red-400 flex items-center justify-center rounded-2xl flex-shrink-0">
             <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
             </svg>
          </div>
          <div>
              <h3 class="text-xl font-bold text-red-800 dark:text-red-400 mb-1">Akses Ditolak</h3>
              <p class="text-red-600 dark:text-red-300">{{ errorMsg }}</p>
              <a :href="hasAccess ? '/dashboard/pembelian-saya' : '/'" class="mt-4 inline-block md:hidden text-indigo-600 font-bold underline">Kembali</a>
          </div>
      </div>

      <div v-else-if="hasAccess">
          
          <!-- Loading -->
          <div v-if="loading" class="bg-white dark:bg-gray-800 rounded-3xl p-12 text-center shadow-xl border border-gray-100 dark:border-gray-700">
              <div class="relative w-24 h-24 mx-auto mb-6">
                  <div class="absolute inset-0 rounded-full border-4 border-gray-200 dark:border-gray-700"></div>
                  <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
              </div>
              <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Menyinkronkan Server...</h3>
              <p class="text-gray-500 dark:text-gray-400">Sedang mengambil pesan terbaru, harap tunggu sejenak.</p>
          </div>

          <!-- Fetch Error -->
          <div v-else-if="fetchError" class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-3xl p-10 text-center shadow-xl">
              <div class="w-20 h-20 bg-red-100 dark:bg-red-800/50 text-red-600 dark:text-red-400 mx-auto flex items-center justify-center rounded-full mb-6">
                  <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
              </div>
              <h3 class="text-2xl font-black text-red-800 dark:text-red-400 mb-2">Sinkronisasi Gagal</h3>
              <p class="text-red-600 dark:text-red-300 max-w-lg mx-auto mb-6">{{ fetchError }}</p>
              <button @click="fetchEmails" class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg transition-all hover:-translate-y-1">
                  Coba Ulangi
              </button>
          </div>

          <!-- Content List -->
          <div v-else class="space-y-4">
              <!-- Empty state -->
              <div v-if="emails.length === 0" class="bg-white dark:bg-gray-800 rounded-3xl p-16 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                  <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 mx-auto flex items-center justify-center rounded-full mb-6">
                      <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                  </div>
                  <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Inbox Kosong</h3>
                  <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Kami tidak dapat menemukan pesan OTP untuk produk ini. Pastikan sistem telah mengirimkannya.</p>
                  
                  <button @click="fetchEmails" class="mt-8 px-6 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold rounded-xl transition-all">
                      Refresh Data
                  </button>
              </div>

              <!-- Accordion Cards -->
              <div v-for="(email, index) in emails" :key="index" class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-800 transition-colors duration-200">
                  <button 
                      @click="toggleExpand(index)" 
                      class="w-full text-left px-6 py-5 focus:outline-none flex items-center justify-between group"
                  >
                      <div class="flex-1 pr-4">
                          <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug">{{ email.subject }}</h4>
                          <div class="mt-1 flex items-center text-xs font-semibold text-gray-500 dark:text-gray-400">
                              <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                              <span>{{ email.date }}</span>
                          </div>
                      </div>
                      <div class="flex-shrink-0 ml-4 h-10 w-10 bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center transition-transform duration-300" :class="{ 'rotate-180': expandedIndex === index }">
                          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                          </svg>
                      </div>
                  </button>
                  
                  <div 
                      v-show="expandedIndex === index" 
                      class="px-6 pb-6 pt-2 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50"
                  >
                      <div class="prose prose-sm md:prose max-w-none text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-inner overflow-x-auto whitespace-pre-wrap leading-relaxed break-words" v-html="email.body"></div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MainLayout from '../Layouts/MainLayout.vue';

const props = defineProps({
    product: Object,
    order: Object,
    errorMsg: String,
    hasAccess: Boolean
});

const loading = ref(true);
const emails = ref([]);
const fetchError = ref(null);
const expandedIndex = ref(null); 

const toggleExpand = (index) => {
    expandedIndex.value = expandedIndex.value === index ? null : index;
};

const fetchEmails = async () => {
    loading.value = true;
    fetchError.value = null;
    expandedIndex.value = null;
    
    try {
        const response = await axios.get(`/inbox/fetch/${props.product.id}`);
        emails.value = response.data.data;
        // The API backend already sorts by newest to oldest
        if (emails.value.length > 0) {
           expandedIndex.value = 0; // Automatically expand the newest (first) email
        }
    } catch (error) {
        if (error.response && error.response.data && error.response.data.error) {
            fetchError.value = error.response.data.error;
        } else {
            fetchError.value = "Terjadi kesalahan saat mengambil email. Silakan coba beberapa saat lagi.";
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    if (props.hasAccess && props.product) {
        fetchEmails();
    }
});
</script>