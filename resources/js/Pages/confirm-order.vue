<template>
  <MainLayout title="Konfirmasi Pesanan">
    
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-400 border-2 border-blue-600 text-neutral rounded-xl p-4 mb-2">
<b>[KONFIRMASI PESANAN]</b>
<ul>
<li> Untuk konfirmasi pesanan jika anda sudah terdaftar sebagai member di mancayplay.com, maka masukan email yang terdaftar di mancayplay.com</li>
<li> Jika tidak terdaftar sebagai member, maka masukan email yang aktif.</li>
</ul>
    </div>
        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-500">
            <div class="flex flex-col lg:flex-row">
                <!-- Left Side: Product Info (Fixed/Sticky on Desktop) -->
                <div class="lg:w-1/3 bg-gray-50 dark:bg-gray-800/50 p-8 lg:p-12 border-b lg:border-b-0 lg:border-r border-gray-100 dark:border-gray-800">
                    <h2 class="text-xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-wider">Detail Produk</h2>
                    
                    <div v-if="selectedProduct" class="space-y-6">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                            <img :src="imageUrl(selectedProduct.image)" :alt="selectedProduct.name" class="relative w-full aspect-square object-cover rounded-2xl shadow-lg">
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100 leading-tight mb-2">{{ selectedProduct.name }}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4 prose prose-sm dark:prose-invert [&>p]:mb-0" v-html="selectedProduct.short_description"></div>
                            <div class="flex items-center justify-between py-4 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Bayar</span>
                                <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ formatCurrency(selectedProduct.price) }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex flex-col items-center justify-center h-full py-12 text-center">
                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Pilih produk terlebih dahulu untuk melihat detail</p>
                    </div>
                </div>
                <!-- Right Side: Content -->
                <div class="lg:w-2/3 p-8 lg:p-12">
                    <div v-if="isSuccess" class="py-20 flex flex-col items-center text-center animate-fade-in">
                        <div class="w-24 h-24 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-8 relative">
                            <div class="absolute inset-0 bg-emerald-500 rounded-full animate-ping opacity-20"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-4">Terima Kasih!</h1>
                        <p class="text-xl text-gray-500 dark:text-gray-400 font-medium mb-10 max-w-md">
                            Konfirmasi berhasil, anda akan kami kabari via whatsapp untuk detail akun member anda.
                        </p>
                        <Link href="/" class="px-10 py-4 bg-indigo-600 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-indigo-600/30 hover:bg-indigo-700 transition-all flex items-center gap-3 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Kembali ke Beranda
                        </Link>
                    </div>

                    <div v-else>
                        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2 leading-tight">Konfirmasi Pesanan</h1>
                        <p class="text-gray-500 dark:text-gray-400 mb-10">Lengkapi formulir di bawah ini untuk mengirim bukti pembayaran Anda.</p>
                        
                        <form @submit.prevent="submitForm" class="space-y-8">
                            <!-- Product Selection -->
                            <div class="relative">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Produk</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        v-model="searchQuery"
                                        @focus="showDropdown = true"
                                        placeholder="Cari nama produk..."
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-gray-900 dark:text-white font-bold ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-600 transition-all outline-none"
                                    />
                                    <div v-if="showDropdown && filteredProducts.length > 0" class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden max-h-60 overflow-y-auto">
                                        <div 
                                            v-for="p in filteredProducts" 
                                            :key="p.id" 
                                            @click="selectProduct(p)"
                                            class="px-5 py-4 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 cursor-pointer transition-colors flex items-center gap-4"
                                        >
                                            <img :src="imageUrl(p.image)" class="w-10 h-10 rounded-lg object-cover">
                                            <div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ p.name }}</div>
                                                <div class="text-xs text-indigo-600 font-bold">{{ formatCurrency(p.price) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.errors.product_id" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.product_id }}</div>
                            </div>
    
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Order Type -->
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Order Via</label>
                                    <select 
                                        v-model="form.order_type"
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-gray-900 dark:text-white font-bold ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-600 transition-all outline-none appearance-none"
                                    >
                                        <option value="web">Website</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="shopee">Shopee</option>
                                        <option value="lynkid">Lynk.id</option>
                                    </select>
                                    <div v-if="form.errors.order_type" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.order_type }}</div>
                                </div>
    
                                <!-- Customer Name -->
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                    <input 
                                        v-model="form.customer_name"
                                        type="text"
                                        placeholder="Masukkan nama Anda"
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-gray-900 dark:text-white font-bold ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-600 transition-all outline-none"
                                    />
                                    <div v-if="form.errors.customer_name" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.customer_name }}</div>
                                </div>
    
                                <!-- Email -->
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                                    <input 
                                        v-model="form.customer_email"
                                        type="email"
                                        placeholder="Alamat email Anda"
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-gray-900 dark:text-white font-bold ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-600 transition-all outline-none"
                                    />
                                    <div v-if="form.errors.customer_email" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.customer_email }}</div>
                                </div>
    
                                <!-- Phone -->
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone / WhatsApp</label>
                                    <input 
                                        v-model="form.customer_phone"
                                        type="text"
                                        placeholder="0812xxxx"
                                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-gray-900 dark:text-white font-bold ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-600 transition-all outline-none"
                                    />
                                    <div v-if="form.errors.customer_phone" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.customer_phone }}</div>
                                </div>
                            </div>
    
                            <!-- Payment Proof -->
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Bukti Pembayaran</label>
                                <div class="flex items-center gap-6 p-6 bg-gray-50 dark:bg-gray-800 rounded-[1.5rem] border-2 border-dashed border-gray-200 dark:border-gray-700">
                                    <div v-if="previewUrl" class="relative w-24 h-24 flex-shrink-0">
                                        <img :src="previewUrl" class="w-full h-full object-cover rounded-xl shadow-md">
                                        <button @click="clearFile" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-lg hover:bg-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div v-else class="w-24 h-24 flex-shrink-0 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Unggah file bukti bayar</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">JPG, PNG, JPEG, HEIC, WEBP (Maks. 2MB)</p>
                                        <input 
                                            type="file" 
                                            ref="fileInput"
                                            @change="handleFileChange"
                                            class="hidden"
                                            accept="image/*"
                                        />
                                        <button 
                                            type="button"
                                            @click="$refs.fileInput.click()"
                                            class="text-xs font-black bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all shadow-sm"
                                        >
                                            Pilih File
                                        </button>
                                    </div>
                                </div>
                                <div v-if="form.errors.payment_proof" class="mt-2 text-sm text-red-500 font-bold ml-1">{{ form.errors.payment_proof }}</div>
                            </div>
    
                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button 
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full relative group overflow-hidden bg-indigo-600 text-white py-5 rounded-[1.5rem] font-black text-lg shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:bg-indigo-700 transition-all active:scale-95 disabled:opacity-75 disabled:cursor-not-allowed"
                                >
                                    <div class="absolute inset-0 w-0 bg-white/20 transition-all duration-300 group-hover:w-full"></div>
                                    <span v-if="form.processing" class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                    <span v-else>Konfirmasi Pesanan Sekarang</span>
                                </button>
                                <Link href="/" class="block text-center mt-6 text-sm font-bold text-gray-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">Batalkan dan Kembali</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </MainLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import MainLayout from '../Layouts/MainLayout.vue';
import { formatCurrency, imageUrl } from '../utils/helpers';

const props = defineProps({
    product: Object, // Single product if passed via route param
    products: Array, // All products for search dropdown
});

const isSuccess = ref(false);

const form = useForm({
    product_id: props.product?.id || '',
    order_type: 'web',
    customer_name: '',
    customer_email: '',
    customer_phone: '',
    payment_proof: null,
});

// Searchable Product Logic
const searchQuery = ref(props.product?.name || '');
const showDropdown = ref(false);
const filteredProducts = computed(() => {
    if (!searchQuery.value) return props.products || [];
    return (props.products || []).filter(p => 
        p.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const selectedProduct = computed(() => {
    if (form.product_id) {
        return (props.products || []).find(p => p.id === form.product_id) || props.product;
    }
    return null;
});

const selectProduct = (p) => {
    form.product_id = p.id;
    searchQuery.value = p.name;
    showDropdown.value = false;
};

// File Handling
const previewUrl = ref(null);
const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.payment_proof = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};
const clearFile = () => {
    form.payment_proof = null;
    previewUrl.value = null;
};

const submitForm = () => {
    form.post('/confirm-order', {
        forceFormData: true,
        onSuccess: () => {
            isSuccess.value = true;
            form.reset();
            clearFile();
        },
    });
};

// Close dropdown on click outside
onMounted(() => {
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.relative')) {
            showDropdown.value = false;
        }
    });
});
</script>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}
</style>