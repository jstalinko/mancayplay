<x-filament-panels::page>
    <div class="mx-auto max-w-4xl">
        {{-- Tombol Kembali ke Daftar Tutorial --}}
        <div class="mb-6">
            <x-filament::link
                :href="static::getResource()::getUrl('tutorials')" {{-- Arahkan ke halaman list-card Anda --}}
                icon="heroicon-m-arrow-left"
            >
                Kembali ke daftar tutorial
            </x-filament::link>
        </div>

        {{-- Konten Artikel --}}
        <article class="space-y-4">
            {{-- Judul Utama Artikel --}}
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $record->title }}
            </h1>

            {{-- Meta Data: Tanggal Posting --}}
            <div class="flex items-center gap-x-2 text-sm text-gray-500 dark:text-gray-400">
                <x-filament::icon icon="heroicon-o-calendar-days" class="h-5 w-5" />
                <span>
                    Dipublikasikan pada {{ $record->created_at->format('d F Y') }}
                </span>
            </div>
            
            <hr class="dark:border-gray-700"/>

            {{-- Isi Konten --}}
            {{-- Class 'prose' dari Tailwind akan otomatis menata HTML (h2, p, ul, dll.) menjadi format artikel yang indah --}}
            <div class="prose max-w-none dark:prose-invert">
                {!! $record->content !!}
            </div>
        </article>
    </div>
</x-filament-panels::page>