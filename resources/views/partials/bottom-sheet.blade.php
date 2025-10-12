<!-- Bottom Sheet -->
<div class="bottom-sheet" id="bottomSheet">
  <div class="drag-handle" id="dragHandle"></div>
  <div class="sheet-indicator">
    <span id="sheet-title">Mencari penjual terdekat...</span>
  </div>
  
  <div class="bottom-sheet-content" id="location-content">
    <!-- Loading State -->
    <div class="loading" id="loading-state">
      <div class="spinner"></div>
      Mencari lokasi terdekat...
    </div>

    <!-- Error State -->
    <div id="error-state" style="display: none;">
      <div class="error-state">
        <div class="error-icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="error-title">Gagal Memuat Data</div>
        <div class="error-message" id="error-message">
          Terjadi kesalahan saat memuat data penjual. Silakan coba lagi.
        </div>
        <button class="retry-btn" onclick="loadVendors()">
          <i class="fas fa-redo"></i> Coba Lagi
        </button>
      </div>
    </div>

    <!-- Empty State -->
    <div id="empty-state" style="display: none;">
      <div class="empty-state">
        <div class="empty-icon">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="empty-title">Belum Ada Penjual Terdekat</div>
        <div class="empty-message">
          Saat ini belum ada penjual yang terdaftar di area sekitar Anda. 
          Silakan periksa kembali nanti atau coba cari di area lain.
        </div>
      </div>
    </div>

    <!-- Vendor List -->
    <div id="location-list" style="display: none;">
      <!-- Dynamic content will be inserted here -->
    </div>
  </div>
</div>