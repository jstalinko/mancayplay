<template>
    <div class="min-h-screen flex items-center justify-center p-4 bg-slate-950 text-slate-200">
        
        <div class="w-full max-w-md bg-slate-900 shadow-lg rounded-2xl p-6 sm:p-8 space-y-6">
            
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Token Generator</h1>
                <p class="text-slate-400 mt-2">Masukkan ticket Anda untuk mendapatkan token.</p>
            </div>

            <!-- Form submission handled by Vue -->
            <form @submit.prevent="generateToken" class="space-y-4">
                <div>
                    <label for="ticket" class="block text-sm font-medium text-slate-300 mb-1">Ticket</label>
                    <textarea 
                        v-model="ticket" 
                        id="ticket"
                        placeholder="Contoh: JKV2-..." 
                        class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200"
                        :disabled="isLoading"
                    >
                    </textarea>
                </div>

                <button 
                    type="submit" 
                    class="w-full flex justify-center items-center px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 disabled:bg-indigo-400 disabled:cursor-not-allowed"
                    :disabled="isLoading"
                >
                    <!-- Loading spinner -->
                    <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ isLoading ? 'Memproses...' : 'Generate Token' }}</span>
                </button>
            </form>

            <!-- Result Section -->
            <div v-if="token || error" class="border-t border-slate-800 pt-4">
                <!-- Success Message -->
                <div v-if="token" class="space-y-3">
                    <h3 class="text-lg font-semibold text-white">Hasil Token:</h3>
                    <div class="relative p-4 bg-black/20 rounded-lg">
                        <pre class="text-sm text-green-400 font-mono break-all whitespace-pre-wrap">{{ token }}</pre>
                        
                        <!-- Copy Button -->
                        <button @click="copyToken" class="absolute top-2 right-2 p-2 bg-slate-800 rounded-md hover:bg-slate-700 transition">
                             <span v-if="copySuccess" class="text-xs font-bold text-indigo-400">Copied!</span>
                             <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="error" class="p-4 bg-red-900/20 border border-red-500/30 rounded-lg">
                    <p class="text-sm font-medium text-red-400">
                        <span class="font-bold">Error:</span> {{ error }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Reactive state variables
const ticket = ref('');
const token = ref(null);
const error = ref(null);
const isLoading = ref(false);
const copySuccess = ref(false);
const prop = defineProps({type: String, user_id:Number});

// API endpoint from your Laravel setup
const API_URL = '/api/token-generator'; // Change if your URL is different

/**
 * Handles the form submission to generate a token.
 */
const generateToken = async () => {
    if (!ticket.value.trim()) {
        error.value = "Kolom ticket tidak boleh kosong.";
        return;
    }

    // Reset state before new request
    isLoading.value = true;
    token.value = null;
    error.value = null;

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                ticket: ticket.value,
                user_id: prop.user_id,
                type: prop.type,
            })
        });
        
        const result = await response.json();

        if (!response.ok) {
             // Handle HTTP errors (e.g., 400, 500)
            throw new Error(result.message || `HTTP error! Status: ${response.status}`);
        }

        // Set token on success
        token.value = result.data.token;

    } catch (e) {
        console.error('Fetch error:', e);
        error.value = e.message || 'Gagal menghubungi server. Silakan coba lagi.';
    } finally {
        // Ensure loading state is always turned off
        isLoading.value = false;
    }
};

/**
 * Copies the generated token to the clipboard.
 */
const copyToken = () => {
    if (!token.value) return;

    navigator.clipboard.writeText(token.value).then(() => {
        copySuccess.value = true;
        // Reset button text after 2 seconds
        setTimeout(() => {
            copySuccess.value = false;
        }, 2000);
    }).catch(err => {
        console.error('Could not copy text: ', err);
        // You could show an error message here if needed
    });
};
</script>

<style scoped>
/* Any component-specific styles would go here. */
/* Tailwind handles most of it, but you can add overrides. */
</style>

