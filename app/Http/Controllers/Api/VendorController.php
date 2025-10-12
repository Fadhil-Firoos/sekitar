<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorController extends Controller
{
    /**
     * Get all public vendors/tokos for map display
     */
    public function index()
    {
        try {
            // Cache the results for 5 minutes to improve performance
            $vendors = Cache::remember('public_vendors', 300, function () {
                return $this->getPublicVendors();
            });

            Log::info('API /vendors called', [
                'vendor_count' => count($vendors),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data vendors berhasil diambil',
                'data' => $vendors,
                'count' => count($vendors),
                'timestamp' => now()->toISOString()
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in VendorController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data vendors',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vendors with search functionality
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $lat = $request->get('lat');
            $lng = $request->get('lng');
            $radius = $request->get('radius', 10); // km

            $vendors = $this->searchVendors($query, $lat, $lng, $radius);

            return response()->json([
                'success' => true,
                'message' => 'Pencarian berhasil',
                'data' => $vendors,
                'count' => count($vendors),
                'query' => $query
            ]);
        } catch (\Exception $e) {
            Log::error('Error in search', [
                'error' => $e->getMessage(),
                'query' => $request->get('q', '')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pencarian gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single vendor details
     */
    public function show($id)
    {
        try {
            $toko = Toko::public()->findOrFail($id);
            $vendor = $this->transformVendor($toko);

            return response()->json([
                'success' => true,
                'data' => $vendor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Test endpoint for debugging
     */
    public function test()
    {
        try {
            $dbStats = $this->getDatabaseStats();

            return response()->json([
                'success' => true,
                'message' => 'API endpoint berfungsi dengan baik',
                'timestamp' => now()->toISOString(),
                'database_stats' => $dbStats,
                'system_info' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'environment' => config('app.env'),
                    'cache_driver' => config('cache.default')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Clear vendors cache
     */
    public function clearCache()
    {
        try {
            Cache::forget('public_vendors');
            Cache::forget('vendor_locations_tracking');
            Cache::forget('vendor_locations_cached');

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * =============================================
     * TRACKING REAL-TIME METHODS
     * =============================================
     */

    /**
     * Get vendor locations for real-time tracking
     * 
     * Endpoint: GET /api/vendors/locations
     * Returns: Minimal vendor data for tracking (id, nama, latitude, longitude, jam_buka, jam_tutup)
     */
    public function getVendorLocations(): JsonResponse
    {
        try {
            // Ambil data vendor dengan kolom minimal yang diperlukan untuk tracking
            $vendors = Toko::select([
                'id',
                'nama_toko as nama',
                'latitude',
                'longitude',
                'buka_jam as jam_buka',
                'tutup_jam as jam_tutup',
                'nomor_wa as whatsapp',
                'informasi',
                'status',
                'updated_at'
            ])
                ->where('status', 'active') // Hanya vendor yang aktif
                ->whereNotNull('latitude')  // Hanya yang punya koordinat
                ->whereNotNull('longitude')
                ->get()
                ->map(function ($vendor) {
                    // Format response yang konsisten
                    return [
                        'id' => $vendor->id,
                        'nama' => $vendor->nama,
                        'latitude' => (float) $vendor->latitude,
                        'longitude' => (float) $vendor->longitude,
                        'jam_buka' => $this->formatTime($vendor->jam_buka),
                        'jam_tutup' => $this->formatTime($vendor->jam_tutup),
                        'whatsapp' => $this->formatWhatsAppNumber($vendor->whatsapp),
                        'informasi' => $vendor->informasi ?? 'Berbagai menu tersedia',
                        'status' => $vendor->status,
                        'last_updated' => $vendor->updated_at->toISOString(),
                        'is_open' => $this->isVendorOpen($vendor->jam_buka, $vendor->jam_tutup)
                    ];
                });

            Log::info('Vendor locations fetched for tracking', [
                'count' => $vendors->count(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'data' => $vendors,
                'count' => $vendors->count(),
                'timestamp' => now()->toISOString(),
                'message' => 'Data lokasi vendor berhasil diambil'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching vendor locations: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lokasi vendor: ' . $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Get vendor locations with caching for better performance
     * 
     * Endpoint: GET /api/vendors/locations/cached
     * Returns: Cached vendor locations (1 minute cache)
     */
    public function getCachedVendorLocations(): JsonResponse
    {
        try {
            // Cache untuk 1 menit untuk mengurangi load database
            $vendors = Cache::remember('vendor_locations_cached', 60, function () {
                return Toko::select([
                    'id',
                    'nama_toko as nama',
                    'latitude',
                    'longitude',
                    'buka_jam as jam_buka',
                    'tutup_jam as jam_tutup',
                    'nomor_wa as whatsapp',
                    'updated_at'
                ])
                    ->where('status', 'active')
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->get()
                    ->map(function ($vendor) {
                        return [
                            'id' => $vendor->id,
                            'nama' => $vendor->nama,
                            'latitude' => (float) $vendor->latitude,
                            'longitude' => (float) $vendor->longitude,
                            'jam_buka' => $this->formatTime($vendor->jam_buka),
                            'jam_tutup' => $this->formatTime($vendor->jam_tutup),
                            'whatsapp' => $this->formatWhatsAppNumber($vendor->whatsapp),
                            'last_updated' => $vendor->updated_at->toISOString(),
                            'is_open' => $this->isVendorOpen($vendor->jam_buka, $vendor->jam_tutup)
                        ];
                    });
            });

            return response()->json([
                'success' => true,
                'data' => $vendors,
                'count' => $vendors->count(),
                'timestamp' => now()->toISOString(),
                'cached' => true,
                'cache_ttl' => '60 seconds',
                'message' => 'Data lokasi vendor berhasil diambil (cached)'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching cached vendor locations: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lokasi vendor',
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Stream real-time location updates (Server-Sent Events)
     * 
     * Endpoint: GET /api/vendors/locations/updates
     * Returns: Stream of vendor location updates
     */
    public function streamLocationUpdates(): StreamedResponse
    {
        return response()->stream(function () {
            $lastUpdate = null;

            // Header untuk SSE
            echo "data: " . json_encode([
                'type' => 'connection_established',
                'message' => 'SSE connection established',
                'timestamp' => now()->toISOString()
            ]) . "\n\n";

            ob_flush();
            flush();

            $maxIterations = 360; // Max 3 hours (30 sec * 360 = 3 hours)
            $iteration = 0;

            while (true) {
                // Batasi iterasi untuk mencegah infinite loop
                if ($iteration >= $maxIterations) {
                    echo "data: " . json_encode([
                        'type' => 'connection_timeout',
                        'message' => 'Connection timeout after 3 hours',
                        'timestamp' => now()->toISOString()
                    ]) . "\n\n";
                    ob_flush();
                    flush();
                    break;
                }

                try {
                    // Cek perubahan data vendor setiap 30 detik
                    $latestUpdate = Toko::where('status', 'active')
                        ->max('updated_at');

                    // Jika ada perubahan, kirim update
                    if ($latestUpdate !== $lastUpdate) {
                        $vendors = Toko::select([
                            'id',
                            'nama_toko as nama',
                            'latitude',
                            'longitude',
                            'updated_at'
                        ])
                            ->where('status', 'active')
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->get()
                            ->map(function ($vendor) {
                                return [
                                    'id' => $vendor->id,
                                    'nama' => $vendor->nama,
                                    'latitude' => (float) $vendor->latitude,
                                    'longitude' => (float) $vendor->longitude,
                                    'updated_at' => $vendor->updated_at->toISOString()
                                ];
                            });

                        echo "data: " . json_encode([
                            'type' => 'locations_update',
                            'data' => $vendors,
                            'count' => $vendors->count(),
                            'timestamp' => now()->toISOString(),
                            'last_updated' => $latestUpdate
                        ]) . "\n\n";

                        ob_flush();
                        flush();

                        $lastUpdate = $latestUpdate;

                        Log::debug('SSE location update sent', [
                            'count' => $vendors->count(),
                            'timestamp' => now()
                        ]);
                    } else {
                        // Kirim heartbeat untuk menjaga koneksi
                        echo "data: " . json_encode([
                            'type' => 'heartbeat',
                            'timestamp' => now()->toISOString()
                        ]) . "\n\n";
                        ob_flush();
                        flush();
                    }
                } catch (\Exception $e) {
                    Log::error('Error in SSE stream: ' . $e->getMessage());

                    echo "data: " . json_encode([
                        'type' => 'error',
                        'message' => 'Error fetching location data',
                        'timestamp' => now()->toISOString()
                    ]) . "\n\n";
                    ob_flush();
                    flush();
                }

                // Tunggu 30 detik sebelum pengecekan berikutnya
                sleep(30);
                $iteration++;

                // Break connection jika client disconnect
                if (connection_aborted()) {
                    Log::info('SSE connection closed by client');
                    break;
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Headers' => 'Cache-Control',
            'X-Accel-Buffering' => 'no' // Important for Nginx
        ]);
    }

    /**
     * Get vendor location changes since specific timestamp
     * 
     * Endpoint: GET /api/vendors/locations/changes?since=2023-01-01T00:00:00Z
     * Returns: Only vendors that changed since given timestamp
     */
    public function getLocationChanges(Request $request): JsonResponse
    {
        try {
            $since = $request->get('since');

            if (!$since) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter "since" wajib diisi (format: Y-m-d\TH:i:s\Z)'
                ], 400);
            }

            $sinceTimestamp = \Carbon\Carbon::parse($since);

            $vendors = Toko::select([
                'id',
                'nama_toko as nama',
                'latitude',
                'longitude',
                'buka_jam as jam_buka',
                'tutup_jam as jam_tutup',
                'updated_at'
            ])
                ->where('status', 'active')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('updated_at', '>', $sinceTimestamp)
                ->get()
                ->map(function ($vendor) {
                    return [
                        'id' => $vendor->id,
                        'nama' => $vendor->nama,
                        'latitude' => (float) $vendor->latitude,
                        'longitude' => (float) $vendor->longitude,
                        'jam_buka' => $this->formatTime($vendor->jam_buka),
                        'jam_tutup' => $this->formatTime($vendor->jam_tutup),
                        'last_updated' => $vendor->updated_at->toISOString(),
                        'is_open' => $this->isVendorOpen($vendor->jam_buka, $vendor->jam_tutup)
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $vendors,
                'count' => $vendors->count(),
                'since' => $since,
                'timestamp' => now()->toISOString(),
                'message' => 'Data perubahan lokasi berhasil diambil'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching location changes: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data perubahan lokasi',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * =============================================
     * PRIVATE HELPER METHODS
     * =============================================
     */

    /**
     * Get all public vendors from database
     */
    private function getPublicVendors(): array
    {
        $tokos = Toko::public()
            ->with([
                'menus' => function ($query) {
                    $query->select('id', 'toko_id', 'nama_menu', 'harga', 'foto', 'deskripsi');
                },
                'layanans' => function ($query) {
                    $query->select('id', 'toko_id', 'antar');
                }
            ])
            ->get();

        return $tokos->map(function ($toko) {
            return $this->transformVendor($toko);
        })->toArray();
    }

    /**
     * Search vendors by query and location
     */
    private function searchVendors(string $query = '', ?float $lat = null, ?float $lng = null, int $radius = 10): array
    {
        $tokosQuery = Toko::public();

        // Search by name or menu
        if (!empty($query)) {
            $tokosQuery->where(function ($q) use ($query) {
                $q->where('nama_toko', 'LIKE', "%{$query}%")
                    ->orWhereHas('menus', function ($menuQuery) use ($query) {
                        $menuQuery->where('nama_menu', 'LIKE', "%{$query}%");
                    });
            });
        }

        $tokos = $tokosQuery->with(['menus', 'layanans'])->get();

        // Filter by distance if coordinates provided
        if ($lat && $lng) {
            $tokos = $tokos->filter(function ($toko) use ($lat, $lng, $radius) {
                if (!$toko->latitude || !$toko->longitude) {
                    return false;
                }

                $distance = $this->calculateDistance($lat, $lng, $toko->latitude, $toko->longitude);
                return $distance <= $radius;
            });
        }

        return $tokos->map(function ($toko) {
            return $this->transformVendor($toko);
        })->values()->toArray();
    }

    /**
     * Transform Toko model to vendor array
     */
    private function transformVendor(Toko $toko): array
    {
        // Ambil text layanan antar dari penjual
        $layananAntarText = 'Tidak ada info layanan antar';

        if ($toko->layanans && $toko->layanans->count() > 0) {
            $firstLayanan = $toko->layanans->first();
            if (!empty($firstLayanan->antar)) {
                $layananAntarText = $firstLayanan->antar;
            }
        }

        return [
            'id' => $toko->id,
            'nama' => $toko->nama_toko,
            'whatsapp' => $this->formatWhatsAppNumber($toko->nomor_wa),
            'jam_buka' => $this->formatTime($toko->buka_jam),
            'jam_tutup' => $this->formatTime($toko->tutup_jam),
            'informasi' => $toko->informasi ?? 'Berbagai menu tersedia',
            'deskripsi' => $toko->informasi ?? 'Berbagai menu tersedia', // tambahkan ini
            'latitude' => (float) $toko->latitude,
            'longitude' => (float) $toko->longitude,
            'is_open' => $toko->is_open,
            'status' => $toko->status_text,
            'user_id' => $toko->user_id,
            'menus' => $toko->menus->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'nama' => $menu->nama_menu,
                    'harga' => (int) $menu->harga,
                    'harga_formatted' => $menu->formatted_price,
                    'foto' => $menu->foto,
                    'deskripsi' => $menu->deskripsi ?? $menu->nama_menu
                ];
            })->toArray(),
            'menu_count' => $toko->menus->count(),
            'layanan' => $toko->layanans->map(function ($layanan) {
                return [
                    'id' => $layanan->id,
                    'antar' => $layanan->antar // ini akan jadi text dari penjual
                ];
            })->toArray(),
            'layanan_antar' => $layananAntarText, // text dari penjual
            'created_at' => $toko->created_at->toISOString(),
            'updated_at' => $toko->updated_at->toISOString()
        ];
    }

    /**
     * Get database statistics
     */
    private function getDatabaseStats(): array
    {
        try {
            return [
                'total_tokos' => Toko::count(),
                'active_tokos' => Toko::active()->count(),
                'open_tokos' => Toko::open()->count(),
                'total_menus' => \App\Models\Menu::count(),
                'total_layanans' => \App\Models\Layanan::count(),
                'tokos_with_coordinates' => Toko::whereNotNull('latitude')->whereNotNull('longitude')->count(),
                'tokos_without_coordinates' => Toko::whereNull('latitude')->orWhereNull('longitude')->count()
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Calculate distance between two coordinates
     */
    private function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Format WhatsApp number to international format
     */
    private function formatWhatsAppNumber(string $number): string
    {
        if (empty($number)) return '6281234567890';

        $number = preg_replace('/[^0-9]/', '', $number);

        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }

        return $number;
    }

    /**
     * Format time to HH:MM format
     */
    private function formatTime($time): string
    {
        if (empty($time)) return '00:00';

        // Jika sudah format HH:MM atau HH:MM:SS
        if (is_string($time)) {
            if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
                return substr($time, 0, 5); // "08:00:00" -> "08:00"
            }
            if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                return $time; // "08:00"
            }
        }

        // Fallback
        return (string) $time;
    }

    /**
     * Check if vendor is currently open
     */
    private function isVendorOpen(string $jamBuka, string $jamTutup): bool
    {
        try {
            $now = now();
            $currentTime = $now->hour * 60 + $now->minute;

            $bukaParts = explode(':', $jamBuka);
            $tutupParts = explode(':', $jamTutup);

            $buka = (int)$bukaParts[0] * 60 + (int)($bukaParts[1] ?? 0);
            $tutup = (int)$tutupParts[0] * 60 + (int)($tutupParts[1] ?? 0);

            if ($tutup < $buka) {
                // Jika tutup melewati tengah malam
                return $currentTime >= $buka || $currentTime <= $tutup;
            }

            return $currentTime >= $buka && $currentTime <= $tutup;
        } catch (\Exception $e) {
            Log::warning('Error checking vendor open status', [
                'jam_buka' => $jamBuka,
                'jam_tutup' => $jamTutup,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
