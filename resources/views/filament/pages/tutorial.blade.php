<x-filament-panels::page>
    {{-- 
        Anda perlu mengirimkan data tutorial dari class Page PHP Anda.
        Contohnya, sebuah variabel bernama $tutorials yang berisi collection
        dari model Tutorial Anda.
    --}}
    
    {{-- Grid Container --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

        {{-- Loop melalui setiap tutorial --}}
        @forelse ($tutorials as $tutorial)
            <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                
                {{-- Bagian Header Kartu --}}
                <div class="flex items-center gap-x-4 border-b border-gray-950/5 px-4 py-3 dark:border-white/10">
                    <div class="flex-shrink-0">
                        {{-- Ikon Video --}}
                        <x-filament::icon
                            icon="heroicon-o-video-camera"
                            class="h-7 w-7 text-gray-400 dark:text-gray-500"
                        />
                    </div>
                    <div class="flex-1">
                        {{-- Judul Artikel --}}
                        <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            {{ $tutorial->title }}
                        </h3>
                        {{-- Tanggal Dibuat --}}
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $tutorial->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- Bagian Konten Kartu --}}
                <div class="flex-grow p-4 text-sm text-gray-600 dark:text-gray-400">
                    {{-- Potongan Konten (Excerpt) --}}
                    <p>
                        {{ \Illuminate\Support\Str::substr($tutorial->content, 0, 150) }}...
                    </p>
                </div>

     
                {{-- Bagian Footer/Aksi Kartu --}}
                <div class="border-t border-gray-950/5  px-4 py-3 dark:border-white/10 dark:bg-gray-950/50">
                     <x-filament::link 
                        href="{{\App\Filament\Pages\TutorialUserView::getUrl(['record' => $tutorial])}}" {{-- Ganti dengan route Anda --}}
                        icon="heroicon-m-arrow-right"
                        icon-position="after"
                     >
                        Baca Selengkapnya
                     </x-filament::link>
                </div>
            </div>
        @empty
            {{-- Tampilan jika tidak ada tutorial --}}
            <div class="col-span-full flex flex-col items-center justify-center gap-y-4 rounded-lg border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-600">
                <div class="rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                    <x-filament::icon
                        icon="heroicon-o-book-open"
                        class="h-8 w-8 text-gray-500"
                    />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Tutorial</h3>
                <p class="text-sm text-gray-500">Silakan tambahkan tutorial baru untuk menampilkannya di sini.</p>
            </div>
        @endforelse

    </div>
</x-filament-panels::page>