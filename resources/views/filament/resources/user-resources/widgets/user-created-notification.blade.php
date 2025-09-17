<x-filament-widgets::widget>
    <x-filament::section>
        {{-- 
            Data $email dan $password dikirim dari class Widget PHP Anda.
            Contoh:
            public ?string $email = 'user@example.com';
            public ?string $password = 'S3cr3tP@ssw0rd!';
        --}}
        @if ($email && $password)
            <div 
                class="p-4"
                x-data="{
                    copied: false,
                    copyToClipboard() {
                        // Mengambil teks dari dalam blok <pre>
                        navigator.clipboard.writeText(this.$refs.textBlock.innerText);
                        // Memberi feedback visual
                        this.copied = true;
                        setTimeout(() => { this.copied = false }, 2500);
                    }
                }"
            >
                {{-- Pesan Sukses --}}
                <div class="flex items-center justify-between gap-x-3">
                    <div class="flex items-center gap-x-3">
                        <x-filament::icon
                            icon="heroicon-o-check-circle"
                            class="h-8 w-8 text-success-500"
                        />
                        <h2 class="text-xl font-semibold tracking-tight text-gray-950 dark:text-white">
                            User created successfully!
                        </h2>
                    </div>

                    {{-- Tombol Salin Semua --}}
                    <x-filament::button
                        color="gray"
                        x-on:click="copyToClipboard"
                    >
                        <span x-show="!copied">
                             <x-filament::icon
                                icon="heroicon-o-clipboard-document"
                                class="h-5 w-5"
                            />
                            <span>Salin Semua</span>
                        </span>

                        <span x-show="copied" x-cloak>
                            <x-filament::icon
                                icon="heroicon-o-check"
                                class="h-5 w-5 text-success-500"
                            />
                            <span class="text-success-500">Tersalin!</span>
                        </span>
                    </x-filament::button>
                </div>

                {{-- Blok Teks untuk Disalin --}}
                <div class="mt-4">
                    <pre x-ref="textBlock" class="block w-full rounded-lg bg-gray-100 p-4 font-mono text-sm text-gray-800 dark:bg-gray-800 dark:text-gray-300">
User details:
Email:    {{ $email }}
Password: {{ $password }}

Login ke https://mancaplay.com/dashboard untuk akses lisensi game anda!
                    </pre>
                </div>

            </div>
        @else
            {{-- Pesan jika tidak ada data user --}}
            <div class="p-4 text-center text-gray-500">
                <p>No user information to display.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>