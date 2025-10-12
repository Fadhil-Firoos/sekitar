<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sekitarmu — Temukan penjual di sekitar</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8f9fa;
      overflow: hidden;
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background: linear-gradient(135deg, #ED1C24, #ED1C24);
      color: white;
      padding: 12px 20px;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(231, 76, 60, 0.3);
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 15px;
    }

    .header-left {
      display: flex;
      flex-direction: column;
      flex: 1;
      gap: 8px;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      line-height: 1.2;
    }

    .search-container {
      position: relative;
      width: 100%;
    }

    .search-input {
      width: 100%;
      padding: 10px 40px 10px 15px;
      border: none;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.95);
      font-size: 14px;
      outline: none;
      transition: all 0.3s ease;
    }

    .search-input:focus {
      background: white;
      box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
    }

    .search-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      font-size: 14px;
    }

    .header-right {
      display: flex;
      gap: 10px;
      margin-top: 0;
      padding-top: 0;
      align-items: flex-start;
      flex-shrink: 0;
    }

    .auth-btn {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .auth-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-1px);
    }

    /* Map Container */
    .map-container {
      position: fixed;
      top: 100px;
      left: 0;
      right: 0;
      bottom: 60px;
      width: 100%;
    }

    #map {
      width: 100%;
      height: 100%;
      background: #e0e0e0;
    }

    /* Footer */
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #ED1C24;
      color: white;
      padding: 12px 20px;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
    }

    .footer-left {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .cs-info {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .cs-info i {
      color: #25d366;
    }

    .copyright {
      color: rgba(255,255,255,0.8);
    }

    /* Bottom Sheet */
    .bottom-sheet {
      position: fixed;
      bottom: 60px;
      left: 0;
      right: 0;
      height: 35vh;
      min-height: 200px;
      max-height: 85vh;
      background: white;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
      transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      z-index: 100;
      backdrop-filter: blur(10px);
      touch-action: none;
    }

    .drag-handle {
      width: 40px;
      height: 5px;
      background: #ccc;
      border-radius: 3px;
      margin: 10px auto 5px;
      cursor: grab;
      transition: background-color 0.2s ease;
    }

    .drag-handle:hover {
      background: #999;
    }

    .drag-handle:active {
      cursor: grabbing;
      background: #666;
    }

    .sheet-indicator {
      text-align: center;
      padding: 5px 0 12px;
      color: #7f8c8d;
      font-size: 12px;
      border-bottom: 1px solid #e9ecef;
      margin-bottom: 0;
    }

    .bottom-sheet-content {
      flex: 1;
      overflow-y: auto;
      padding: 0;
    }

    /* Slider Section */
    .slider-section {
      padding: 15px 15px 10px;
      background: white;
      border-bottom: 1px solid #e9ecef;
    }

    .slider-container {
      position: relative;
      width: 100%;
      height: 180px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .slider-wrapper {
      display: flex;
      transition: transform 0.5s ease;
      height: 100%;
    }

    .slider-item {
      min-width: 100%;
      height: 100%;
      position: relative;
      cursor: pointer;
    }

    .slider-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .slider-dots {
      position: absolute;
      bottom: 12px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
      z-index: 10;
    }

    .slider-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255,255,255,0.5);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .slider-dot.active {
      background: white;
      width: 24px;
      border-radius: 4px;
    }

    .slider-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 32px;
      height: 32px;
      background: rgba(255,255,255,0.9);
      border: none;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ED1C24;
      font-size: 16px;
      transition: all 0.3s ease;
      z-index: 10;
    }

    .slider-nav:hover {
      background: white;
      transform: translateY(-50%) scale(1.1);
    }

    .slider-nav.prev {
      left: 12px;
    }

    .slider-nav.next {
      right: 12px;
    }

    /* Vendor List Section */
    .vendor-list-section {
      padding: 15px;
    }

    /* Vendor Cards */
    .vendor-card {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      padding: 12px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      box-shadow: 0 1px 8px rgba(0,0,0,0.06);
    }

    .vendor-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border-color: #ED1C24;
    }

    .vendor-card.active {
      background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
      border-color: #2196f3;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(33, 150, 243, 0.15);
    }

    .vendor-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .vendor-main-info {
      flex: 1;
      margin-right: 12px;
    }

    .vendor-name {
      font-size: 16px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 3px;
      line-height: 1.2;
    }

    .vendor-type {
      font-size: 11px;
      color: #7f8c8d;
      background: #f8f9fa;
      padding: 2px 6px;
      border-radius: 8px;
      display: inline-block;
      margin-bottom: 6px;
    }

    .vendor-status-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      min-width: 70px;
    }

    .vendor-status {
      display: flex;
      align-items: center;
      gap: 4px;
      margin-bottom: 3px;
    }

    .status-indicator {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    .status-open {
      background: #27ae60;
    }

    .status-closed {
      background: #ED1C24;
    }

    @keyframes pulse {
      0% { opacity: 1; }
      50% { opacity: 0.5; }
      100% { opacity: 1; }
    }

    .status-text {
      font-size: 10px;
      font-weight: bold;
      color: #27ae60;
    }

    .status-text.closed {
      color: #ED1C24;
    }

    .vendor-distance {
      font-size: 11px;
      color: #ED1C24;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 3px;
    }

    .vendor-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
      margin-bottom: 10px;
    }

    .detail-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      color: #666;
    }

    .detail-item i {
      width: 14px;
      text-align: center;
      color: #ED1C24;
      font-size: 11px;
    }

    .vendor-actions {
      display: flex;
      gap: 6px;
      justify-content: space-between;
      align-items: center;
    }

    .action-btn {
      border: none;
      padding: 6px 12px;
      border-radius: 16px;
      font-size: 11px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .whatsapp-btn {
      background: #25d366;
      color: white;
    }

    .whatsapp-btn:hover {
      background: #128c7e;
      transform: scale(1.03);
    }

    .menu-btn {
      background: #3498db;
      color: white;
      flex: 1;
      justify-content: center;
    }

    .menu-btn:hover {
      background: #2980b9;
      transform: scale(1.02);
    }

    /* Loading states */
    .loading {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      color: #7f8c8d;
    }

    .spinner {
      width: 18px;
      height: 18px;
      border: 2px solid #f3f3f3;
      border-top: 2px solid #ED1C24;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-right: 8px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Empty & Error states */
    .empty-state, .error-state {
      text-align: center;
      padding: 30px 15px;
      color: #7f8c8d;
    }

    .empty-icon, .error-icon {
      font-size: 40px;
      margin-bottom: 15px;
      color: #bdc3c7;
    }

    .error-icon {
      color: #ED1C24;
    }

    .empty-title, .error-title {
      font-size: 16px;
      margin-bottom: 8px;
      color: #2c3e50;
    }

    .error-title {
      color: #ED1C24;
    }

    .empty-message, .error-message {
      font-size: 13px;
      line-height: 1.4;
      max-width: 280px;
      margin: 0 auto 15px;
    }

    .retry-btn {
      background: #ED1C24;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 16px;
      font-size: 11px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .retry-btn:hover {
      background: #c0392b;
    }

    @media (max-width: 768px) {
      .slider-container {
        height: 150px;
      }
    }

    @media (max-width: 480px) {
      .slider-container {
        height: 130px;
      }

      .slider-section {
        padding: 10px 10px 8px;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <div class="header">
    <div class="header-left">
      <div class="logo">Sekitarmu</div>
      <div class="search-container">
        <input id="search-input" class="search-input" type="text" placeholder="Cari nama outlet atau menu">
        <i class="fas fa-search search-icon"></i>
      </div>
    </div>
    <div class="header-right">
      <a href="/penjual/login" class="auth-btn">
        <i class="fas fa-sign-in-alt"></i>
        Masuk
      </a>
      <a href="/penjual/register" class="auth-btn">
        <i class="fas fa-user-plus"></i>
        Daftar
      </a>
    </div>
  </div>

  <!-- Map -->
  <div class="map-container">
    <div id="map"></div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div class="footer-left">
      <div class="cs-info">
        <i class="fab fa-whatsapp"></i>
        <span>+62 812 3456 7890</span>
      </div>
      <div class="copyright">
        &copy; 2025 Sekitarmu. All rights reserved.
      </div>
    </div>
  </div>

  <!-- Bottom Sheet -->
  <div class="bottom-sheet" id="bottomSheet">
    <div class="drag-handle" id="dragHandle"></div>
    <div class="sheet-indicator">
      <span id="sheet-title">Mencari penjual terdekat...</span>
    </div>
    
    <div class="bottom-sheet-content" id="location-content">
      <!-- Slider Section (ditampilkan pertama) -->
      <div class="slider-section" id="slider-section" style="display: none;">
        <div class="slider-container">
          <div class="slider-wrapper" id="sliderWrapper">
            <!-- Slider items loaded dynamically -->
          </div>
          <button class="slider-nav prev" id="sliderPrev" style="display: none;">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="slider-nav next" id="sliderNext" style="display: none;">
            <i class="fas fa-chevron-right"></i>
          </button>
          <div class="slider-dots" id="sliderDots">
            <!-- Dots loaded dynamically -->
          </div>
        </div>
      </div>

      <!-- Vendor List Section -->
      <div class="vendor-list-section">
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
              Terjadi kesalahan saat memuat data. Silakan coba lagi.
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
            </div>
          </div>
        </div>

        <!-- Vendor List -->
        <div id="location-list" style="display: none;">
          <!-- Vendor cards loaded dynamically -->
        </div>
      </div>
    </div>
  </div>

  <script>
    let map, userMarker, userLocation = null;
    let allVendors = [], filteredVendors = [];
    let sliders = [];
    let currentSlide = 0;
    let sliderInterval = null;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -6.2, lng: 106.816666 },
        zoom: 13,
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false
      });

      // Load slider pertama kali (hanya sekali)
      loadSliders();

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
          userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
          map.setCenter(userLocation);
          map.setZoom(15);
          loadVendors();
        }, () => {
          loadVendors();
        });
      } else {
        loadVendors();
      }
    }

    // Load Sliders (hanya dipanggil 1x saat page load)
    async function loadSliders() {
      try {
        const response = await fetch('/api/sliders');
        if (response.ok) {
          const result = await response.json();
          if (result.success && result.data && result.data.length > 0) {
            sliders = result.data;
            displaySliders();
          }
        }
      } catch (error) {
        console.error('Error loading sliders:', error);
      }
    }

    function displaySliders() {
      if (!sliders || sliders.length === 0) return;

      const sliderSection = document.getElementById('slider-section');
      const sliderWrapper = document.getElementById('sliderWrapper');
      const sliderDots = document.getElementById('sliderDots');
      const prevBtn = document.getElementById('sliderPrev');
      const nextBtn = document.getElementById('sliderNext');
      
      sliderSection.style.display = 'block';
      sliderWrapper.innerHTML = '';
      sliderDots.innerHTML = '';
      
      // Create slider items
      sliders.forEach((slider, index) => {
        const item = document.createElement('div');
        item.className = 'slider-item';
        if (slider.link) {
          item.onclick = () => window.open(slider.link, '_blank');
        }
        if (slider.gambar) {
          const imageUrl = slider.gambar.startsWith('http') ? slider.gambar : `/storage/${slider.gambar}`;
          item.innerHTML = `<img src="${imageUrl}" alt="Slider ${index + 1}" onerror="this.style.display='none'">`;
        }
        sliderWrapper.appendChild(item);
        
        // Create dot
        const dot = document.createElement('div');
        dot.className = `slider-dot ${index === 0 ? 'active' : ''}`;
        dot.onclick = () => goToSlide(index);
        sliderDots.appendChild(dot);
      });
      
      // Show nav buttons if more than 1 slide
      if (sliders.length > 1) {
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
        prevBtn.onclick = prevSlide;
        nextBtn.onclick = nextSlide;
        startSliderAutoPlay();
      }
    }

    function goToSlide(index) {
      currentSlide = index;
      document.getElementById('sliderWrapper').style.transform = `translateX(-${currentSlide * 100}%)`;
      document.querySelectorAll('.slider-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
      });
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % sliders.length;
      goToSlide(currentSlide);
      resetSliderAutoPlay();
    }

    function prevSlide() {
      currentSlide = (currentSlide - 1 + sliders.length) % sliders.length;
      goToSlide(currentSlide);
      resetSliderAutoPlay();
    }

    function startSliderAutoPlay() {
      if (sliders.length > 1) {
        sliderInterval = setInterval(nextSlide, 5000);
      }
    }

    function resetSliderAutoPlay() {
      if (sliderInterval) clearInterval(sliderInterval);
      startSliderAutoPlay();
    }

    // Load Vendors
    async function loadVendors() {
      document.getElementById("loading-state").style.display = "block";
      document.getElementById("empty-state").style.display = "none";
      document.getElementById("error-state").style.display = "none";
      document.getElementById("location-list").style.display = "none";

      try {
        const response = await fetch('/api/vendors');
        if (response.ok) {
          const result = await response.json();
          allVendors = result.success && result.data ? result.data : [];
          filteredVendors = allVendors;
          
          if (allVendors.length > 0) {
            displayVendors(allVendors);
          } else {
            showEmptyState();
          }
        } else {
          showErrorState('Gagal memuat data penjual');
        }
      } catch (error) {
        console.error('Error:', error);
        showErrorState('Koneksi ke server terputus');
      }
    }

    function displayVendors(vendors) {
      document.getElementById("loading-state").style.display = "none";
      document.getElementById("error-state").style.display = "none";
      document.getElementById("empty-state").style.display = "none";
      document.getElementById("location-list").style.display = "block";
      
      let sortedVendors = vendors;
      if (userLocation) {
        sortedVendors = vendors.slice().sort((a, b) => {
          const distA = calculateDistance(userLocation, {lat: a.latitude, lng: a.longitude});
          const distB = calculateDistance(userLocation, {lat: b.latitude, lng: b.longitude});
          return parseFloat(distA) - parseFloat(distB);
        });
      }
      
      document.getElementById("sheet-title").textContent = `${sortedVendors.length} penjual ditemukan`;
      
      const list = document.getElementById("location-list");
      list.innerHTML = "";
      
      sortedVendors.forEach(vendor => {
        const card = document.createElement('div');
        card.className = 'vendor-card';
        const distance = userLocation ? calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude}) : '0.0';
        const isOpen = isVendorOpen(vendor.jam_buka, vendor.jam_tutup);
        
        card.innerHTML = `
          <div class="vendor-header">
            <div class="vendor-main-info">
              <div class="vendor-name">${vendor.nama}</div>
              <div class="vendor-type">${vendor.informasi || 'Penjual keliling'}</div>
            </div>
            <div class="vendor-status-container">
              <div class="vendor-status">
                <div class="status-indicator ${isOpen ? 'status-open' : 'status-closed'}"></div>
                <span class="status-text ${isOpen ? '' : 'closed'}">${isOpen ? 'BUKA' : 'TUTUP'}</span>
              </div>
              <div class="vendor-distance">
                <i class="fas fa-map-marker-alt"></i>
                ${distance} KM
              </div>
            </div>
          </div>
          <div class="vendor-details">
            <div class="detail-item">
              <i class="fas fa-clock"></i>
              <span>${vendor.jam_buka} - ${vendor.jam_tutup}</span>
            </div>
            <div class="detail-item">
              <i class="fab fa-whatsapp"></i>
              <span>+${vendor.whatsapp}</span>
            </div>
          </div>
          <div class="vendor-actions">
            <button class="action-btn menu-btn">
              <i class="fas fa-utensils"></i>
              Lihat Menu
            </button>
            <a href="https://wa.me/${vendor.whatsapp}" target="_blank" class="action-btn whatsapp-btn">
              <i class="fab fa-whatsapp"></i>
              Chat
            </a>
          </div>
        `;
        list.appendChild(card);
      });
    }

    function showEmptyState() {
      document.getElementById("loading-state").style.display = "none";
      document.getElementById("error-state").style.display = "none";
      document.getElementById("empty-state").style.display = "block";
      document.getElementById("location-list").style.display = "none";
      document.getElementById("sheet-title").textContent = "Tidak ada penjual ditemukan";
    }

    function showErrorState(message) {
      document.getElementById("loading-state").style.display = "none";
      document.getElementById("empty-state").style.display = "none";
      document.getElementById("error-state").style.display = "block";
      document.getElementById("location-list").style.display = "none";
      document.getElementById("sheet-title").textContent = "Gagal memuat data";
      document.getElementById("error-message").textContent = message;
    }

    function calculateDistance(pos1, pos2) {
      if (!pos1 || !pos2) return "0.0";
      const R = 6371;
      const dLat = (pos2.lat - pos1.lat) * Math.PI / 180;
      const dLon = (pos2.lng - pos1.lng) * Math.PI / 180;
      const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(pos1.lat * Math.PI / 180) * Math.cos(pos2.lat * Math.PI / 180) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      return (R * c).toFixed(1);
    }

    function isVendorOpen(jamBuka, jamTutup) {
      const now = new Date();
      const currentTime = now.getHours() * 60 + now.getMinutes();
      const [bukaH, bukaM] = jamBuka.split(':').map(Number);
      const [tutupH, tutupM] = jamTutup.split(':').map(Number);
      const buka = bukaH * 60 + bukaM;
      const tutup = tutupH * 60 + tutupM;
      return tutup < buka ? (currentTime >= buka || currentTime <= tutup) : (currentTime >= buka && currentTime <= tutup);
    }

    window.addEventListener('load', initMap);
  </script>

  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAulkhTQ36NXoZ7_SMNRv1nv2hz6jmrZxc&libraries=places&callback=initMap"></script>
</body>
</html>