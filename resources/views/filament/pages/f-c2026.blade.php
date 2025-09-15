<x-filament-panels::page>
    <div class="space-y-8">
        <!-- Bagian Logo -->
        <div class="flex justify-center pt-4 pb-8 mb-5 ">
              <img src="{{ asset('fc/fc26-black.png') }}" alt="FC 2026 Logo"  style="max-width:500px;max-height:200px" class="bg-white rounded-lg" />
        </div>

        <!-- Grid untuk Action Cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

            <!-- Card 1: Download File -->
            <a href="{{config('setting.fc2026_download_link')}}" 
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-primary-50 dark:bg-primary-500/10 rounded-lg">
                        <x-heroicon-o-arrow-down-tray class="w-8 h-8 text-primary-500" />
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Download File</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Download file game anda klik disini</p>
                    </div>
                </div>
            </a>

            <!-- Card 2: Generate Token -->
            <a href="/" {{-- Ganti dengan wire:click action --}}
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-primary-50 dark:bg-primary-500/10 rounded-lg">
                        <x-heroicon-o-key class="w-8 h-8 text-primary-500" />
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Generate Token</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Buat token key baru</p>
                    </div>
                </div>
            </a>

            <!-- Card 3: Discord -->
            <a href="{{config('setting.fc2026_discord_link')}}" {{-- Ganti dengan link undangan Discord Anda --}} target="_blank"
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg">
                        {{-- SVG Ikon Discord --}}
                        <svg class="w-8 h-8 text-indigo-500" role="img" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <title>Discord</title>
                            <path fill="currentColor"
                                d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4464.8245-.6667 1.2834a18.2366 18.2366 0 00-5.3164 0c-.2203-.4589-.4557-.9081-.6667-1.2834a.0741.0741 0 00-.0785-.0371 19.8353 19.8353 0 00-4.8851 1.5152.0691.0691 0 00-.0321.0253C1.043 9.6801.3266 14.8647.0863 19.839a.0814.0814 0 00.0814.0824h.2312c.6762-.5775 1.332-1.1447 1.964-1.6923a.0741.0741 0 00.0133-.0371c-.3473-.8348-.65-1.6923-.9022-2.569a.0741.0741 0 00-.0651-.046c-.4557.0093-.8931.0929-1.311.2483a.0741.0741 0 00-.0466.0651c.0285.4589.0929.9082.2017 1.3479a.0741.0741 0 00.0651.0554c.6667.1866 1.332.3361 2.017.4589a.0741.0741 0 00.0839-.0277c.474-4.0074 1.8082-7.5233 4.237-10.4018a.0741.0741 0 00.0133-.0466l-.3728-.4303c-.0047-.0093-.0047-.0277 0-.0371a.0741.0741 0 00.0514-.0466c.2203-.238.4406-.476.6762-.7047a.0741.0741 0 00.0328-.0554c.0651-.1021.1395-.195.2139-.288a.0741.0741 0 00-.0133-.1022c-.2203-.1586-.4557-.3078-.6945-.4471a.0741.0741 0 00-.0886-.0093c-.4321.2146-.8459.4656-1.2415.7533a.0741.0741 0 00-.042.0651c-.0186.13-.0371.2693-.0554.4082a.0741.0741 0 00.042.0839c.8837.4942 1.7487 1.0163 2.5855 1.5753a.0741.0741 0 00.0933-.0046c.3912-.288.7731-.5946 1.1364-.9282a.0741.0741 0 00.0186-.0839c-.0651-.238-.13-.4853-.1924-.7326a.0741.0741 0 00-.0741-.0651c-.2203.0186-.4406.0466-.6667.0839a.0741.0741 0 00-.0651.0839c-.0093.1114-.0093.2228.0093.3342a.0741.0741 0 00.0651.0651c.2488.0466.5068.0839.7741.1114a.0741.0741 0 00.0788-.0554c.0554-.1866.1021-.3753.1488-.564a.0741.0741 0 00-.0047-.0839c-.1114-.0839-.2203-.1678-.3361-.2483a.0741.0741 0 00-.0933 0l-.3078.2052a.0741.0741 0 00-.042.0651c-.0554.2287-.1021.4589-.1582.6879a.0741.0741 0 00.042.0839c.1395.0651.288.1114.4363.1586a.0741.0741 0 00.0839-.0277l.2581-.288c.0186-.0186.0371-.0466.0554-.0651a17.9619 17.9619 0 006.5824 0c.0186.0186.0371.0466.0554.0651l.2581.288a.0741.0741 0 00.0839.0277c.1488-.0466.2973-.0929.4363-.1586a.0741.0741 0 00.042-.0839c-.0554-.2287-.1021-.4589-.1582-.6879a.0741.0741 0 00-.042-.0651l-.3078-.2052a.0741.0741 0 00-.0933 0c-.1158.0805-.2246.1643-.3361.2483a.0741.0741 0 00-.0047.0839c.0466.1887.0933.3774.1488.564a.0741.0741 0 00.0788.0554c.2673-.0277.5253-.0651.7741-.1114a.0741.0741 0 00.0651-.0651c.0186-.1114.0186-.2228.0093-.3342a.0741.0741 0 00-.0651-.0839c-.2203-.0371-.4406-.0651-.6667-.0839a.0741.0741 0 00-.0741.0651c-.0651.2473-.1258.4946-.1924.7326a.0741.0741 0 00.0186.0839c.3632.3336.7451.6398 1.1364.9282a.0741.0741 0 00.0933.0046c.8368-.5589 1.7018-1.0811 2.5855-1.5753a.0741.0741 0 00.042-.0839c-.0186-.1393-.0371-.2786-.0554-.4082a.0741.0741 0 00-.042-.0651c-.3956-.2877-.8095-.5387-1.2415-.7533a.0741.0741 0 00-.0886.0093c-.2388.1393-.4742.288-.6945.4471a.0741.0741 0 00-.0133.1022c.0744.0929.1488.1866.2139.288a.0741.0741 0 00.0328.0554c.2356.2287.4559.4667.6762.7047a.0741.0741 0 00.0514.0466c.0047.0093.0047.0277 0 .0371l-.3728.4303a.0741.0741 0 00.0133.0466c2.4288 2.8785 3.763 6.3944 4.237 10.4018a.0741.0741 0 00.0839.0277c.6854-.1228 1.3504-.2715 2.017-.4589a.0741.0741 0 00.0651-.0554c.1088-.4397.1732-.889.2017-1.3479a.0741.0741 0 00-.0466-.0651c-.4179-.1554-.8554-.238-1.311-.2483a.0741.0741 0 00-.0651.046c-.2522.8767-.5549 1.7345-.9022 2.569a.0741.0741 0 00.0133.0371c.632.5476 1.2878 1.1148 1.964 1.6923h.2312a.0814.0814 0 00.0814-.0824c-.2403-4.9743-.9567-10.1589-3.6791-15.444a.0691.0691 0 00-.0321-.0253z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Komunitas Discord</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Gabung diskusi & support</p>
                    </div>
                </div>
            </a>

            <!-- Card 4: Whatsapp Admin -->
            <a href="{{config('setting.fc2025_whatsapp_link')}}" {{-- Ganti dengan link wa.me Anda --}} target="_blank"
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-50 dark:bg-green-500/10 rounded-lg">
                        {{-- SVG Ikon WhatsApp --}}
                        <svg class="w-8 h-8 text-green-500" role="img" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <title>WhatsApp</title>
                            <path fill="currentColor"
                                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.79.46 3.48 1.34 4.94l-1.48 5.45 5.59-1.45c1.41.83 3.01 1.3 4.7 1.3h.01c5.46 0 9.91-4.45 9.91-9.91 0-5.46-4.45-9.91-9.92-9.91zM17.48 15.38c-.28-.14-1.66-.82-1.92-.91-.26-.1-.45-.14-.64.14-.19.28-.73.91-.89 1.1-.16.18-.32.2-.6.07-.28-.14-1.18-.43-2.25-1.38-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.19-.28.28-.46.1-.18.05-.33-.02-.46-.07-.14-.64-1.53-.87-2.1-.23-.57-.47-.49-.64-.5-.17-.01-.36-.01-.54-.01-.18 0-.47.07-.71.35-.24.28-.93.9-1.14 2.18-.21 1.28.13 2.52.41 2.8.28.28 1.83 2.89 4.44 3.93.61.24 1.09.38 1.47.49.72.21 1.37.18 1.87.11.57-.08 1.66-.68 1.89-1.34.24-.66.24-1.22.17-1.34-.07-.12-.26-.18-.54-.32z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Hubungi Admin</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Via WhatsApp</p>
                    </div>
                </div>
            </a>
            <a href="{{config('setting.fc2026_title_update_link')}}" {{-- Ganti dengan link wa.me Anda --}} target="_blank"
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-50 dark:bg-green-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Title Update</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Download title update terbaru</p>
                    </div>
                </div>
            </a>
            <a href="/dashboard/tutorial" {{-- Ganti dengan link wa.me Anda --}} target="_blank"
                class="block p-6 text-gray-900 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-50 dark:bg-green-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                        </svg>

                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Tutorial</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tonton tutorial</p>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-filament-panels::page>
