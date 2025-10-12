   <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\VendorController;
    use App\Http\Controllers\Api\SliderController;


    /*
   |--------------------------------------------------------------------------
   | API Routes
   |--------------------------------------------------------------------------
   |
   | Semua route di file ini otomatis diprefix dengan /api oleh Laravel.
   | Contoh: Route::get('/vendors') → http://localhost:8000/api/vendors
   |
   */

    // Default route bawaan Laravel untuk user login via Sanctum (jangan hapus)
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Test route sederhana untuk verifikasi API Laravel bekerja (tambahan untuk debug - HAPUS setelah fix)
    Route::get('/test', function () {
        return response()->json([
            'success' => true,
            'message' => 'API Laravel berfungsi! Route test OK.',
            'endpoint' => '/api/test',
            'timestamp' => now()->toISOString()
        ], 200);
    });

    // Tambahkan route slider (letakkan sebelum Route::prefix('vendors'))
    Route::get('/sliders', [SliderController::class, 'index'])->name('api.sliders.index');

    /*
   |--------------------------------------------------------------------------
   | Vendor Routes (Public API - TANPA AUTH)
   |--------------------------------------------------------------------------
   |
   | Prefix: /api/vendors
   | Semua route ini public (tidak perlu login).
   |
   */
    Route::prefix('vendors')->group(function () {
        // GET /api/vendors → Ambil semua vendor (method index di controller)
        Route::get('/', [VendorController::class, 'index'])->name('api.vendors.index');

        // GET /api/vendors/search?q=xxx&lat=...&lng=... → Pencarian vendor
        Route::get('/search', [VendorController::class, 'search'])->name('api.vendors.search');

        // GET /api/vendors/{id} → Detail vendor spesifik
        Route::get('/{id}', [VendorController::class, 'show'])->name('api.vendors.show');

        // GET /api/vendors/test/connection → Test koneksi DB dan stats (untuk debug)
        Route::get('/test/connection', [VendorController::class, 'test'])->name('api.vendors.test');

        // DELETE /api/vendors/cache/clear → Hapus cache vendors (admin only, optional)
        Route::delete('/cache/clear', [VendorController::class, 'clearCache'])->name('api.vendors.clearCache');

        // TRACKING ROUTES
        Route::get('/locations', [VendorController::class, 'getVendorLocations'])->name('api.vendors.locations');
        Route::get('/locations/cached', [VendorController::class, 'getCachedVendorLocations'])->name('api.vendors.locations.cached');
        Route::get('/locations/updates', [VendorController::class, 'streamLocationUpdates'])->name('api.vendors.locations.updates');
        Route::get('/locations/changes', [VendorController::class, 'getLocationChanges'])->name('api.vendors.locations.changes');
    });

