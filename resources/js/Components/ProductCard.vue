<template>
  <div 
    class="group relative aspect-[3/4] overflow-hidden rounded-2xl md:rounded-[2rem] bg-gray-900 border border-white/10 shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(79,70,229,0.3)] shadow-black/50"
  >
    <!-- Background Image -->
    <img 
      class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-110 opacity-70 group-hover:opacity-100" 
      :src="imageUrl(product.image)" 
      :alt="product.name"
    >
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent transition-opacity duration-500 opacity-90 group-hover:opacity-100"></div>

    <!-- Content Hook (Fixed Bottom) -->
    <div class="absolute inset-0 flex flex-col justify-end p-2 md:p-8">
      
      <!-- Category & Price Header -->
      <div class="flex justify-between items-start mb-1 md:mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
        <span class="backdrop-blur-md bg-white/10 border border-white/20 text-white text-[7px] md:text-[10px] font-bold px-1.5 md:px-3 py-0.5 md:py-1.5 rounded-full uppercase tracking-widest shadow-xl">
          {{ product.category ?? 'no category' }}
        </span>
        <div class="text-right">
            <span class="block text-[7px] md:text-[10px] text-indigo-300 font-bold uppercase tracking-tighter mb-0 md:mb-0.5">Price</span>
            <span class="text-[11px] md:text-2xl font-black text-white leading-none">
                {{ product.price == 0 ? 'Free' : formatCurrency(product.price) }}
            </span>
        </div>
      </div>

      <!-- Title & Description -->
      <div class="mb-2 md:mb-6 transform transition-all duration-500">
        <h3 class="text-[10px] md:text-2xl font-black text-white mb-0.5 md:mb-2 line-clamp-2 leading-tight group-hover:text-indigo-300 transition-colors">
          {{ product.name }}
        </h3>
        <div v-if="product.short_description" class="hidden md:block text-sm text-gray-300 line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-700 delay-100 prose prose-sm prose-invert [&>p]:mb-0" v-html="product.short_description">
        </div>
      </div>

      <!-- Actions (Fixed at Bottom on Hover) -->
      <div class="flex flex-col gap-1 md:gap-3 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500 ease-out pt-2 md:pt-4 border-t border-white/10">
        <Link 
            :href="`/confirm-order/`+product.id" 
            class="w-full py-1 md:py-3.5 px-2 md:px-4 bg-indigo-600 hover:bg-indigo-500 text-white text-center font-black rounded-lg md:rounded-2xl shadow-lg shadow-indigo-600/30 transition-all active:scale-95 text-[8px] md:text-sm"
        >
          Konfirmasi Pesanan
        </Link>
        <a 
            :href="product.link" 
            target="_blank" 
            class="w-full py-1 md:py-3.5 px-2 md:px-4 backdrop-blur-md bg-white/10 hover:bg-white/20 border border-white/20 text-white text-center font-bold rounded-lg md:rounded-2xl transition-all active:scale-95 text-[8px] md:text-sm"
        >
          Beli Langsung
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { formatCurrency, imageUrl } from '../utils/helpers';
import { Link } from '@inertiajs/vue3';

defineProps({
  product: {
    type: Object,
    required: true
  }
});
</script>
