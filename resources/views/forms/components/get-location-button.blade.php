<div x-data>
<!-- Button yang adaptif untuk tema terang dan gelap -->
<div class="flex justify-center mb-4">
    <!-- Button dengan tulisan yang adaptif sesuai tema -->
<button 
    type="button" 
    x-on:click="getLocation()" 
    class="inline-flex items-center justify-center gap-2 
           px-6 py-3 
           
           /* Background transparan atau mengikuti parent */
           bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800
           
           /* Tema Terang: Tulisan HITAM */
           text-gray-900 hover:text-black
           
           /* Tema Gelap: Tulisan PUTIH */
           dark:text-white dark:hover:text-gray-100
           
           font-semibold 
           rounded-lg 
           transition-all duration-200 ease-in-out
           focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600
           border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500"
>
    <!-- Ikon Lokasi yang ikut warna tulisan -->
    <svg xmlns="http://www.w3.org/2000/svg" 
         fill="currentColor" 
         viewBox="0 0 24 24" 
         class="w-5 h-5">
        <path d="M12 21c4.97-4.97 7-9 7-12a7 7 0 10-14 0c0 3 2.03 7.03 7 12z"/>
    </svg>
    
    Bagikan Lokasi Saya
</button>
</div>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude.toFixed(6);
                        const longitude = position.coords.longitude.toFixed(6);
                        
                        // Update state form Filament/Livewire secara otomatis
                        @this.set('data.latitude', latitude);
                        @this.set('data.longitude', longitude);
                        
                        // Optional: Tampilkan notifikasi sukses
                        alert('Lokasi berhasil diambil!\nLatitude: ' + latitude + '\nLongitude: ' + longitude);
                    },
                    (error) => {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin lokasi ditolak.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Waktu request lokasi habis.';
                                break;
                            default:
                                errorMessage += error.message;
                                break;
                        }
                        alert(errorMessage);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                alert('Geolocation tidak didukung oleh browser ini.');
            }
        }
    </script>

    <!-- Optional: Tampilkan preview lokasi setelah diisi (bisa dihapus jika tidak perlu) -->
    <div class="mt-2 text-sm text-gray-600" x-show="$wire.data.latitude && $wire.data.longitude">
        {{-- <p><strong>Lokasi Terkini:</strong></p>
        <p>Latitude: <span x-text="$wire.data.latitude"></span></p>
        <p>Longitude: <span x-text="$wire.data.longitude"></span></p> --}}
        <!-- Optional: Link ke Google Maps -->
        <a :href="'https://www.google.com/maps?q=' + $wire.data.latitude + ',' + $wire.data.longitude" target="_blank" class="text-blue-600 hover:underline">Lihat di Google Maps</a>
    </div>
</div>