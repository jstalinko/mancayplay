<x-filament-panels::page>
    <div class="mx-auto max-w-4xl">
        {{-- Tombol Kembali ke Daftar Tutorial --}}
        <div class="mb-6">
            <x-filament::link
                href="/dashboard/tutorial" {{-- Arahkan ke halaman list-card Anda --}}
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


            {{-- ================================================ --}}
            {{-- ## BLOK KODE BARU UNTUK YOUTUBE DIMULAI DI SINI ## --}}
            {{-- ================================================ --}}

            {{-- Tampilkan Video YouTube jika field 'embed_youtube' tidak kosong --}}
            
            @if(!empty($record->embed_youtube))
                <div class="my-6 aspect-video border-2 border-gray-200  overflow-hidden rounded-xl shadow-lg ring-1 ring-gray-950/5 w-full" style="min-height:500px">
                    <iframe
                        class="h-full w-full"
                        src="{{ $record->embed_youtube }}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            @endif

            {{-- ================================================ --}}
            {{-- ## BLOK KODE BARU UNTUK YOUTUBE SELESAI DI SINI ## --}}
            {{-- ================================================ --}}

        </article>
    </div>
</x-filament-panels::page>
