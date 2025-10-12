<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sekitarmu — Temukan penjual di sekitar</title>
  <meta name="csrf-param" content="_token" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

/* === HEADER STYLE === */
.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: linear-gradient(135deg, #ED1C24, #ED1C24);
  color: white;
  padding: 12px 15px;
  z-index: 1000;
  box-shadow: 0 2px 10px rgba(231, 76, 60, 0.3);
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 15px;
  font-family: "Poppins", sans-serif;
}

/* === HEADER LEFT === */
.header-left {
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: 8px;
}

/* === LOGO === */
.logo {
  display: flex;
  align-items: center;
}

.logo a {
  display: inline-flex;
  align-items: center;
  text-decoration: none;
}

/* === LOGO IMAGE === */
.logo-img {
  height: 45px;
  width: auto;
  object-fit: contain;
  display: block;
 margin-left: 0; /* pastikan logo benar-benar ke kiri */
  /* Membesarkan logo tanpa merusak layout */
  transform: scale(4.5);          /* perbesar 30% */
  transform-origin: left center;  /* titik pembesaran dari sisi kiri */
}

/* .logo {
  transform: translateY(2px);
} */

/* === SEARCH === */
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
      color: #bdc3c7;
    }

    .footer-right {
      display: flex;
      gap: 10px;
    }

    .social-link {
      color: white;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .social-link:hover {
      color: #3498db;
      transform: translateY(-2px);
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
      margin-bottom: 12px;
    }

    .bottom-sheet-content {
      flex: 1;
      overflow-y: auto;
      padding: 0 15px 15px;
    }

    /* Slider Styles */
    .slider-section {
      margin-bottom: 20px;
      padding: 0 5px;
    }

    .slider-container {
      position: relative;
      width: 100%;
      height: 160px;
      overflow: hidden;
      border-radius: 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .slider-track {
      display: flex;
      transition: transform 0.3s ease;
      height: 100%;
    }

    .slider-item {
      flex: 0 0 100%;
      height: 100%;
      position: relative;
      cursor: pointer;
    }

    .slider-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 16px;
      transition: transform 0.3s ease;
    }

    .slider-item:hover .slider-image {
      transform: scale(1.02);
    }

    .slider-indicators {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 12px;
    }

    .slider-indicator {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #ddd;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .slider-indicator.active {
      background: #ED1C24;
      transform: scale(1.2);
    }

    .slider-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.9);
      border: none;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 14px;
      color: #ED1C24;
      transition: all 0.3s ease;
      z-index: 10;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .slider-nav:hover {
      background: white;
      transform: translateY(-50%) scale(1.1);
    }

    .slider-nav.prev {
      left: 10px;
    }

    .slider-nav.next {
      right: 10px;
    }

    .slider-nav:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: translateY(-50%) scale(1);
    }

    /* Vendor Cards - Minimalis */
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

    /* Detail Page - Minimalis */
    .detail-page {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      z-index: 2000;
      display: none;
      overflow-y: auto;
    }

    .detail-header {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      padding: 12px 15px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 2001;
    }

    .detail-nav {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 8px;
    }

    .back-btn {
      background: #ED1C24;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .back-btn:hover {
      background: #c0392b;
      transform: scale(1.05);
    }

    .detail-title {
      flex: 1;
    }

    .detail-vendor-name {
      font-size: 18px;
      font-weight: bold;
      color: #2c3e50;
      margin: 0;
    }

    .detail-vendor-type {
      font-size: 11px;
      color: #7f8c8d;
      margin-top: 2px;
    }

    /* Header info - Minimalis */
    .detail-header-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 8px;
      padding: 6px 0;
      border-top: 1px solid #e9ecef;
      flex-wrap: wrap;
      gap: 6px;
    }

    .header-info-item {
      display: flex;
      align-items: center;
      gap: 3px;
      font-size: 11px;
      color: #2c3e50;
      font-weight: 500;
    }

    .header-info-item i {
      color: #ED1C24;
      font-size: 10px;
    }

    .header-status.open {
      color: #27ae60;
      font-weight: bold;
    }

    .header-status.closed {
      color: #ED1C24;
      font-weight: bold;
    }

    .detail-content {
      padding: 20px 15px;
      max-width: 600px;
      margin: 0 auto;
    }

    .vendor-info-card {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    /* Contact actions dengan perbandingan 2:1 */
    .contact-actions {
      display: flex;
      gap: 8px;
    }

    .contact-btn {
      background: #25d366;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      flex: 2;
      font-size: 14px;
    }

    .contact-btn:hover {
      background: #128c7e;
      transform: translateY(-2px);
    }

    /* Button untuk layanan antar dengan perbandingan 1 */
    .delivery-btn {
      background: #3498db;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      flex: 1;
      font-size: 13px;
    }

    .delivery-btn:hover {
      background: #2980b9;
      transform: translateY(-2px);
    }

    /* Modal untuk layanan antar */
    .delivery-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      z-index: 3000;
      align-items: center;
      justify-content: center;
    }

    .delivery-modal-content {
      background: white;
      padding: 20px;
      border-radius: 16px;
      max-width: 350px;
      width: 90%;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      text-align: center;
    }

    .delivery-modal h3 {
      color: #2c3e50;
      margin-bottom: 12px;
      font-size: 18px;
    }

    .delivery-modal p {
      color: #7f8c8d;
      margin-bottom: 15px;
      line-height: 1.4;
      font-size: 14px;
    }

    .close-delivery-modal {
      background: #ED1C24;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .close-delivery-modal:hover {
      background: #c0392b;
    }

    .menu-section {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .menu-title {
      font-size: 16px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .menu-grid {
      display: grid;
      gap: 10px;
    }

    /* Menu Items - Minimalis */
    .menu-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 12px;
      background: #f8f9fa;
      border-radius: 12px;
      border: 1px solid transparent;
      transition: all 0.3s ease;
      gap: 12px;
      cursor: pointer;
    }

    .menu-item:hover {
      border-color: #ED1C24;
      background: white;
      box-shadow: 0 2px 8px rgba(231, 76, 60, 0.1);
      transform: translateY(-1px);
    }

    .menu-photo {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      object-fit: cover;
      flex-shrink: 0;
      background: #e9ecef;
      border: 1px solid #dee2e6;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .menu-photo:hover {
      transform: scale(1.03);
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .menu-photo.placeholder {
      display: flex;
      align-items: center;
      justify-content: center;
      color: #adb5bd;
      font-size: 14px;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      cursor: pointer;
    }

    .menu-content {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex: 1;
      gap: 12px;
    }

    .menu-info {
      flex: 1;
    }

    .menu-info h4 {
      font-size: 15px;
      color: #2c3e50;
      margin-bottom: 4px;
      line-height: 1.3;
      font-weight: bold;
    }

    .menu-desc {
      font-size: 12px;
      color: #7f8c8d;
      line-height: 1.3;
      margin-bottom: 3px;
    }

    .menu-price {
      font-size: 15px;
      font-weight: bold;
      color: #ED1C24;
      white-space: nowrap;
      align-self: flex-start;
      margin-top: 2px;
    }

    /* Menu Detail Page - Minimalis */
    .menu-detail-page {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
      z-index: 3000;
      display: none;
      overflow-y: auto;
    }

    .menu-detail-header {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      padding: 12px 15px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 3001;
    }

    .menu-detail-nav {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .menu-detail-title h1 {
      font-size: 16px;
      font-weight: bold;
      color: #2c3e50;
      margin: 0;
    }

    .menu-detail-content {
      padding: 15px;
      max-width: 500px;
      margin: 0 auto;
    }

    .menu-detail-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      margin-bottom: 15px;
    }

    .menu-detail-info {
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .menu-detail-name {
      font-size: 20px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 8px;
    }

    .menu-detail-price {
      font-size: 24px;
      font-weight: bold;
      color: #ED1C24;
      margin-bottom: 12px;
    }

    .menu-detail-desc {
      font-size: 14px;
      color: #7f8c8d;
      line-height: 1.5;
      margin-bottom: 15px;
    }

    .menu-detail-actions {
      display: flex;
      gap: 8px;
    }

    .order-btn {
      flex: 2;
      background: #25d366;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .order-btn:hover {
      background: #128c7e;
      transform: translateY(-2px);
    }

    .share-btn {
      flex: 1;
      background: #3498db;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .share-btn:hover {
      background: #2980b9;
      transform: translateY(-2px);
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

    /* Lightbox */
    .lightbox {
      display: none;
      position: fixed;
      z-index: 5000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.95);
      backdrop-filter: blur(5px);
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .lightbox-content {
      margin: 5% auto;
      display: block;
      max-width: 90%;
      max-height: 70%;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.5);
      animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
      from { transform: scale(0.3); }
      to { transform: scale(1); }
    }

    .lightbox-close {
      position: absolute;
      top: 15px;
      right: 25px;
      color: #f1f1f1;
      font-size: 35px;
      font-weight: bold;
      transition: 0.3s;
      cursor: pointer;
      z-index: 5001;
      background: rgba(0,0,0,0.5);
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .lightbox-close:hover {
      background: rgba(0,0,0,0.8);
      color: #bbb;
    }

    .lightbox-caption {
      margin: 12px auto;
      display: block;
      max-width: 80%;
      text-align: center;
      color: #ccc;
      padding: 15px 20px;
      background: rgba(0,0,0,0.8);
      border-radius: 12px;
      backdrop-filter: blur(10px);
    }

    .lightbox-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 6px;
      color: white;
    }

    .lightbox-desc {
      font-size: 14px;
      opacity: 0.9;
      margin-bottom: 6px;
    }

    .lightbox-price {
      font-size: 18px;
      font-weight: bold;
      color: #ED1C24;
      margin-top: 6px;
    }

    /* Responsive adjustments for slider */
    @media (max-width: 768px) {
      .header {
        padding: 10px 15px;
      }

      .logo {
        font-size: 18px;
        margin-bottom: 6px;
      }

      .map-container {
        top: 90px;
      }

      .vendor-details {
        grid-template-columns: 1fr;
        gap: 6px;
      }

      .contact-actions {
        flex-direction: column;
      }

      .menu-photo {
        width: 55px;
        height: 55px;
      }

      .menu-item {
        padding: 10px;
        gap: 10px;
      }

      .menu-info h4 {
        font-size: 14px;
      }

      .menu-desc {
        font-size: 11px;
      }

      .menu-price {
        font-size: 14px;
      }

      .detail-header-info {
        flex-wrap: wrap;
        gap: 5px;
      }

      .header-info-item {
        font-size: 10px;
      }

      .footer {
        padding: 10px 15px;
        font-size: 11px;
      }

      .slider-container {
        height: 140px;
      }
    }

    @media (max-width: 480px) {
      .map-container {
        top: 85px;
      }

      .bottom-sheet {
        height: 40vh;
      }

      .vendor-actions {
        flex-direction: column;
        gap: 6px;
      }

      .action-btn {
        width: 100%;
        justify-content: center;
      }

      .menu-photo {
        width: 50px;
        height: 50px;
      }

      .menu-item {
        padding: 8px;
        gap: 8px;
      }

      .menu-content {
        gap: 8px;
      }

      .menu-info h4 {
        font-size: 13px;
      }

      .menu-desc {
        font-size: 10px;
      }

      .menu-price {
        font-size: 13px;
      }

      .detail-header-info {
        justify-content: flex-start;
        gap: 8px;
      }

      .header-right {
        flex-direction: column;
        gap: 5px;
      }

      .auth-btn {
        padding: 6px 10px;
        font-size: 10px;
      }

      .footer {
        flex-direction: column;
        gap: 8px;
        text-align: center;
      }

      .footer-left {
        flex-direction: column;
        gap: 5px;
      }

      .slider-container {
        height: 120px;
      }

      .slider-nav {
        width: 30px;
        height: 30px;
        font-size: 12px;
      }


    /* Filter Panel */
.filter-panel {
  background: white;
  border-top: 1px solid #e9ecef;
  padding: 15px;
  display: none;
  animation: slideDown 0.3s ease-out;
}

.filter-panel.active {
  display: block;
}

.filter-section {
  margin-bottom: 15px;
}

.filter-label {
  font-size: 13px;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 8px;
  display: block;
}

.radius-slider {
  width: 100%;
  height: 6px;
  border-radius: 5px;
  background: #e9ecef;
  outline: none;
  -webkit-appearance: none;
}

.radius-slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #ED1C24;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.radius-slider::-moz-range-thumb {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #ED1C24;
  cursor: pointer;
  border: none;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.radius-info {
  display: flex;
  justify-content: space-between;
  font-size: 11px;
  color: #7f8c8d;
  margin-top: 5px;
}

.category-chips {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 5px;
}

.category-chip {
  padding: 8px 16px;
  border-radius: 20px;
  border: 2px solid #e9ecef;
  background: white;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 5px;
}

.category-chip.active {
  background: #ED1C24;
  color: white;
  border-color: #ED1C24;
}

.category-chip:hover {
  border-color: #ED1C24;
}

.filter-actions {
  display: flex;
  gap: 10px;
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid #e9ecef;
}

.filter-btn {
  flex: 1;
  padding: 10px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

.filter-btn.reset {
  background: white;
  border: 2px solid #e9ecef;
  color: #7f8c8d;
}

.filter-btn.apply {
  background: #ED1C24;
  color: white;
}

.filter-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Quick Stats */
.quick-stats {
  display: flex;
  gap: 8px;
  padding: 0 15px 12px;
  font-size: 11px;
}

.stat-badge {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 5px 12px;
  border-radius: 20px;
  font-weight: 600;
}

.stat-badge.open {
  background: #d4edda;
  color: #27ae60;
}

.stat-badge.closed {
  background: #f8f9fa;
  color: #7f8c8d;
}

.stat-badge.total {
  background: #e3f2fd;
  color: #2196f3;
}

.stat-indicator {
  width: 8px;
  height: 8px;
  border-radius: 50%;
}

.stat-indicator.open {
  background: #27ae60;
}

.stat-indicator.closed {
  background: #7f8c8d;
}

/* Animations */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Marker Label */
.vendor-label {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-bottom: 8px;
  background: white;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 11px;
  font-weight: bold;
  white-space: nowrap;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  border: 2px solid #27ae60;
  color: #2c3e50;
  z-index: 10;
}

.vendor-label.closed {
  border-color: #95a5a6;
  color: #7f8c8d;
}

.vendor-label.selected {
  background: #ED1C24;
  color: white;
  border-color: #ED1C24;
}

.vendor-label::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 0;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid #27ae60;
}

.vendor-label.closed::after {
  border-top-color: #95a5a6;
}

.vendor-label.selected::after {
  border-top-color: #ED1C24;
}

/* Radius Circle on Map */
.radius-circle {
  position: absolute;
  border: 3px solid rgba(52, 152, 219, 0.4);
  border-radius: 50%;
  pointer-events: none;
  z-index: 5;
}


    }
  </style>
</head>
<body>
  <!-- Header dengan Login/Register -->
  <<!-- === HEADER === -->
<!-- === HEADER === -->
<div class="header">
  <div class="header-left">
    <!-- Logo -->
    <div class="logo">
      <a href="/">
        <img src="{{ asset('assets/img/sekitarmu.png') }}" 
             alt="Sekitarmu Logo" 
             class="logo-img">
      </a>
    </div>

    <!-- Search with Filter Button -->
    <div class="search-container">
      <input id="search-input" class="search-input" type="text" placeholder="Cari nama outlet atau menu">
      <i class="fas fa-search search-icon"></i>
      <button id="filter-toggle" class="filter-toggle-btn">
        <i class="fas fa-sliders-h"></i>
      </button>
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

<!-- Filter Panel (NEW) -->
<div class="filter-panel" id="filterPanel">
  <div class="filter-section">
    <label class="filter-label">
      Radius: <span id="radiusValue">5</span> km
    </label>
    <input type="range" 
           id="radiusSlider" 
           class="radius-slider" 
           min="0.5" 
           max="5" 
           step="0.5" 
           value="5">
    <div class="radius-info">
      <span>0.5 km</span>
      <span>5 km</span>
    </div>
  </div>

  <div class="filter-section">
    <label class="filter-label">Kategori</label>
    <div class="category-chips" id="categoryChips">
      <button class="category-chip active" data-category="all">
        🍽️ Semua
      </button>
      <button class="category-chip" data-category="nasi">
        🍚 Nasi
      </button>
      <button class="category-chip" data-category="mie">
        🍜 Mie
      </button>
      <button class="category-chip" data-category="snack">
        🧁 Snack
      </button>
      <button class="category-chip" data-category="minuman">
        🥤 Minuman
      </button>
    </div>
  </div>

  <div class="filter-actions">
    <button class="filter-btn reset" id="resetFilter">Reset</button>
    <button class="filter-btn apply" id="applyFilter">Terapkan</button>
  </div>
</div>

<!-- Quick Stats (NEW) -->
<div class="quick-stats" id="quickStats">
  <div class="stat-badge open">
    <span class="stat-indicator open"></span>
    <span id="openCount">0</span> Buka
  </div>
  <div class="stat-badge closed">
    <span class="stat-indicator closed"></span>
    <span id="closedCount">0</span> Tutup
  </div>
  <div class="stat-badge total">
    <i class="fas fa-map-marker-alt" style="font-size: 10px;"></i>
    <span id="totalCount">0</span> Warung
  </div>
</div>

  <!-- Map -->
  <div class="map-container">
    <div id="map"></div>
  </div>

  <!-- Footer dengan CS dan Copyright -->
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
      <!-- Slider Section -->
      <div class="slider-section" id="slider-section" style="display: none;">
        <div class="slider-container">
          <button class="slider-nav prev" id="sliderPrev">‹</button>
          <div class="slider-track" id="sliderTrack">
            <!-- Slider items will be dynamically inserted here -->
          </div>
          <button class="slider-nav next" id="sliderNext">›</button>
        </div>
        <div class="slider-indicators" id="sliderIndicators">
          <!-- Slider indicators will be dynamically inserted here -->
        </div>
      </div>

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

  <!-- Detail Page - Minimalis -->
  <div class="detail-page" id="detailPage">
    <div class="detail-header">
      <div class="detail-nav">
        <button class="back-btn" onclick="closeDetailPage()">
          <i class="fas fa-arrow-left"></i>
        </button>
        <div class="detail-title">
          <h1 class="detail-vendor-name" id="detailVendorName">Nama Toko</h1>
          <p class="detail-vendor-type" id="detailVendorType">Informasi toko</p>
        </div>
      </div>
      
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
      <!-- Contact Actions dengan perbandingan 2:1 -->
      <div class="vendor-info-card">
        <div class="contact-actions">
          <button class="contact-btn" id="detailWhatsappBtn">
            <i class="fab fa-whatsapp"></i>
            Chat WhatsApp
          </button>
          <button class="delivery-btn" id="deliveryBtn">
            <i class="fas fa-truck"></i>
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

  <!-- Modal untuk layanan antar -->
  <div class="delivery-modal" id="deliveryModal">
    <div class="delivery-modal-content">
      <h3><i class="fas fa-truck"></i> Layanan Antar</h3>
      <p id="deliveryModalText">Informasi layanan antar akan ditampilkan di sini</p>
      <button class="close-delivery-modal" onclick="closeDeliveryModal()">Tutup</button>
    </div>
  </div>

  <!-- Menu Detail Page dengan Tombol Share -->
  <div class="menu-detail-page" id="menuDetailPage">
    <div class="menu-detail-header">
      <div class="menu-detail-nav">
        <button class="back-btn" onclick="closeMenuDetailPage()">
          <i class="fas fa-arrow-left"></i>
        </button>
        <div class="menu-detail-title">
          <h1 id="menuDetailTitle">Detail Menu</h1>
        </div>
      </div>
    </div>

    <div class="menu-detail-content">
      <img id="menuDetailImage" class="menu-detail-image" alt="Menu Image">
      
      <div class="menu-detail-info">
        <h2 class="menu-detail-name" id="menuDetailName">Nama Menu</h2>
        <div class="menu-detail-price" id="menuDetailPrice">Rp 0</div>
        <div class="menu-detail-desc" id="menuDetailDesc">Deskripsi menu akan tampil di sini</div>
        
        <div class="menu-detail-actions">
          <button class="order-btn" id="menuOrderBtn">
            <i class="fab fa-whatsapp"></i>
            Pesan via WhatsApp
          </button>
          <button class="share-btn" id="menuShareBtn">
            <i class="fas fa-share-alt"></i>
            Bagikan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Lightbox untuk foto menu -->
  <div id="lightbox" class="lightbox">
    <span class="lightbox-close" id="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightbox-img" alt="Menu Image">
    <div class="lightbox-caption" id="lightbox-caption">
      <div class="lightbox-title" id="lightbox-title">Nama Menu</div>
      <div class="lightbox-desc" id="lightbox-desc">Deskripsi menu</div>
      <div class="lightbox-price" id="lightbox-price">Rp 0</div>
    </div>
  </div>

<script>
  let map, userMarker, searchBox;
  let locationMarkers = [];
  let infoWindow;
  let userLocation = null;
  let bottomSheet, dragHandle;
  let isDragging = false, startY, startHeight;
  let allVendors = [];
  let filteredVendors = [];
  let currentVendor = null;
  let currentMenu = null;

  // Slider variables
  let sliders = [];
  let currentSlide = 0;
  let sliderInterval = null;

  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -6.2, lng: 106.816666 },
      zoom: 13,
      styles: [
        {
          featureType: "poi",
          elementType: "labels",
          stylers: [{ visibility: "off" }]
        }
      ],
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: false
    });

    infoWindow = new google.maps.InfoWindow();

    const input = document.getElementById("search-input");
    searchBox = new google.maps.places.SearchBox(input);

    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();
      if (places.length === 0) return;

      const place = places[0];
      if (!place.geometry || !place.geometry.location) return;

      map.setCenter(place.geometry.location);
      map.setZoom(15);
    });

    input.addEventListener('input', function() {
      const query = this.value.toLowerCase().trim();
      if (query === '') {
        filteredVendors = allVendors;
      } else {
        filteredVendors = allVendors.filter(vendor => {
          return vendor.nama.toLowerCase().includes(query) ||
                 (vendor.menus && vendor.menus.some(menu => 
                   menu.nama.toLowerCase().includes(query)
                 ));
        });
      }
      displayVendors(filteredVendors);
    });

    initBottomSheet();

    // Load sliders first
    loadSliders();

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((pos) => {
        userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
        map.setCenter(userLocation);
        map.setZoom(15);

        userMarker = new google.maps.Marker({
          position: userLocation,
          map,
          title: "Lokasi Kamu",
          icon: {
            url: "https://cdn-icons-png.flaticon.com/512/4140/4140048.png",
            scaledSize: new google.maps.Size(45, 45),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(22, 45)
          }
        });

        loadVendors();
      }, (error) => {
        console.log("Error getting location:", error);
        loadVendors();
      });
    } else {
      console.log("Geolocation not supported");
      loadVendors();
    }
  }

// Filter variables
let currentRadius = 5;
let currentCategory = 'all';

// Initialize filter
function initFilter() {
  const filterToggle = document.getElementById('filter-toggle');
  const filterPanel = document.getElementById('filterPanel');
  const radiusSlider = document.getElementById('radiusSlider');
  const radiusValue = document.getElementById('radiusValue');
  const categoryChips = document.querySelectorAll('.category-chip');
  const resetBtn = document.getElementById('resetFilter');
  const applyBtn = document.getElementById('applyFilter');

  // Toggle filter panel
  filterToggle.addEventListener('click', () => {
    filterPanel.classList.toggle('active');
  });

  // Radius slider
  radiusSlider.addEventListener('input', (e) => {
    radiusValue.textContent = e.target.value;
  });

  // Category chips
  categoryChips.forEach(chip => {
    chip.addEventListener('click', () => {
      categoryChips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
    });
  });

  // Reset filter
  resetBtn.addEventListener('click', () => {
    radiusSlider.value = 5;
    radiusValue.textContent = '5';
    categoryChips.forEach(c => c.classList.remove('active'));
    categoryChips[0].classList.add('active');
  });

  // Apply filter
  applyBtn.addEventListener('click', () => {
    currentRadius = parseFloat(radiusSlider.value);
    const activeChip = document.querySelector('.category-chip.active');
    currentCategory = activeChip.dataset.category;
    
    filterVendors();
    filterPanel.classList.remove('active');
  });
}

// Filter vendors based on radius and category
function filterVendors() {
  const filtered = allVendors.filter(vendor => {
    // Filter by distance
    const distance = userLocation ? 
      parseFloat(calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude})) : 0;
    
    if (distance > currentRadius) return false;

    // Filter by category
    if (currentCategory !== 'all') {
      const categoryMap = {
        'nasi': ['nasi', 'goreng'],
        'mie': ['mie'],
        'snack': ['kue', 'martabak', 'snack'],
        'minuman': ['minuman', 'es', 'teh', 'kopi']
      };
      
      const keywords = categoryMap[currentCategory] || [];
      const matchCategory = keywords.some(keyword => 
        (vendor.informasi || '').toLowerCase().includes(keyword) || 
        vendor.nama.toLowerCase().includes(keyword) ||
        (vendor.jenis || '').toLowerCase().includes(keyword)
      );
      
      if (!matchCategory) return false;
    }

    return true;
  });

  displayVendors(filtered);
  updateQuickStats(filtered);
}

// Update quick stats
function updateQuickStats(vendors) {
  const openCount = vendors.filter(v => isVendorOpen(v.jam_buka, v.jam_tutup)).length;
  const closedCount = vendors.length - openCount;

  document.getElementById('openCount').textContent = openCount;
  document.getElementById('closedCount').textContent = closedCount;
  document.getElementById('totalCount').textContent = vendors.length;
}

// Call initFilter when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  initFilter();
});


  // Load Sliders function
  async function loadSliders() {
    try {
      const apiUrl = window.location.origin + '/api/sliders';
      console.log('Fetching sliders from:', apiUrl);

      const response = await fetch(apiUrl, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      });

      if (response.ok) {
        const result = await response.json();
        console.log('Sliders API Response:', result);
        
        let slidersData = [];
        if (result.success && result.data) {
          slidersData = result.data;
        } else if (Array.isArray(result)) {
          slidersData = result;
        } else if (result.sliders) {
          slidersData = result.sliders;
        }
        
        if (slidersData.length > 0) {
          sliders = slidersData;
          displaySliders();
        } else {
          console.log('No sliders found');
        }
      } else {
        console.error('Failed to load sliders:', response.status);
      }
    } catch (error) {
      console.error('Error loading sliders:', error);
    }
  }

  // Display Sliders function
  function displaySliders() {
    if (sliders.length === 0) return;

    const sliderSection = document.getElementById('slider-section');
    const sliderTrack = document.getElementById('sliderTrack');
    const sliderIndicators = document.getElementById('sliderIndicators');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');

    sliderSection.style.display = 'block';
    sliderTrack.innerHTML = '';
    sliderIndicators.innerHTML = '';

    // Create slider items
    sliders.forEach((slider, index) => {
      const sliderItem = document.createElement('div');
      sliderItem.className = 'slider-item';
      
      // Handle click to open link
      if (slider.link && slider.link !== '#') {
        sliderItem.onclick = () => {
          window.open(slider.link, '_blank');
        };
        sliderItem.style.cursor = 'pointer';
      }

      // Create image with fallback
      const imageUrl = slider.gambar.startsWith('http') ? slider.gambar : `/storage/${slider.gambar}`;
      sliderItem.innerHTML = `
        <img src="${imageUrl}" 
             alt="Slider ${index + 1}" 
             class="slider-image"
             onerror="this.src='/uploads/${slider.gambar}'; this.onerror=function(){this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f8f9fa;color:#666;\\'><i class=\\'fas fa-image\\' style=\\'font-size:24px;\\'></i></div>';}">
      `;
      
      sliderTrack.appendChild(sliderItem);

      // Create indicator
      const indicator = document.createElement('div');
      indicator.className = `slider-indicator ${index === 0 ? 'active' : ''}`;
      indicator.onclick = () => goToSlide(index);
      sliderIndicators.appendChild(indicator);
    });

    // Setup navigation buttons
    if (sliders.length > 1) {
      prevBtn.onclick = () => prevSlide();
      nextBtn.onclick = () => nextSlide();
      startAutoSlide();
    } else {
      prevBtn.style.display = 'none';
      nextBtn.style.display = 'none';
    }
  }

  // Slider navigation functions
  function goToSlide(index) {
    currentSlide = index;
    const sliderTrack = document.getElementById('sliderTrack');
    const indicators = document.querySelectorAll('.slider-indicator');
    
    sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    indicators.forEach((indicator, i) => {
      indicator.classList.toggle('active', i === currentSlide);
    });
    
    resetAutoSlide();
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % sliders.length;
    goToSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + sliders.length) % sliders.length;
    goToSlide(currentSlide);
  }

  function startAutoSlide() {
    if (sliders.length > 1) {
      sliderInterval = setInterval(() => {
        nextSlide();
      }, 5000); // Change slide every 5 seconds
    }
  }

  function resetAutoSlide() {
    if (sliderInterval) {
      clearInterval(sliderInterval);
      startAutoSlide();
    }
  }

  function initBottomSheet() {
    bottomSheet = document.getElementById("bottomSheet");
    dragHandle = document.getElementById("dragHandle");

    dragHandle.addEventListener("mousedown", startDrag);
    dragHandle.addEventListener("touchstart", startDrag, { passive: false });
    dragHandle.addEventListener("selectstart", (e) => e.preventDefault());
  }

  function startDrag(e) {
    isDragging = true;
    startY = e.touches ? e.touches[0].clientY : e.clientY;
    startHeight = bottomSheet.offsetHeight;
    
    dragHandle.style.cursor = "grabbing";

    document.addEventListener("mousemove", onDrag);
    document.addEventListener("mouseup", stopDrag);
    document.addEventListener("touchmove", onDrag, { passive: false });
    document.addEventListener("touchend", stopDrag);
    
    e.preventDefault();
  }

  function onDrag(e) {
    if (!isDragging) return;

    let moveY = e.touches ? e.touches[0].clientY : e.clientY;
    let deltaY = startY - moveY;
    let newHeight = startHeight + deltaY;
    
    const minHeight = 200;
    const maxHeight = window.innerHeight * 0.85;
    
    if (newHeight < minHeight) newHeight = minHeight;
    if (newHeight > maxHeight) newHeight = maxHeight;
    
    bottomSheet.style.height = newHeight + "px";
    bottomSheet.style.transition = "none";
    
    e.preventDefault();
  }

  function stopDrag() {
    if (!isDragging) return;
    
    isDragging = false;
    dragHandle.style.cursor = "grab";
    bottomSheet.style.transition = "height 0.3s cubic-bezier(0.4, 0, 0.2, 1)";
    
    const currentHeight = bottomSheet.offsetHeight;
    const windowHeight = window.innerHeight;
    
    if (currentHeight < windowHeight * 0.3) {
      bottomSheet.style.height = "200px";
    } else if (currentHeight < windowHeight * 0.6) {
      bottomSheet.style.height = "35vh";
    } else {
      bottomSheet.style.height = "75vh";
    }

    document.removeEventListener("mousemove", onDrag);
    document.removeEventListener("mouseup", stopDrag);
    document.removeEventListener("touchmove", onDrag);
    document.removeEventListener("touchend", stopDrag);
  }

  async function loadVendors() {
    if (!map) {
      console.warn('Map not initialized yet. Retrying in 1s...');
      setTimeout(loadVendors, 1000);
      return;
    }

    document.getElementById("sheet-title").textContent = "Mencari penjual terdekat...";
    document.getElementById("loading-state").style.display = "block";
    document.getElementById("empty-state").style.display = "none";
    document.getElementById("error-state").style.display = "none";
    document.getElementById("location-list").style.display = "none";

    try {
      const apiUrl = window.location.origin + '/api/vendors';
      console.log('Fetching vendors from:', apiUrl);

      const response = await fetch(apiUrl, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      });

      console.log('Response status:', response.status, response.statusText);

      if (response.ok) {
        const result = await response.json();
        console.log('API Response:', result);
        
        let vendorsData = [];
        if (result.success && result.data) {
          vendorsData = result.data;
        } else if (Array.isArray(result)) {
          vendorsData = result;
        } else if (result.vendors) {
          vendorsData = result.vendors;
        } else {
          console.warn('Unexpected API response format:', result);
          vendorsData = [];
        }
        
        allVendors = vendorsData;
        filteredVendors = allVendors;
        
        if (allVendors.length > 0) {
  displayVendors(allVendors);
  updateQuickStats(allVendors); // TAMBAHKAN INI
  console.log('Loaded', allVendors.length, 'vendors successfully');
  
  }else {
          console.log('No vendors found - showing empty state');
          showEmptyState();
        }
      } else {
        console.error('API Response Error:', response.status, response.statusText);
        const errorText = await response.text();
        console.error('Error details:', errorText);
        
        let errorMsg = `Server Error: ${response.status}`;
        if (response.status === 404) {
          errorMsg = 'Route /api/vendors tidak ditemukan. Pastikan route API sudah dibuat di Laravel.';
        } else if (response.status === 419) {
          errorMsg = 'CSRF Error: Refresh halaman dan coba lagi.';
        } else if (response.status === 500) {
          errorMsg = 'Error server backend. Cek log Laravel di storage/logs/laravel.log.';
        } else if (response.status === 0) {
          errorMsg = 'Tidak bisa terhubung ke server. Pastikan Laravel server berjalan.';
        }
        showErrorState(errorMsg);
      }
    } catch (error) {
      console.error('Network error:', error);
      let errorMsg = 'Gagal terhubung ke server.';
      
      if (error.name === 'TypeError' && error.message.includes('fetch')) {
        errorMsg = 'Koneksi ke server terputus. Pastikan Laravel server berjalan di localhost:8000';
      } else if (error.name === 'SyntaxError') {
        errorMsg = 'Server mengembalikan data yang tidak valid. Cek endpoint API Laravel.';
      }
      
      showErrorState(errorMsg);
    }
  }

function displayVendors(vendors) {
  document.getElementById("loading-state").style.display = "none";
  document.getElementById("empty-state").style.display = "none";
  document.getElementById("error-state").style.display = "none";
  document.getElementById("location-list").style.display = "block";
  
  // Update quick stats
  updateQuickStats(vendors);
  
  let sortedVendors = vendors;
  if (userLocation) {
    sortedVendors = vendors.slice().sort((a, b) => {
      const distanceA = parseFloat(calculateDistance(userLocation, {lat: a.latitude, lng: a.longitude}));
      const distanceB = parseFloat(calculateDistance(userLocation, {lat: b.latitude, lng: b.longitude}));
      return distanceA - distanceB;
    });
  }
  
  document.getElementById("sheet-title").textContent = `${sortedVendors.length} penjual ditemukan`;

  const locationList = document.getElementById("location-list");
  locationList.innerHTML = "";

  locationMarkers.forEach(marker => marker.setMap(null));
  locationMarkers = [];

  sortedVendors.forEach((vendor, index) => {
    createVendorCard(vendor, index);
    createVendorMarker(vendor, index);
  });
}

  function createVendorCard(vendor, index) {
    const card = document.createElement('div');
    card.className = 'vendor-card';
    card.dataset.lat = vendor.latitude;
    card.dataset.lng = vendor.longitude;
    card.onclick = () => selectLocation(card, vendor);

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
        <button class="action-btn menu-btn" onclick="event.stopPropagation(); openDetailPage(${vendor.id})">
          <i class="fas fa-utensils"></i>
          Lihat Menu
        </button>
        <a href="https://wa.me/${vendor.whatsapp}" target="_blank" class="action-btn whatsapp-btn" onclick="event.stopPropagation()">
          <i class="fab fa-whatsapp"></i>
          Chat
        </a>
      </div>
    `;

    document.getElementById("location-list").appendChild(card);
  }

  function createVendorMarker(vendor, index) {
    const isOpen = isVendorOpen(vendor.jam_buka, vendor.jam_tutup);
    
    // Ambil jenis penjual dari database
    const vendorType = (vendor.jenis || vendor.kategori || 'default').toLowerCase();
    
    const getCartIcon = (type, isOpen, vendorName) => {
        const baseColor = isOpen ? '#ED1C24' : '#95a5a6';
        const accentColor = isOpen ? '#c0392b' : '#7f8c8d';
        
        // Potong nama vendor maksimal 12 karakter untuk tampilan yang baik
        const displayName = vendorName.length > 12 ? vendorName.substring(0, 10) + '..' : vendorName;
        
        switch(type) {
            case 'bakso':
                return `
                    <svg width="80" height="95" viewBox="0 0 80 95" xmlns="http://www.w3.org/2000/svg">
                        <!-- Nama Penjual -->
                        <rect x="15" y="5" width="50" height="18" rx="4" fill="white" stroke="${baseColor}" stroke-width="2" filter="url(#shadow)"/>
                        <text x="40" y="17" font-family="Arial, sans-serif" font-size="8" font-weight="bold" fill="${baseColor}" text-anchor="middle" dominant-baseline="middle">${displayName}</text>
                        
                        <!-- Shadow -->
                        <ellipse cx="40" cy="90" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
                        
                        <!-- Wheels -->
                        <circle cx="20" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="20" cy="80" r="4" fill="#34495e"/>
                        <circle cx="20" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <circle cx="52" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="52" cy="80" r="4" fill="#34495e"/>
                        <circle cx="52" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <!-- Cart Base Structure -->
                        <rect x="10" y="60" width="52" height="15" rx="2" fill="${baseColor}" stroke="#c0392b" stroke-width="2"/>
                        <rect x="12" y="62" width="48" height="11" rx="1" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Wood texture lines -->
                        <line x1="12" y1="65" x2="60" y2="65" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        <line x1="12" y1="69" x2="60" y2="69" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        
                        <!-- Support bars -->
                        <rect x="14" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        <rect x="53" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        
                        <!-- Canopy Frame -->
                        <path d="M8 60 Q36 40 64 60" fill="none" stroke="#8B4513" stroke-width="3"/>
                        <rect x="7" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        <rect x="60" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        
                        <!-- Canopy with stripes -->
                        <defs>
                            <pattern id="stripes-bakso" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                                <rect width="4" height="8" fill="${accentColor}"/>
                                <rect x="4" width="4" height="8" fill="${isOpen ? '#e74c3c' : '#7f8c8d'}"/>
                            </pattern>
                        </defs>
                        <path d="M8 60 Q36 40 64 60 L64 55 Q36 35 8 55 Z" fill="url(#stripes-bakso)" stroke="#8B4513" stroke-width="1"/>
                        
                        <!-- Glass display case -->
                        <rect x="12" y="47" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)" stroke="#5d9cad" stroke-width="1.5"/>
                        <rect x="14" y="49" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)" stroke="rgba(255,255,255,0.8)" stroke-width="1"/>
                        
                        <!-- Bowl with meatballs -->
                        <ellipse cx="30" cy="53" rx="10" ry="4" fill="#fff" stroke="#ddd" stroke-width="1"/>
                        <ellipse cx="30" cy="51" rx="10" ry="4" fill="#f5f5f5" stroke="#ddd" stroke-width="1"/>
                        <ellipse cx="30" cy="52" rx="9" ry="3" fill="rgba(255,200,100,0.3)"/>
                        
                        <!-- Meatballs (bakso) -->
                        <circle cx="27" cy="50" r="2.5" fill="#8B4513" stroke="#5d2e0f" stroke-width="0.5"/>
                        <circle cx="33" cy="49.5" r="2.8" fill="#A0522D" stroke="#5d2e0f" stroke-width="0.5"/>
                        <circle cx="30" cy="51.5" r="2.3" fill="#8B4513" stroke="#5d2e0f" stroke-width="0.5"/>
                        <ellipse cx="28" cy="49" rx="0.8" ry="0.6" fill="rgba(139,69,19,0.5)"/>
                        <ellipse cx="32" cy="48.5" rx="0.8" ry="0.6" fill="rgba(139,69,19,0.5)"/>
                        
                        <!-- Hot steam effect when open -->
                        ${isOpen ? `
                        <g opacity="0.6">
                            <path d="M25 47 Q27 40 29 47" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M25 47 Q27 40 29 47;M25 47 Q23 38 21 47;M25 47 Q27 40 29 47" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.6;0.3;0.6" dur="2s" repeatCount="indefinite"/>
                            </path>
                            <path d="M31 46 Q33 39 35 46" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M31 46 Q33 39 35 46;M31 46 Q29 37 27 46;M31 46 Q33 39 35 46" dur="2.3s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.6;0.3;0.6" dur="2.3s" repeatCount="indefinite"/>
                            </path>
                            <path d="M37 47 Q39 41 41 47" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M37 47 Q39 41 41 47;M37 47 Q35 39 33 47;M37 47 Q39 41 41 47" dur="1.8s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.6;0.3;0.6" dur="1.8s" repeatCount="indefinite"/>
                            </path>
                        </g>` : ''}
                        
                        <!-- Utensils holder -->
                        <rect x="48" y="49" width="8" height="10" rx="1" fill="#c0392b" stroke="#8B0000" stroke-width="1"/>
                        <line x1="50" y1="51" x2="50" y2="57" stroke="#fff" stroke-width="0.5"/>
                        <line x1="52" y1="51" x2="52" y2="57" stroke="#fff" stroke-width="0.5"/>
                        <line x1="54" y1="51" x2="54" y2="57" stroke="#fff" stroke-width="0.5"/>
                        
                        <!-- Decorative elements -->
                        <circle cx="16" cy="57" r="1.5" fill="#FFD700" stroke="#FFA500" stroke-width="0.5"/>
                        <circle cx="56" cy="57" r="1.5" fill="#FFD700" stroke="#FFA500" stroke-width="0.5"/>
                        
                        <!-- Shadow filter -->
                        <defs>
                            <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                                <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                            </filter>
                        </defs>
                    </svg>
                `;
                
            case 'siomay':
                return `
                    <svg width="80" height="95" viewBox="0 0 80 95" xmlns="http://www.w3.org/2000/svg">
                        <!-- Nama Penjual -->
                        <rect x="15" y="5" width="50" height="18" rx="4" fill="white" stroke="#f39c12" stroke-width="2" filter="url(#shadow)"/>
                        <text x="40" y="17" font-family="Arial, sans-serif" font-size="8" font-weight="bold" fill="#f39c12" text-anchor="middle" dominant-baseline="middle">${displayName}</text>
                        
                        <!-- Shadow -->
                        <ellipse cx="40" cy="90" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
                        
                        <!-- Wheels -->
                        <circle cx="20" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="20" cy="80" r="4" fill="#34495e"/>
                        <circle cx="20" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <circle cx="52" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="52" cy="80" r="4" fill="#34495e"/>
                        <circle cx="52" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <!-- Cart Base Structure -->
                        <rect x="10" y="60" width="52" height="15" rx="2" fill="${baseColor}" stroke="#c0392b" stroke-width="2"/>
                        <rect x="12" y="62" width="48" height="11" rx="1" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Wood texture lines -->
                        <line x1="12" y1="65" x2="60" y2="65" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        <line x1="12" y1="69" x2="60" y2="69" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        
                        <!-- Support bars -->
                        <rect x="14" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        <rect x="53" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        
                        <!-- Canopy Frame -->
                        <path d="M8 60 Q36 40 64 60" fill="none" stroke="#8B4513" stroke-width="3"/>
                        <rect x="7" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        <rect x="60" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        
                        <!-- Canopy with stripes -->
                        <defs>
                            <pattern id="stripes-siomay" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                                <rect width="4" height="8" fill="#f39c12"/>
                                <rect x="4" width="4" height="8" fill="${isOpen ? '#e67e22' : '#7f8c8d'}"/>
                            </pattern>
                        </defs>
                        <path d="M8 60 Q36 40 64 60 L64 55 Q36 35 8 55 Z" fill="url(#stripes-siomay)" stroke="#8B4513" stroke-width="1"/>
                        
                        <!-- Glass display case -->
                        <rect x="12" y="47" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)" stroke="#5d9cad" stroke-width="1.5"/>
                        <rect x="14" y="49" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)" stroke="rgba(255,255,255,0.8)" stroke-width="1"/>
                        
                        <!-- Food items -->
                        <rect x="18" y="51" width="5" height="4" rx="1" fill="#F4A460" stroke="#CD853F" stroke-width="0.5"/>
                        <rect x="25" y="50" width="5" height="4" rx="1" fill="#DEB887" stroke="#D2691E" stroke-width="0.5"/>
                        <rect x="32" y="51" width="5" height="4" rx="1" fill="#CD853F" stroke="#A0522D" stroke-width="0.5"/>
                        <rect x="39" y="50.5" width="5" height="4" rx="1" fill="#F5DEB3" stroke="#DEB887" stroke-width="0.5"/>
                        <rect x="46" y="51" width="5" height="4" rx="1" fill="#FFB347" stroke="#FF8C00" stroke-width="0.5"/>
                        
                        <!-- Toppings on food -->
                        <circle cx="20.5" cy="52" r="0.8" fill="#e74c3c"/>
                        <circle cx="27.5" cy="51" r="0.8" fill="#27ae60"/>
                        <circle cx="34.5" cy="52" r="0.8" fill="#f39c12"/>
                        
                        <!-- Storage compartment -->
                        <rect x="48" y="49" width="8" height="10" rx="1" fill="#95a5a6" stroke="#7f8c8d" stroke-width="1"/>
                        <rect x="49" y="51" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        <rect x="49" y="54" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        
                        <!-- Decorative elements -->
                        <circle cx="16" cy="57" r="1.5" fill="#FFD700" stroke="#FFA500" stroke-width="0.5"/>
                        <circle cx="56" cy="57" r="1.5" fill="#FFD700" stroke="#FFA500" stroke-width="0.5"/>
                        
                        <!-- Shadow filter -->
                        <defs>
                            <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                                <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                            </filter>
                        </defs>
                    </svg>
                `;
                
            case 'minuman':
                return `
                    <svg width="80" height="95" viewBox="0 0 80 95" xmlns="http://www.w3.org/2000/svg">
                        <!-- Nama Penjual -->
                        <rect x="15" y="5" width="50" height="18" rx="4" fill="white" stroke="#3498db" stroke-width="2" filter="url(#shadow)"/>
                        <text x="40" y="17" font-family="Arial, sans-serif" font-size="8" font-weight="bold" fill="#3498db" text-anchor="middle" dominant-baseline="middle">${displayName}</text>
                        
                        <!-- Shadow -->
                        <ellipse cx="40" cy="90" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
                        
                        <!-- Wheels -->
                        <circle cx="20" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="20" cy="80" r="4" fill="#34495e"/>
                        <circle cx="20" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <circle cx="52" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="52" cy="80" r="4" fill="#34495e"/>
                        <circle cx="52" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <!-- Cart Base Structure -->
                        <rect x="10" y="60" width="52" height="15" rx="2" fill="${baseColor}" stroke="#c0392b" stroke-width="2"/>
                        <rect x="12" y="62" width="48" height="11" rx="1" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Wood texture lines -->
                        <line x1="12" y1="65" x2="60" y2="65" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        <line x1="12" y1="69" x2="60" y2="69" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        
                        <!-- Support bars -->
                        <rect x="14" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        <rect x="53" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        
                        <!-- Canopy Frame -->
                        <path d="M8 60 Q36 40 64 60" fill="none" stroke="#8B4513" stroke-width="3"/>
                        <rect x="7" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        <rect x="60" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        
                        <!-- Canopy with stripes -->
                        <defs>
                            <pattern id="stripes-minuman" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                                <rect width="4" height="8" fill="#3498db"/>
                                <rect x="4" width="4" height="8" fill="${isOpen ? '#2980b9' : '#7f8c8d'}"/>
                            </pattern>
                        </defs>
                        <path d="M8 60 Q36 40 64 60 L64 55 Q36 35 8 55 Z" fill="url(#stripes-minuman)" stroke="#8B4513" stroke-width="1"/>
                        
                        <!-- Glass display case -->
                        <rect x="12" y="47" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)" stroke="#5d9cad" stroke-width="1.5"/>
                        <rect x="14" y="49" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)" stroke="rgba(255,255,255,0.8)" stroke-width="1"/>
                        
                        <!-- Gelas minuman -->
                        <path d="M20 53 L20 58 L34 58 L34 53 Z" fill="#87CEEB" stroke="#4682B4" stroke-width="1"/>
                        <path d="M22 51 L22 53 L32 53 L32 51 Z" fill="#E3F2FD" stroke="#4682B4" stroke-width="0.5"/>
                        <ellipse cx="27" cy="58" rx="7" ry="1" fill="#4682B4"/>
                        
                        <!-- Sedotan -->
                        <rect x="30" y="48" width="1" height="10" rx="0.5" fill="#FFD700"/>
                        <circle cx="30.5" cy="48" r="1" fill="#FF6B35"/>
                        
                        <!-- Ice cubes -->
                        <rect x="23" y="55" width="2" height="2" rx="0.3" fill="rgba(255,255,255,0.8)" stroke="rgba(200,200,255,0.5)" stroke-width="0.2"/>
                        <rect x="26" y="54" width="2" height="2" rx="0.3" fill="rgba(255,255,255,0.8)" stroke="rgba(200,200,255,0.5)" stroke-width="0.2"/>
                        <rect x="29" y="55" width="2" height="2" rx="0.3" fill="rgba(255,255,255,0.8)" stroke="rgba(200,200,255,0.5)" stroke-width="0.2"/>
                        
                        ${isOpen ? `
                        <g opacity="0.6">
                            <path d="M25 52 Q27 45 29 52" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round">
                                <animate attributeName="d" values="M25 52 Q27 45 29 52;M25 52 Q23 43 21 52;M25 52 Q27 45 29 52" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="0.6;0.3;0.6" dur="2s" repeatCount="indefinite"/>
                            </path>
                        </g>` : ''}
                        
                        <!-- Storage compartment -->
                        <rect x="48" y="49" width="8" height="10" rx="1" fill="#3498db" stroke="#2980b9" stroke-width="1"/>
                        <rect x="49" y="51" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        <rect x="49" y="54" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        
                        <!-- Shadow filter -->
                        <defs>
                            <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                                <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                            </filter>
                        </defs>
                    </svg>
                `;
                
            default:
                return `
                    <svg width="80" height="95" viewBox="0 0 80 95" xmlns="http://www.w3.org/2000/svg">
                        <!-- Nama Penjual -->
                        <rect x="15" y="5" width="50" height="18" rx="4" fill="white" stroke="#9C27B0" stroke-width="2" filter="url(#shadow)"/>
                        <text x="40" y="17" font-family="Arial, sans-serif" font-size="8" font-weight="bold" fill="#9C27B0" text-anchor="middle" dominant-baseline="middle">${displayName}</text>
                        
                        <!-- Shadow -->
                        <ellipse cx="40" cy="90" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
                        
                        <!-- Wheels -->
                        <circle cx="20" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="20" cy="80" r="4" fill="#34495e"/>
                        <circle cx="20" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <circle cx="52" cy="80" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
                        <circle cx="52" cy="80" r="4" fill="#34495e"/>
                        <circle cx="52" cy="80" r="2" fill="#7f8c8d"/>
                        
                        <!-- Cart Base Structure -->
                        <rect x="10" y="60" width="52" height="15" rx="2" fill="${baseColor}" stroke="#c0392b" stroke-width="2"/>
                        <rect x="12" y="62" width="48" height="11" rx="1" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Wood texture lines -->
                        <line x1="12" y1="65" x2="60" y2="65" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        <line x1="12" y1="69" x2="60" y2="69" stroke="rgba(0,0,0,0.1)" stroke-width="0.5"/>
                        
                        <!-- Support bars -->
                        <rect x="14" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        <rect x="53" y="57" width="3" height="8" fill="#8B4513" stroke="#5d2e0f" stroke-width="1"/>
                        
                        <!-- Canopy Frame -->
                        <path d="M8 60 Q36 40 64 60" fill="none" stroke="#8B4513" stroke-width="3"/>
                        <rect x="7" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        <rect x="60" y="59" width="3" height="5" rx="1" fill="#8B4513"/>
                        
                        <!-- Canopy with stripes -->
                        <defs>
                            <pattern id="stripes-default" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                                <rect width="4" height="8" fill="#9C27B0"/>
                                <rect x="4" width="4" height="8" fill="${isOpen ? '#7B1FA2' : '#7f8c8d'}"/>
                            </pattern>
                        </defs>
                        <path d="M8 60 Q36 40 64 60 L64 55 Q36 35 8 55 Z" fill="url(#stripes-default)" stroke="#8B4513" stroke-width="1"/>
                        
                        <!-- Glass display case -->
                        <rect x="12" y="47" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)" stroke="#5d9cad" stroke-width="1.5"/>
                        <rect x="14" y="49" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)" stroke="rgba(255,255,255,0.8)" stroke-width="1"/>
                        
                        <!-- Various food items -->
                        <rect x="18" y="51" width="4" height="3" rx="1" fill="#F4A460"/>
                        <rect x="25" y="50" width="4" height="3" rx="1" fill="#DEB887"/>
                        <rect x="32" y="51" width="4" height="3" rx="1" fill="#CD853F"/>
                        <rect x="39" y="50" width="4" height="3" rx="1" fill="#F5DEB3"/>
                        <rect x="46" y="51" width="4" height="3" rx="1" fill="#FFB347"/>
                        
                        <!-- Storage compartment -->
                        <rect x="48" y="49" width="8" height="10" rx="1" fill="#9C27B0" stroke="#7B1FA2" stroke-width="1"/>
                        <rect x="49" y="51" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        <rect x="49" y="54" width="6" height="2" rx="0.5" fill="#bdc3c7"/>
                        
                        <!-- Shadow filter -->
                        <defs>
                            <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                                <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                            </filter>
                        </defs>
                    </svg>
                `;
        }
    };
    
    const marker = new google.maps.Marker({
        position: { lat: vendor.latitude, lng: vendor.longitude },
        map,
        title: vendor.nama,
        icon: {
            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(getCartIcon(vendorType, isOpen, vendor.nama)),
            scaledSize: new google.maps.Size(60, 70),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(30, 70)
        }
    });

    marker.addListener('click', () => {
        marker.setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(() => {
            marker.setAnimation(null);
        }, 2000);

        const isOpen = isVendorOpen(vendor.jam_buka, vendor.jam_tutup);
        
        infoWindow.setContent(`
            <div style="padding: 15px; max-width: 280px; font-family: 'Segoe UI', sans-serif;">
                <div style="display: flex; align-items: center; margin-bottom: 12px;">
                    <h4 style="margin: 0; color: #2c3e50; font-size: 15px; flex: 1;">${vendor.nama}</h4>
                    <span style="font-size: 10px; color: ${isOpen ? '#27ae60' : '#ED1C24'}; font-weight: bold;">
                        ${isOpen ? 'BUKA' : 'TUTUP'}
                    </span>
                </div>
                
                <div style="font-size: 11px; color: #7f8c8d; margin-bottom: 8px;">${vendor.informasi || 'Informasi toko belum tersedia'}</div>

                <div style="margin-bottom: 15px;">
                    <div style="font-size: 11px; color: #7f8c8d; margin-bottom: 4px;">
                        <i class="fas fa-clock" style="margin-right: 5px; color: #ED1C24;"></i>
                        ${vendor.jam_buka} - ${vendor.jam_tutup}
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d; margin-bottom: 4px;">
                        <i class="fas fa-phone" style="margin-right: 5px; color: #ED1C24;"></i>
                        +${vendor.whatsapp}
                    </div>
                    <div style="font-size: 11px; color: #7f8c8d;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #ED1C24;"></i>
                        ${userLocation ? calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude}) : '0.0'} KM
                    </div>
                </div>

                <div style="display: flex; gap: 6px;">
                    <button onclick="openDetailPage(${vendor.id})" 
                           style="flex: 1; background: #3498db; color: white; border: none; padding: 6px 10px; 
                                  border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer;
                                  transition: all 0.3s ease;" 
                           onmouseover="this.style.background='#2980b9'" 
                           onmouseout="this.style.background='#3498db'">
                        <i class="fas fa-utensils" style="margin-right: 4px;"></i>
                        Lihat Menu
                    </button>
                    <a href="https://wa.me/${vendor.whatsapp}" target="_blank" 
                       style="background: #25d366; color: white; border: none; padding: 6px 10px; 
                              border-radius: 15px; text-decoration: none; font-size: 11px; 
                              font-weight: bold; transition: all 0.3s ease; display: flex; align-items: center; gap: 4px;" 
                       onmouseover="this.style.background='#128c7e'" 
                       onmouseout="this.style.background='#25d366'">
                        <i class="fab fa-whatsapp"></i>
                        Chat
                    </a>
                </div>
            </div>
        `);
        infoWindow.open(map, marker);
    });

    locationMarkers.push(marker);
}


  function openDetailPage(vendorId) {
    const vendor = allVendors.find(v => v.id === vendorId);
    if (!vendor) return;

    currentVendor = vendor;

    if (infoWindow) {
      infoWindow.close();
    }

    document.getElementById('detailVendorName').textContent = vendor.nama;
    document.getElementById('detailVendorType').textContent = vendor.informasi || 'Informasi toko belum tersedia';
    
    // Set header info
    document.getElementById('headerHours').textContent = `${vendor.jam_buka} - ${vendor.jam_tutup}`;
    document.getElementById('headerDistance').textContent = userLocation ? 
      `${calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude})} KM` : '0.0 KM';
    document.getElementById('headerPhone').textContent = `+${vendor.whatsapp}`;
    
    const isOpen = isVendorOpen(vendor.jam_buka, vendor.jam_tutup);
    const statusElement = document.getElementById('headerStatus');
    statusElement.textContent = isOpen ? 'BUKA' : 'TUTUP';
    statusElement.className = `header-status ${isOpen ? 'open' : 'closed'}`;
    
    // Setup tombol WhatsApp
    const whatsappBtn = document.getElementById('detailWhatsappBtn');
    whatsappBtn.onclick = () => {
      window.open(`https://wa.me/${vendor.whatsapp}`, '_blank');
    };

    // Setup tombol layanan antar
    const deliveryBtn = document.getElementById('deliveryBtn');
    deliveryBtn.onclick = () => {
      openDeliveryModal(vendor);
    };

    const menuGrid = document.getElementById('detailMenuGrid');
    menuGrid.innerHTML = '';
    
    if (vendor.menus && vendor.menus.length > 0) {
      vendor.menus.forEach(menu => {
        const menuItem = document.createElement('div');
        menuItem.className = 'menu-item';
        
        const fotoField = menu.foto || menu.photo_url || menu.image || null;
        
        let photoHtml = '';
        if (fotoField) {
          const photoPath1 = `/storage/${fotoField}`;
          const photoPath2 = `${window.location.origin}/storage/${fotoField}`;
          const photoPath3 = `/uploads/${fotoField}`;
          
          photoHtml = `
            <img src="${photoPath1}" alt="${menu.nama || menu.nama_menu}" class="menu-photo" 
                 onclick="showLightbox('${photoPath1}', '${menu.nama || menu.nama_menu}', '${menu.deskripsi || 'Menu lezat dan segar'}', 'Rp ${parseInt(menu.harga).toLocaleString('id-ID')}')"
                 onerror="
                   this.src='${photoPath2}';
                   this.onerror = function() {
                     this.src='${photoPath3}';
                     this.onerror = function() {
                       this.style.display='none';
                       this.nextElementSibling.style.display='flex';
                     };
                   };
                 ">
            <div class="menu-photo placeholder" style="display: none;" onclick="showLightbox(null, '${menu.nama || menu.nama_menu}', '${menu.deskripsi || 'Menu lezat dan segar'}', 'Rp ${parseInt(menu.harga).toLocaleString('id-ID')}')">
              <i class="fas fa-utensils"></i>
            </div>`;
        } else {
          photoHtml = `
            <div class="menu-photo placeholder" onclick="showLightbox(null, '${menu.nama || menu.nama_menu}', '${menu.deskripsi || 'Menu lezat dan segar'}', 'Rp ${parseInt(menu.harga).toLocaleString('id-ID')}')">
              <i class="fas fa-utensils"></i>
            </div>`;
        }
        
        menuItem.innerHTML = `
          ${photoHtml}
          <div class="menu-content" onclick="openMenuDetail('${menu.id}', '${encodeURIComponent(menu.nama)}', '${encodeURIComponent(menu.deskripsi || 'Menu lezat dan segar')}', '${menu.harga}', '${fotoField ? `/storage/${fotoField}` : null}')">
            <div class="menu-info">
              <h4>${menu.nama || menu.nama_menu}</h4>
              <div class="menu-desc">${menu.deskripsi || 'Menu lezat dan segar'}</div>
            </div>
            <div class="menu-price">Rp ${parseInt(menu.harga).toLocaleString('id-ID')}</div>
          </div>
        `;
        menuGrid.appendChild(menuItem);
      });
    } else {
      menuGrid.innerHTML = `
        <div style="text-align: center; padding: 30px 15px; color: #7f8c8d;">
          <i class="fas fa-utensils" style="font-size: 40px; margin-bottom: 15px; color: #bdc3c7;"></i>
          <div style="font-size: 14px; margin-bottom: 8px;">Menu Belum Tersedia</div>
          <div style="font-size: 11px;">Hubungi penjual untuk informasi menu</div>
        </div>
      `;
    }

    document.getElementById('detailPage').style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  // Fungsi untuk membuka modal layanan antar
  function openDeliveryModal(vendor) {
    const modal = document.getElementById('deliveryModal');
    const modalText = document.getElementById('deliveryModalText');
    
    // Tampilkan informasi layanan antar
    if (vendor.layanan_antar) {
      modalText.textContent = vendor.layanan_antar;
    } else {
      modalText.textContent = 'Layanan antar tersedia untuk area Ciledug dan sekitarnya. Silakan hubungi penjual untuk informasi lebih lanjut.';
    }
    
    modal.style.display = 'flex';
  }

  // Fungsi untuk menutup modal layanan antar
  function closeDeliveryModal() {
    const modal = document.getElementById('deliveryModal');
    modal.style.display = 'none';
  }

  function openMenuDetail(menuId, menuName, menuDesc, menuPrice, menuImage) {
    document.getElementById('menuDetailTitle').textContent = 'Detail Menu';
    document.getElementById('menuDetailName').textContent = decodeURIComponent(menuName);
    document.getElementById('menuDetailDesc').textContent = decodeURIComponent(menuDesc);
    document.getElementById('menuDetailPrice').textContent = `Rp ${parseInt(menuPrice).toLocaleString('id-ID')}`;
    
    const menuDetailImage = document.getElementById('menuDetailImage');
    if (menuImage && menuImage !== 'null') {
      menuDetailImage.src = menuImage;
      menuDetailImage.style.display = 'block';
      menuDetailImage.onerror = function() {
        this.style.display = 'none';
      };
    } else {
      menuDetailImage.style.display = 'none';
    }
    
    // Simpan data menu untuk share
    currentMenu = {
      name: decodeURIComponent(menuName),
      price: `Rp ${parseInt(menuPrice).toLocaleString('id-ID')}`,
      desc: decodeURIComponent(menuDesc)
    };
    
    const orderBtn = document.getElementById('menuOrderBtn');
    orderBtn.onclick = () => {
      if (currentVendor) {
        const message = `Halo, saya ingin memesan ${currentMenu.name} seharga ${currentMenu.price}`;
        window.open(`https://wa.me/${currentVendor.whatsapp}?text=${encodeURIComponent(message)}`, '_blank');
      }
    };
    
    // Setup tombol share
    const shareBtn = document.getElementById('menuShareBtn');
    shareBtn.onclick = () => {
      shareMenu();
    };
    
    document.getElementById('menuDetailPage').style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  // Fungsi untuk share menu
  function shareMenu() {
    if (navigator.share) {
      // Web Share API
      navigator.share({
        title: currentMenu.name,
        text: `Coba ${currentMenu.name} - ${currentMenu.price}. ${currentMenu.desc}`,
        url: window.location.href
      })
      .catch(error => console.log('Error sharing:', error));
    } else {
      // Fallback untuk browser yang tidak mendukung Web Share API
      const text = `Lihat menu ${currentMenu.name} - ${currentMenu.price} di Sekitarmu! ${window.location.href}`;
      
      // Coba buka WhatsApp
      window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
    }
  }

  function closeMenuDetailPage() {
    document.getElementById('menuDetailPage').style.display = 'none';
    document.body.style.overflow = 'hidden';
  }

  function closeDetailPage() {
    document.getElementById('detailPage').style.display = 'none';
    document.body.style.overflow = 'hidden';
  }

  function showEmptyState() {
    document.getElementById("loading-state").style.display = "none";
    document.getElementById("error-state").style.display = "none";
    document.getElementById("empty-state").style.display = "block";
    document.getElementById("location-list").style.display = "none";
    
    document.getElementById("sheet-title").textContent = "Tidak ada penjual ditemukan";
  }

  function showErrorState(message = 'Terjadi kesalahan saat memuat data') {
    document.getElementById("loading-state").style.display = "none";
    document.getElementById("empty-state").style.display = "none";
    document.getElementById("error-state").style.display = "block";
    document.getElementById("location-list").style.display = "none";
    
    document.getElementById("sheet-title").textContent = "Gagal memuat data";
    document.getElementById("error-message").textContent = message;
  }

  function selectLocation(card, vendor) {
    const lat = parseFloat(card.dataset.lat);
    const lng = parseFloat(card.dataset.lng);
    
    map.setCenter({ lat, lng });
    map.setZoom(17);
    
    document.querySelectorAll('.vendor-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    
    const cardIndex = Array.from(document.querySelectorAll('.vendor-card')).indexOf(card);
    if (locationMarkers[cardIndex]) {
      google.maps.event.trigger(locationMarkers[cardIndex], 'click');
    }
  }

  function calculateDistance(pos1, pos2) {
    if (!pos1 || !pos2) return "0.0";
    
    const R = 6371;
    const dLat = (pos2.lat - pos1.lat) * Math.PI / 180;
    const dLon = (pos2.lng - pos1.lng) * Math.PI / 180;
    const a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(pos1.lat * Math.PI / 180) * Math.cos(pos2.lat * Math.PI / 180) * 
      Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    const d = R * c;
    return d.toFixed(1);
  }

  function isVendorOpen(jamBuka, jamTutup) {
    const now = new Date();
    const currentTime = now.getHours() * 60 + now.getMinutes();
    
    const [bukaHour, bukaMenit] = jamBuka.split(':').map(Number);
    const [tutupHour, tutupMenit] = jamTutup.split(':').map(Number);
    
    const buka = bukaHour * 60 + bukaMenit;
    const tutup = tutupHour * 60 + tutupMenit;
    
    if (tutup < buka) {
      return currentTime >= buka || currentTime <= tutup;
    }
    
    return currentTime >= buka && currentTime <= tutup;
  }

  // Lightbox functions
  function showLightbox(imageSrc, menuName, menuDesc, menuPrice) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxDesc = document.getElementById('lightbox-desc');
    const lightboxPriceEl = document.getElementById('lightbox-price');
    
    if (imageSrc && imageSrc !== 'null') {
      lightboxImg.src = imageSrc;
      lightboxImg.style.display = 'block';
    } else {
      lightboxImg.style.display = 'none';
    }
    
    lightboxTitle.textContent = menuName;
    lightboxDesc.textContent = menuDesc;
    lightboxPriceEl.textContent = menuPrice;
    
    lightbox.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  function hideLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.style.display = 'none';
    document.body.style.overflow = 'hidden';
  }

  // Event listeners
  document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const closeBtn = document.getElementById('lightbox-close');
    const deliveryModal = document.getElementById('deliveryModal');
    
    if (closeBtn) {
      closeBtn.addEventListener('click', hideLightbox);
    }
    
    if (lightbox) {
      lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
          hideLightbox();
        }
      });
    }
    
    if (deliveryModal) {
      deliveryModal.addEventListener('click', function(e) {
        if (e.target === deliveryModal) {
          closeDeliveryModal();
        }
      });
    }
  });

  window.addEventListener('resize', () => {
    if (map) {
      google.maps.event.trigger(map, 'resize');
    }
  });

  window.addEventListener('load', () => {
    setTimeout(() => {
      if (map) {
        google.maps.event.trigger(map, 'resize');
      }
    }, 100);
  });

  setInterval(() => {
    if (document.getElementById('detailPage').style.display !== 'block' && 
        document.getElementById('menuDetailPage').style.display !== 'block') {
      loadVendors();
    }
  }, 5 * 60 * 1000);

  window.addEventListener('popstate', function(event) {
    if (document.getElementById('menuDetailPage').style.display === 'block') {
      closeMenuDetailPage();
      event.preventDefault();
    } else if (document.getElementById('detailPage').style.display === 'block') {
      closeDetailPage();
      event.preventDefault();
    }
  });

  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      if (document.getElementById('lightbox').style.display === 'block') {
        hideLightbox();
      } else if (document.getElementById('menuDetailPage').style.display === 'block') {
        closeMenuDetailPage();
      } else if (document.getElementById('detailPage').style.display === 'block') {
        closeDetailPage();
      } else if (document.getElementById('deliveryModal').style.display === 'flex') {
        closeDeliveryModal();
      }
    }

  });
</script>

<!-- Google Maps API -->
<script async
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAulkhTQ36NXoZ7_SMNRv1nv2hz6jmrZxc&libraries=places&callback=initMap">
</script>
</body>
</html>