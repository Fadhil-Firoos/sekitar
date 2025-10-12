<!-- Detail Page -->
<div class="detail-page" id="detailPage">
  <div class="detail-header">
    <div class="detail-nav">
      <button class="back-btn" onclick="closeDetailPage()">
        <i class="fas fa-arrow-left"></i>
      </button>
      <div class="detail-title">
        <h1 class="detail-vendor-name" id="detailVendorName">Nama Toko</h1>
        <p class="detail-vendor-type" id="detailVendorType">Jenis Usaha</p>
      </div>
    </div>
    
    <!-- Header info in single line -->
    <div class="detail-header-info">
      <div class="header-info-item">
        <i class="fas fa-clock"></i>
        <span id="headerHours">08:00 - 22:00</span>
      </div>
      <div class="header-info-item">
        <i class="fas fa-map-marker-alt"></i>
        <span id="headerDistance">1.2 KM</span>
      </div>
      <div class="header-info-item">
        <i class="fab fa-whatsapp"></i>
        <span id="headerPhone">+62 812 3456 7890</span>
      </div>
      <div class="header-info-item">
        <span class="header-status" id="headerStatus">BUKA</span>
      </div>
    </div>
  </div>

  <div class="detail-content">
    <!-- Contact Actions -->
    <div class="vendor-info-card">
      <div class="contact-actions">
        <button class="contact-btn wa-btn" id="detailWhatsappBtn">
          <i class="fab fa-whatsapp"></i>
          Chat WhatsApp
        </button>
        <button class="contact-btn delivery-btn" id="detailDeliveryBtn">
          <i class="fas fa-motorcycle"></i>
          Layanan Antar
        </button>
      </div>
    </div>

    <!-- Menu Section -->
    <div class="menu-section">
      <h2 class="menu-title">
        <i class="fas fa-utensils"></i>
        Menu Tersedia
      </h2>
      <div class="menu-grid" id="detailMenuGrid">
        <!-- Dynamic menu items will be inserted here -->
      </div>
    </div>
  </div>
</div>

<!-- Delivery Info Modal -->
<div class="delivery-modal" id="deliveryModal">
  <div class="delivery-modal-content">
    <div class="delivery-modal-header">
      <h3 class="delivery-modal-title">
        <i class="fas fa-motorcycle"></i>
        Informasi Layanan Antar
      </h3>
      <button class="delivery-close-btn" onclick="closeDeliveryModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div id="deliveryInfoContent">
      <!-- Dynamic content will be inserted here -->
    </div>
  </div>
</div>