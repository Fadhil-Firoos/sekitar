<x-filament::page>
    @php
        $toko = $this->getToko();
    @endphp

    @if ($toko && $toko->info_admin)
        <div class="p-6 bg-white rounded-2xl shadow text-gray-800">
            <h2 class="text-lg font-semibold mb-3 text-gray-900">Status Akun</h2>
            <p class="whitespace-pre-line leading-relaxed">
                {{ $toko->info_admin }}
            </p>
            <p class="mt-4 text-sm text-gray-500">
                <em>Terakhir diperbarui: {{ $toko->updated_at->format('d F Y, H:i') }}</em>
            </p>
        </div>
    @else
        <div class="p-6 bg-gray-100 rounded-2xl text-center text-gray-600">
            Belum ada informasi dari admin saat ini.
        </div>
    @endif
</x-filament::page>
