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


      
    }
  </style>
</head>
<body>
  <!-- Header dengan Login/Register -->
  <<!-- === HEADER === -->
<div class="header">
  <div class="header-left">
    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('assets/img/sekitarmu.png') }}" 
         alt="Sekitarmu Logo" 
         class="logo-img">
      </a>
    </div>

    <!-- Search -->
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
          console.log('Loaded', allVendors.length, 'vendors successfully');
        } else {
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
    
    let sortedVendors = vendors;
    if (userLocation) {
      sortedVendors = vendors.slice().sort((a, b) => {
        const distanceA = parseFloat(calculateDistance(userLocation, {lat: a.latitude, lng: a.longitude}));
        const distanceB = parseFloat(calculateDistance(userLocation, {lat: b.latitude, lng: b.longitude}));
        return distanceA - distanceB;
      });
      console.log('Vendors sorted by distance from user location');
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
    
    // Ambil jenis penjual dari database (LOGIKA DATABASE TETAP SAMA)
    const vendorType = (vendor.jenis || vendor.kategori || 'default').toLowerCase();
    
    // Fungsi ikon dengan logo custom
    const getSimpleIcon = (type, isOpen, vendorName, uniqueId) => {
        // WARNA MERAH untuk status BUKA
        let bgColorFrom = isOpen ? '#ef4444' : '#d1d5db'; // red-500 : gray-300
        let bgColorTo = isOpen ? '#dc2626' : '#9ca3af';   // red-600 : gray-500
        let borderColor = isOpen ? '#ef4444' : '#6b7280'; // red-500 : gray-500
        let labelBg = isOpen ? 'white' : '#f3f4f6';
        let labelBorder = isOpen ? '#ef4444' : '#d1d5db'; // red-500 : gray-300
        let labelText = isOpen ? '#1f2937' : '#6b7280';
        
        // Potong nama jika terlalu panjang
        const displayName = vendorName.length > 15 ? vendorName.substring(0, 13) + '..' : vendorName;
        
        // Buat ID unik untuk gradient
        const gradientId = `markerGradient${uniqueId}${isOpen ? 'Open' : 'Closed'}`;
        const shadowId = `shadow${uniqueId}`;
        
        return `
            <svg width="120" height="110" viewBox="0 0 120 110" xmlns="http://www.w3.org/2000/svg">
                <!-- Nama Penjual Label -->
                <g transform="translate(60, 10)">
                    <rect x="-45" y="0" width="90" height="20" rx="8" 
                          fill="${labelBg}" 
                          stroke="${labelBorder}" 
                          stroke-width="2" 
                          filter="url(#${shadowId})"/>
                    <text x="0" y="13" 
                          font-family="Arial, sans-serif" 
                          font-size="10" 
                          font-weight="bold" 
                          fill="${labelText}" 
                          text-anchor="middle">${displayName}</text>
                    <!-- Arrow pointing down -->
                    <path d="M -4 20 L 0 24 L 4 20" 
                          fill="${labelBorder}" 
                          stroke="none"/>
                </g>
                
                <!-- Shadow untuk marker -->
                <ellipse cx="60" cy="105" rx="18" ry="3" fill="rgba(0,0,0,0.2)"/>
                
                <!-- Marker Circle -->
                <defs>
                    <linearGradient id="${gradientId}" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:${bgColorFrom};stop-opacity:1" />
                        <stop offset="100%" style="stop-color:${bgColorTo};stop-opacity:1" />
                    </linearGradient>
                    
                    <filter id="${shadowId}" x="-50%" y="-50%" width="200%" height="200%">
                        <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="rgba(0,0,0,0.15)"/>
                    </filter>
                </defs>
                
                <circle cx="60" cy="55" r="22" 
                        fill="url(#${gradientId})" 
                        stroke="white" 
                        stroke-width="4"
                        filter="url(#${shadowId})"/>
                
                <!-- Logo Custom (scaled dan diposisikan di tengah circle) -->
                <g transform="translate(60, 55) scale(0.025) translate(-670, -785)">
                    <path d="M10.8712 786.188C8.12579 766.295 5.06097 747.307 2.98916 728.212C-0.57334 695.378 -0.295783 662.372 1.52187 629.486C3.39086 595.671 8.42837 562.175 15.924 529.089C33.9146 449.678 66.0479 376.428 111.942 309.241C133.559 277.594 158.043 248.239 185.022 221.013C213.371 192.404 241.601 163.681 273.311 138.641C328.328 95.1948 388.645 61.4298 454.667 37.7456C508.537 18.4213 563.997 6.40576 620.98 2.30442C668.841 -1.14047 716.645 0.294529 764.282 7.40717C833.314 17.7142 898.898 38.5396 960.963 70.276C1012.47 96.6129 1059.79 129.155 1101.9 168.929C1133.37 198.65 1164.46 228.764 1192.32 262.028C1220.19 295.296 1244.23 331.077 1264.76 369.29C1290.06 416.392 1309.02 465.907 1321.62 517.844C1329.47 550.163 1334.68 582.877 1337.52 616.069C1340.37 649.346 1340.67 682.682 1338.37 715.812C1331.99 807.517 1306.86 894.132 1262.93 974.988C1236.61 1023.42 1204.78 1068.02 1166.3 1107.64C1141.7 1132.96 1116.9 1158.1 1091.95 1183.08C972.51 1302.62 852.955 1422.05 733.537 1541.62C718.732 1556.44 701.881 1566.98 680.734 1569.37C654.799 1572.29 631.742 1565.66 613.061 1546.99C466.16 1400.23 319.193 1253.53 172.656 1106.41C140.384 1074.01 113.922 1036.82 90.3484 997.648C55.4258 939.613 31.0477 877.347 15.826 811.433C13.9623 803.363 12.5956 795.177 10.8712 786.188ZM842 414.548C928.83 414.548 1015.66 414.548 1104.71 414.548C1074.92 366.529 1046.25 320.305 1017.52 274.004C1012.96 274.004 1008.98 274.004 1005 274.004C864.72 274.004 724.438 274.004 584.155 274.004C499.853 274.004 415.55 274.058 331.247 273.888C325.328 273.876 321.67 275.391 318.418 280.697C292.667 322.722 266.569 364.536 240.606 406.432C239.273 408.584 238.198 410.896 236.247 414.549C438.423 414.549 639.211 414.549 842 414.548ZM740.509 606.59C684.989 637.331 632.156 631.326 581.885 594.911C522.714 636.845 463.904 636.85 405.719 595.377C391.106 603.64 376.744 611.761 361.846 620.185C361.846 622.261 361.846 624.916 361.846 627.571C361.846 724.186 361.845 820.801 361.847 917.416C361.847 919.415 361.79 921.419 361.904 923.412C362.734 937.931 368.66 943.657 383.363 943.662C512.627 943.701 641.892 943.69 771.156 943.654C773.677 943.653 776.197 943.169 779.159 942.865C779.159 919.46 779.195 896.823 779.093 874.187C779.085 872.329 778.735 869.834 777.535 868.734C772.949 864.526 768.403 859.944 763.026 856.985C741.078 844.908 725.605 827.413 716.628 804.083C715.589 801.382 714.419 798.732 713.024 795.372C710.619 797.221 708.762 798.483 707.093 799.958C692.366 812.975 677.679 826.036 662.969 839.071C646.513 853.652 630.287 868.506 613.507 882.704C599.286 894.738 579.019 887.267 575.881 869.173C574.463 860.992 577.556 854.077 583.562 848.581C591.425 841.384 599.474 834.392 607.45 827.319C639.105 799.25 670.702 771.115 702.489 743.196C706.784 739.423 708.971 735.514 709.375 729.7C709.926 721.768 711.362 713.839 713.088 706.057C721.653 667.458 735.914 631.637 764.369 602.892C764.99 602.265 765.188 601.219 765.771 599.964C763.361 598.127 761.034 596.353 758.632 594.522C752.784 598.47 747.291 602.178 740.509 606.59ZM687.745 576.136C709.919 571.69 727.602 560.165 741.635 542.539C752.353 529.078 764.724 529.297 775.478 542.709C813.344 589.933 880.596 590.161 917.855 542.543C927.273 530.506 942.995 529.738 952.138 542.338C966.506 562.138 986.558 573.374 1010.72 576.941C1014.46 577.492 1018.47 576.479 1022.31 575.929C1029.17 574.947 1036.13 572.381 1042.79 573.057C1049.55 573.743 1055.27 572.587 1060.98 569.823C1084.66 558.36 1100.81 540.28 1109.07 515.163C1114.94 497.302 1112.65 479.075 1112.84 460.51C817.251 460.51 522.502 460.51 226.343 460.51C227.127 475.419 226.421 489.888 228.903 503.787C235.578 541.167 258.293 565.643 294.739 574.974C330.8 584.206 361.748 573.161 386.303 544.961C388.269 542.703 389.882 540.1 392.031 538.046C399.594 530.818 410.555 530.827 418.16 538.025C420.08 539.843 421.619 542.068 423.293 544.139C459.746 589.232 526.709 589.372 563.401 544.422C564.876 542.616 566.158 540.634 567.762 538.955C575.63 530.721 587.301 530.515 595.288 538.581C598.091 541.412 600.322 544.802 603.043 547.723C625.623 571.962 653.208 581.802 687.745 576.136ZM876.958 627.094C872.48 622.633 868.251 617.884 863.48 613.762C841.407 594.691 808.866 594.415 786.267 612.678C776.029 620.951 767.594 630.784 760.961 642.039C737.114 682.5 725.908 726.117 731.229 773.014C734.873 805.133 751.343 828.913 781.977 841.631C797.406 848.037 800.989 853.39 800.994 870.439C801.008 923.065 800.997 975.691 801.007 1028.32C801.008 1031.31 800.825 1034.35 801.229 1037.3C803.38 1052.99 820.342 1062.26 834.338 1055.2C843.542 1050.56 847.423 1042.76 847.392 1032.36C847.229 978.405 847.299 924.447 847.33 870.488C847.34 853.965 851.512 847.737 866.541 841.615C892.135 831.188 908.012 812.293 914.978 785.784C920.053 766.472 919.838 746.889 917.014 727.29C911.809 691.177 900.565 657.414 876.958 627.094ZM745.996 981.998C640.036 981.998 534.076 981.999 428.115 981.997C411.455 981.997 394.789 982.25 378.136 981.9C360.835 981.536 346.597 974.288 335.716 960.868C326.732 949.787 323.5 936.803 323.513 922.674C323.598 828.043 323.557 733.412 323.557 638.781C323.557 634.866 323.557 630.951 323.557 627.673C305.609 625.121 288.635 622.708 271.663 620.295C269.798 633.339 270.49 1024.2 272.441 1031.06C293.055 1033.02 771.471 1032.13 778.494 1030.16C778.494 1014.29 778.494 998.459 778.494 981.998C767.889 981.998 757.941 981.998 745.996 981.998ZM1057.55 734.046C1057.55 713.058 1057.55 692.069 1057.55 671.081C1057.54 651.425 1057.76 631.765 1057.43 612.115C1057.25 601.582 1048.81 593.995 1038.63 594.2C1028.67 594.4 1021.15 601.654 1020.5 611.788C1020.33 614.443 1020.45 617.117 1020.45 619.782C1020.45 656.429 1020.47 693.076 1020.41 729.722C1020.41 733.697 1020.36 737.767 1019.54 741.626C1017.39 751.765 1009.75 756.93 998.887 756.096C989.605 755.384 983.31 749.06 982.332 739.238C982.036 736.266 982.151 733.249 982.15 730.253C982.14 693.606 982.145 656.959 982.14 620.313C982.139 617.648 982.276 614.966 982.027 612.322C980.982 601.196 972.541 593.58 962.114 594.217C951.851 594.843 944.743 602.409 944.728 613.559C944.659 663.198 943.931 712.856 945.087 762.47C945.969 800.295 962.852 828.724 999.845 842.785C1009.81 846.574 1015.31 853.981 1015.48 864.912C1015.53 867.91 1015.54 870.908 1015.54 873.906C1015.55 925.212 1015.52 976.517 1015.6 1027.82C1015.6 1032.11 1015.78 1036.54 1016.84 1040.66C1019.44 1050.72 1028.8 1057.64 1038.93 1057.67C1049.09 1057.7 1058.45 1050.81 1061.08 1040.74C1062.16 1036.62 1062.39 1032.19 1062.4 1027.9C1062.48 975.265 1062.44 922.627 1062.46 869.988C1062.47 852.933 1065.85 848.072 1081.75 841.451C1105.73 831.471 1121.26 813.853 1128.82 789.104C1132.46 777.194 1133.36 764.958 1133.35 752.576C1133.29 707.6 1133.33 662.624 1133.32 617.649C1133.32 615.317 1133.44 612.968 1133.19 610.658C1132.26 601.691 1124.97 594.823 1115.91 594.221C1106.9 593.622 1098.6 599.489 1096.69 608.277C1095.92 611.808 1095.89 615.545 1095.89 619.189C1095.83 656.169 1095.87 693.149 1095.84 730.129C1095.83 733.786 1095.86 737.49 1095.32 741.09C1094.04 749.657 1087.67 755.402 1079.16 756.095C1066.22 757.149 1059.55 750.884 1057.55 734.046ZM906.001 943.695C922.963 943.694 939.926 943.84 956.886 943.644C970.09 943.492 976.518 937.046 976.655 923.958C976.819 908.328 976.695 892.695 976.695 877.064C976.695 870.154 976.695 863.244 976.695 856.247C955.773 844.857 941.529 828.068 932.164 806.823C931.007 807.875 930.682 808.051 930.535 808.323C929.747 809.778 928.986 811.246 928.248 812.727C917.123 835.073 900.169 851.365 876.978 860.591C870.499 863.169 868.877 866.71 869.001 873.218C869.394 893.83 869.128 914.455 869.17 935.075C869.175 937.636 869.492 940.196 869.729 943.695C881.544 943.695 892.773 943.695 906.001 943.695ZM882.259 1031.69C919.14 1031.69 956.021 1031.69 993.522 1031.69C993.522 1011.25 993.522 991.829 993.522 972.011C992.022 972.294 990.966 972.21 990.264 972.668C978.954 980.055 966.465 982.24 953.142 982.079C928.164 981.776 903.178 981.972 878.196 982.019C875.34 982.024 872.484 982.404 869.844 982.595C869.844 999.292 869.844 1015.1 869.844 1031.69C873.804 1031.69 877.073 1031.69 882.259 1031.69ZM918.366 605.885C911.396 609.574 904.425 613.264 897.859 616.74C906.059 631.121 914.137 645.288 923.031 660.887C923.031 642.053 923.012 624.851 923.052 607.65C923.058 605.186 922.567 603.728 918.366 605.885Z" fill="white"/>
                </g>
                
                <!-- Pin stick -->
                <rect x="58.5" y="77" width="3" height="26" 
                      fill="${bgColorTo}"/>
                <circle cx="60" cy="103" r="3" 
                        fill="${bgColorTo}"/>
            </svg>
        `;
    };
    
    // Hitung distance dari user location
    const distance = userLocation ? calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude}) : '0.0';
    
    const marker = new google.maps.Marker({
        position: { lat: vendor.latitude, lng: vendor.longitude },
        map,
        title: vendor.nama,
        icon: {
            url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(getSimpleIcon(vendorType, isOpen, vendor.nama, index)),
            scaledSize: new google.maps.Size(80, 110),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(40, 110)
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
                        ${distance} KM
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