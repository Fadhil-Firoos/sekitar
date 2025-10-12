<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sekitarmu — Temukan penjual di sekitar</title>
  <meta name="csrf-param" content="_token" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#ED1C24">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  
  <!-- Preload Font Awesome untuk performa lebih baik -->
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" as="style">
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
      margin-left: 0;
      transform: scale(1.2);
      transform-origin: left center;
    }

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

    /* === TOMBOL FILTER DI HEADER === */
    .filter-toggle-btn {
      position: absolute;
      right: 45px; /* UBAH: dari 40px ke 45px */
      top: 50%;
      transform: translateY(-50%);
      background: #ED1C24;
      color: white;
      border: none;
      padding: 8px 12px; /* UBAH: dari width/height ke padding */
      border-radius: 8px; /* UBAH: dari 50% ke 8px */
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px; /* TAMBAH: gap untuk icon dan text */
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 10;
      font-size: 12px; /* TAMBAH */
      font-weight: 600; /* TAMBAH */
    }

    .filter-toggle-btn:hover {
      background: #c0392b;
      transform: translateY(-50%) scale(1.05); /* UBAH: scale dari 1.1 ke 1.05 */
      box-shadow: 0 2px 8px rgba(237, 28, 36, 0.3); /* TAMBAH */
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

    /* === STYLING UNTUK FILTER PANEL === */
    .filter-panel {
      background: white;
      border-top: 1px solid #e9ecef;
      padding: 20px 15px; /* UBAH: dari 15px ke 20px 15px */
      display: none;
      animation: slideDown 0.3s ease-out;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* UBAH: shadow lebih soft */
    }

    .filter-panel.active {
      display: block;
    }

    .filter-section {
      margin-bottom: 20px; /* UBAH: dari 15px ke 20px */
    }

    .filter-label {
      font-size: 14px; /* UBAH: dari 13px ke 14px */
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px; /* UBAH: dari 8px ke 10px */
      display: block;
    }

    /* TAMBAH: Display untuk radius value */
    .radius-display {
      font-size: 24px;
      font-weight: bold;
      color: #ED1C24;
      text-align: center;
      margin-bottom: 8px;
    }

    .radius-slider {
      width: 100%;
      height: 8px; /* UBAH: dari 6px ke 8px */
      border-radius: 5px;
      background: linear-gradient(to right, #ED1C24 0%, #e9ecef 0%); /* TAMBAH: gradient */
      outline: none;
      -webkit-appearance: none;
    }

    .radius-slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 24px; /* UBAH: dari 20px ke 24px */
      height: 24px;
      border-radius: 50%;
      background: white; /* UBAH: dari #ED1C24 ke white */
      border: 3px solid #ED1C24; /* TAMBAH */
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(237, 28, 36, 0.3); /* UBAH: shadow lebih prominent */
    }

    .radius-slider::-moz-range-thumb {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: white;
      border: 3px solid #ED1C24;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(237, 28, 36, 0.3);
    }

    .radius-info {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      color: #7f8c8d;
      margin-top: 8px; /* UBAH: dari 5px ke 8px */
    }

    .category-chips {
      display: flex;
      gap: 10px; /* UBAH: dari 8px ke 10px */
      overflow-x: auto;
      padding-bottom: 8px; /* UBAH: dari 5px ke 8px */
      scrollbar-width: thin; /* TAMBAH */
      scrollbar-color: #e9ecef transparent; /* TAMBAH */
    }

    .category-chips::-webkit-scrollbar {
      height: 4px;
    }

    .category-chips::-webkit-scrollbar-track {
      background: transparent;
    }

    .category-chips::-webkit-scrollbar-thumb {
      background: #e9ecef;
      border-radius: 10px;
    }

    .category-chip {
      padding: 10px 18px; /* UBAH: dari 8px 16px ke 10px 18px */
      border-radius: 20px;
      border: 2px solid #e9ecef;
      background: white;
      font-size: 13px; /* UBAH: dari 12px ke 13px */
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 6px; /* UBAH: dari 5px ke 6px */
    }

    .category-chip.active {
      background: linear-gradient(135deg, #ED1C24, #c0392b); /* UBAH: solid ke gradient */
      color: white;
      border-color: #ED1C24;
      transform: scale(1.05); /* TAMBAH */
      box-shadow: 0 4px 12px rgba(237, 28, 36, 0.3); /* TAMBAH */
    }

    .category-chip:hover {
      border-color: #ED1C24;
      transform: translateY(-2px); /* TAMBAH */
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* TAMBAH */
    }

    .filter-actions {
      display: flex;
      gap: 10px;
      margin-top: 20px; /* UBAH: dari 15px ke 20px */
      padding-top: 20px; /* UBAH: dari 15px ke 20px */
      border-top: 1px solid #e9ecef;
    }

    .filter-btn {
      flex: 1;
      padding: 12px; /* UBAH: dari 10px ke 12px */
      border-radius: 12px; /* UBAH: dari 10px ke 12px */
      font-size: 14px; /* UBAH: dari 13px ke 14px */
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
      background: linear-gradient(135deg, #ED1C24, #c0392b); /* UBAH: solid ke gradient */
      color: white;
      box-shadow: 0 4px 12px rgba(237, 28, 36, 0.3); /* TAMBAH */
    }

    .filter-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15); /* UBAH: shadow lebih prominent */
    }

    .filter-btn.reset:hover {
      border-color: #ED1C24;
      color: #ED1C24;
    }

    /* === STYLING UNTUK QUICK STATS === */
    .quick-stats {
      display: flex;
      gap: 10px; /* UBAH: dari 8px ke 10px */
      padding: 0 15px 15px; /* UBAH: dari 0 15px 12px ke 0 15px 15px */
      font-size: 12px; /* UBAH: dari 11px ke 12px */
      overflow-x: auto; /* TAMBAH */
      scrollbar-width: none; /* TAMBAH */
    }

    .quick-stats::-webkit-scrollbar {
      display: none;
    }

    .stat-badge {
      display: flex;
      align-items: center;
      gap: 6px; /* UBAH: dari 5px ke 6px */
      padding: 8px 16px; /* UBAH: dari 5px 12px ke 8px 16px */
      border-radius: 20px;
      font-weight: 600;
      white-space: nowrap; /* TAMBAH */
      box-shadow: 0 2px 6px rgba(0,0,0,0.06); /* TAMBAH */
      transition: all 0.3s ease; /* TAMBAH */
    }

    .stat-badge:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stat-badge.open {
      background: linear-gradient(135deg, #d4edda, #c3e6cb); /* UBAH: solid ke gradient */
      color: #27ae60;
      border: 1px solid rgba(39, 174, 96, 0.2); /* TAMBAH */
    }

    .stat-badge.closed {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef); /* UBAH: solid ke gradient */
      color: #7f8c8d;
      border: 1px solid rgba(127, 140, 141, 0.2); /* TAMBAH */
    }

    .stat-badge.total {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb); /* UBAH: solid ke gradient */
      color: #2196f3;
      border: 1px solid rgba(33, 150, 243, 0.2); /* TAMBAH */
    }

    .stat-indicator {
      width: 10px; /* UBAH: dari 8px ke 10px */
      height: 10px;
      border-radius: 50%;
      box-shadow: 0 0 0 2px rgba(255,255,255,0.5); /* TAMBAH */
    }

    .stat-indicator.open {
      background: #27ae60;
      animation: pulse-green 2s infinite; /* TAMBAH */
    }

    .stat-indicator.closed {
      background: #7f8c8d;
    }

    /* === STYLING UNTUK MAP LEGEND === */
    .map-legend {
      position: absolute;
      bottom: 80px; /* UBAH: dari 70px ke 80px */
      left: 15px; /* UBAH: dari 10px ke 15px */
      background: rgba(255, 255, 255, 0.95); /* UBAH: tambah transparency */
      backdrop-filter: blur(10px); /* TAMBAH */
      border-radius: 12px; /* UBAH: dari 10px ke 12px */
      padding: 14px; /* UBAH: dari 10px ke 14px */
      box-shadow: 0 4px 16px rgba(0,0,0,0.15); /* UBAH: shadow lebih prominent */
      z-index: 10;
      font-size: 11px;
      max-width: 160px; /* UBAH: dari 150px ke 160px */
      border: 1px solid rgba(0,0,0,0.05); /* TAMBAH */
    }

    .legend-title {
      font-weight: bold;
      margin-bottom: 12px; /* UBAH: dari 8px ke 12px */
      color: #2c3e50;
      display: flex;
      align-items: center;
      gap: 6px; /* UBAH: dari 5px ke 6px */
      font-size: 12px; /* TAMBAH */
      padding-bottom: 8px; /* TAMBAH */
      border-bottom: 1px solid #e9ecef; /* TAMBAH */
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 10px; /* UBAH: dari 8px ke 10px */
      margin-bottom: 8px; /* UBAH: dari 5px ke 8px */
      color: #666; /* TAMBAH */
      font-size: 11px; /* TAMBAH */
    }

    .legend-item:last-child {
      margin-bottom: 0;
    }

    .legend-color {
      width: 16px; /* UBAH: dari 12px ke 16px */
      height: 16px;
      border-radius: 50%;
      flex-shrink: 0; /* TAMBAH */
      border: 2px solid white; /* TAMBAH */
      box-shadow: 0 2px 4px rgba(0,0,0,0.15); /* TAMBAH */
    }

    .legend-color.user {
      background: linear-gradient(135deg, #3498db, #2980b9); /* UBAH: solid ke gradient */
    }

    .legend-color.open {
      background: linear-gradient(135deg, #27ae60, #229954); /* UBAH: solid ke gradient */
    }

    .legend-color.closed {
      background: linear-gradient(135deg, #95a5a6, #7f8c8d); /* UBAH: solid ke gradient */
    }

    /* === STYLING UNTUK FLOATING ACTION BUTTON === */
    .floating-action-btn {
      position: fixed;
      bottom: 90px; /* UBAH: dari 80px ke 90px */
      right: 20px;
      width: 56px; /* UBAH: dari 50px ke 56px */
      height: 56px;
      border-radius: 50%;
      background: linear-gradient(135deg, #3498db, #2980b9); /* UBAH: solid ke gradient */
      color: white;
      border: none;
      box-shadow: 0 4px 20px rgba(52, 152, 219, 0.4); /* UBAH: shadow dengan color */
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .floating-action-btn:hover {
      transform: scale(1.15); /* UBAH: dari 1.1 ke 1.15 */
      box-shadow: 0 6px 25px rgba(52, 152, 219, 0.5); /* UBAH: shadow lebih prominent */
    }

    .floating-action-btn:active {
      transform: scale(1.05);
    }

    .floating-action-btn i {
      font-size: 22px; /* TAMBAH */
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
      border-radius: 16px; /* UBAH: dari 12px ke 16px */
      padding: 16px; /* UBAH: dari 12px ke 16px */
      margin-bottom: 12px; /* UBAH: dari 10px ke 12px */
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* UBAH: easing */
      position: relative;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06); /* UBAH: shadow lebih soft */
      animation: fadeIn 0.3s ease-out; /* TAMBAH */
    }

    .vendor-card:hover {
      transform: translateY(-4px); /* UBAH: dari -2px ke -4px */
      box-shadow: 0 8px 20px rgba(0,0,0,0.12); /* UBAH: shadow lebih prominent */
      border-color: #ED1C24;
    }

    .vendor-card.active {
      background: linear-gradient(135deg, #fff5f5, #ffe5e5); /* UBAH: gradient baru */
      border-color: #ED1C24;
      border-width: 2px; /* TAMBAH */
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(237, 28, 36, 0.2); /* UBAH */
    }

    .vendor-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 12px; /* UBAH: dari 8px ke 12px */
    }

    .vendor-main-info {
      flex: 1;
      margin-right: 12px;
    }

    .vendor-name {
      font-size: 17px; /* UBAH: dari 16px ke 17px */
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 4px; /* UBAH: dari 3px ke 4px */
      line-height: 1.3; /* UBAH: dari 1.2 ke 1.3 */
    }

    .vendor-type {
      font-size: 11px;
      color: #7f8c8d;
      background: #f8f9fa;
      padding: 4px 8px; /* UBAH: dari 2px 6px ke 4px 8px */
      border-radius: 10px; /* UBAH: dari 8px ke 10px */
      display: inline-block;
      margin-bottom: 6px;
    }

    .vendor-status-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      min-width: 75px; /* UBAH: dari 70px ke 75px */
      gap: 4px; /* TAMBAH */
    }

    /* TAMBAH: Badge style untuk status */
    .vendor-status-badge {
      padding: 5px 12px; /* UBAH: style baru */
      border-radius: 12px;
      font-size: 10px;
      font-weight: bold;
      text-align: center;
      white-space: nowrap;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08); /* TAMBAH */
    }

    .vendor-status-badge.open {
      background: linear-gradient(135deg, #d4edda, #c3e6cb);
      color: #27ae60;
      border: 1px solid rgba(39, 174, 96, 0.2);
    }

    .vendor-status-badge.closed {
      background: linear-gradient(135deg, #f8d7da, #f5c6cb);
      color: #e74c3c;
      border: 1px solid rgba(231, 76, 60, 0.2);
    }

    /* GANTI: Hapus .vendor-status yang lama, ganti dengan badge */

    .vendor-distance {
      font-size: 12px; /* UBAH: dari 11px ke 12px */
      color: #ED1C24;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 4px; /* UBAH: dari 3px ke 4px */
      padding: 4px 8px; /* TAMBAH */
      background: rgba(237, 28, 36, 0.05); /* TAMBAH */
      border-radius: 8px; /* TAMBAH */
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

    /* === ANIMASI === */
    @keyframes fadeIn {
      from { 
        opacity: 0;
        transform: translateY(10px);
      }
      to { 
        opacity: 1;
        transform: translateY(0);
      }
    }

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

    @keyframes fadeOut {
      from {
        opacity: 1;
        transform: translateY(0);
      }
      to {
        opacity: 0;
        transform: translateY(-10px);
      }
    }

    @keyframes pulse-green {
      0%, 100% { 
        box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.7);
      }
      50% { 
        box-shadow: 0 0 0 6px rgba(39, 174, 96, 0);
      }
    }

    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
    }

    /* Custom scrollbar untuk category chips dan quick stats */
    .category-chips::-webkit-scrollbar,
    .quick-stats::-webkit-scrollbar {
      height: 4px;
    }

    .category-chips::-webkit-scrollbar-track,
    .quick-stats::-webkit-scrollbar-track {
      background: transparent;
    }

    .category-chips::-webkit-scrollbar-thumb,
    .quick-stats::-webkit-scrollbar-thumb {
      background: #e9ecef;
      border-radius: 10px;
    }

    .category-chips::-webkit-scrollbar-thumb:hover,
    .quick-stats::-webkit-scrollbar-thumb:hover {
      background: #ced4da;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .header {
        padding: 10px 15px;
      }

      .logo-img {
        transform: scale(1);
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

      .filter-toggle-btn {
        right: 35px;
        width: 25px;
        height: 25px;
        font-size: 12px;
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

      .quick-stats {
        flex-wrap: wrap;
        justify-content: center;
      }
      
      .map-legend {
        bottom: 70px; /* UBAH: dari 60px ke 70px */
        left: 10px; /* UBAH: dari 5px ke 10px */
        padding: 10px; /* UBAH: dari 8px ke 10px */
        font-size: 10px;
      }
      
      .legend-title {
        font-size: 11px;
        margin-bottom: 8px;
      }
      
      .legend-color {
        width: 14px;
        height: 14px;
      }
      
      .floating-action-btn {
        bottom: 80px; /* UBAH: dari 70px ke 80px */
        right: 15px;
        width: 50px; /* UBAH: dari 45px ke 50px */
        height: 50px;
      }
      
      .floating-action-btn i {
        font-size: 18px;
      }
      
      .vendor-card {
        padding: 12px;
        border-radius: 12px;
      }
      
      .vendor-name {
        font-size: 15px;
      }
      
      .vendor-distance {
        font-size: 11px;
      }

      .filter-toggle-btn {
        right: 40px; /* UBAH: dari 35px ke 40px */
        padding: 6px 10px; /* UBAH */
        font-size: 11px; /* TAMBAH */
      }
      
      .quick-stats {
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px; /* UBAH: dari 6px ke 8px */
        padding: 0 10px 12px; /* UBAH */
      }
      
      .stat-badge {
        padding: 6px 12px; /* UBAH */
        font-size: 11px; /* UBAH */
      }

      
      @media (max-width: 480px) {
  .filter-panel {
    top: 85px;
    padding: 15px;
  }
  
  .filter-toggle-btn {
    right: 40px;
    padding: 6px 10px;
    font-size: 11px;
  }
  
  .category-chip {
    padding: 8px 12px;
    font-size: 12px;
  }
  
  .radius-display {
    font-size: 20px;
  }
  
  .filter-actions {
    margin-top: 15px;
    padding-top: 15px;
  }
  
  .filter-btn {
    padding: 10px;
    font-size: 13px;
  }
}
    }
  </style>
</head>
<body>
  <!-- Header dengan Login/Register -->
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
        <!-- GANTI: Tombol filter yang ada dengan ini -->
        <button id="filter-toggle" class="filter-toggle-btn">
          <i class="fas fa-filter"></i> <!-- UBAH: dari fa-sliders-h ke fa-filter -->
          Filter
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

  <!-- Filter Panel -->
  <div class="filter-panel" id="filterPanel">
    <div class="filter-section">
      <label class="filter-label">Radius Pencarian</label>
      <!-- TAMBAH: Display radius value -->
      <div class="radius-display">
        <span id="radiusValue">5</span> km
      </div>
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
      <label class="filter-label">Kategori Makanan</label>
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
        <!-- TAMBAH: Kategori baru jika perlu -->
        <button class="category-chip" data-category="bakso">
          🍲 Bakso
        </button>
        <button class="category-chip" data-category="siomay">
          🥟 Siomay
        </button>
      </div>
    </div>

    <div class="filter-actions">
      <button class="filter-btn reset" id="resetFilter">
        <i class="fas fa-redo"></i> Reset
      </button>
      <button class="filter-btn apply" id="applyFilter">
        <i class="fas fa-check"></i> Terapkan
      </button>
    </div>
  </div>

  <!-- Quick Stats -->
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
      <i class="fas fa-store"></i> <!-- UBAH: dari fa-map-marker-alt ke fa-store -->
      <span id="totalCount">0</span> Warung
    </div>
  </div>

  <!-- Map -->
  <div class="map-container">
    <div id="map"></div>
    
    <!-- Map Legend -->
    <div class="map-legend">
      <div class="legend-title">
        <i class="fas fa-layer-group"></i>
        <span>Legenda</span> <!-- TAMBAH: wrap text in span -->
      </div>
      <div class="legend-item">
        <div class="legend-color user"></div>
        <span>Lokasi Anda</span>
      </div>
      <div class="legend-item">
        <div class="legend-color open"></div>
        <span>Warung Buka</span>
      </div>
      <div class="legend-item">
        <div class="legend-color closed"></div>
        <span>Warung Tutup</span>
      </div>
    </div>
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

  <!-- Floating Action Button -->
  <button class="floating-action-btn" id="centerMapBtn">
    <i class="fas fa-crosshairs"></i>
  </button>

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
  // Variabel global
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
  let radiusCircle = null;

  // Slider variables
  let sliders = [];
  let currentSlide = 0;
  let sliderInterval = null;

  // Filter variables
  let currentRadius = 5;
  let currentCategory = 'all';

  // Search debounce
  let searchTimeout;

  // Marker loading queue
  let markerLoadQueue = [];
  let isLoadingMarkers = false;

  // Resize debounce
  let resizeTimeout;

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

    // Search input dengan debounce dan loading indicator
    input.addEventListener('input', function() {
      const query = this.value.toLowerCase().trim();
      
      // Clear timeout untuk debounce
      clearTimeout(searchTimeout);
      
      // Show loading indicator
      const searchIcon = document.querySelector('.search-icon');
      searchIcon.className = 'search-icon fas fa-spinner fa-spin';
      
      searchTimeout = setTimeout(() => {
        if (query === '') {
          filteredVendors = allVendors;
        } else {
          filteredVendors = allVendors.filter(vendor => {
            return vendor.nama.toLowerCase().includes(query) ||
                   (vendor.informasi && vendor.informasi.toLowerCase().includes(query)) ||
                   (vendor.menus && vendor.menus.some(menu => 
                     menu.nama.toLowerCase().includes(query)
                   ));
          });
        }
        
        displayVendors(filteredVendors);
        
        // Restore search icon
        searchIcon.className = 'search-icon fas fa-search';
        
        // Show result notification
        if (query !== '') {
          const resultNotif = document.createElement('div');
          resultNotif.style.cssText = `
            position: fixed;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: #2c3e50;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            z-index: 2000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideDown 0.3s ease-out;
            border: 2px solid #e9ecef;
          `;
          resultNotif.innerHTML = `<i class="fas fa-search"></i> Ditemukan ${filteredVendors.length} hasil`;
          document.body.appendChild(resultNotif);
          
          setTimeout(() => {
            resultNotif.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => resultNotif.remove(), 300);
          }, 2000);
        }
      }, 500); // Debounce 500ms
    });

    // Initialize filter functionality
    initFilter();
    
    // Initialize bottom sheet
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

        // Add radius circle
        updateRadiusCircle();

        loadVendors();
      }, (error) => {
        console.log("Error getting location:", error);
        
        // Show error notification dengan detail
        let errorMessage = '';
        switch(error.code) {
          case error.PERMISSION_DENIED:
            errorMessage = "Akses lokasi ditolak. Aktifkan izin lokasi untuk pengalaman terbaik.";
            break;
          case error.POSITION_UNAVAILABLE:
            errorMessage = "Informasi lokasi tidak tersedia.";
            break;
          case error.TIMEOUT:
            errorMessage = "Permintaan lokasi timeout.";
            break;
          default:
            errorMessage = "Terjadi kesalahan saat mengambil lokasi.";
        }
        
        // Show notification
        const errorNotif = document.createElement('div');
        errorNotif.style.cssText = `
          position: fixed;
          top: 120px;
          left: 50%;
          transform: translateX(-50%);
          background: linear-gradient(135deg, #e74c3c, #c0392b);
          color: white;
          padding: 12px 24px;
          border-radius: 25px;
          font-size: 13px;
          font-weight: 600;
          z-index: 2000;
          box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
          animation: slideDown 0.3s ease-out;
          max-width: 300px;
          text-align: center;
        `;
        errorNotif.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${errorMessage}`;
        document.body.appendChild(errorNotif);
        
        setTimeout(() => {
          errorNotif.style.animation = 'fadeOut 0.3s ease-out';
          setTimeout(() => errorNotif.remove(), 300);
        }, 5000);
        
        loadVendors();
      });
    } else {
      console.log("Geolocation not supported");
      loadVendors();
    }

    // Center map button functionality dengan animasi
    document.getElementById('centerMapBtn').addEventListener('click', () => {
      if (userLocation) {
        // Animasi button
        const btn = document.getElementById('centerMapBtn');
        btn.style.transform = 'scale(0.9)';
        setTimeout(() => {
          btn.style.transform = 'scale(1)';
        }, 150);
        
        // Smooth pan dan zoom
        map.panTo(userLocation);
        
        // Pulse animation untuk user marker
        if (userMarker) {
          userMarker.setAnimation(google.maps.Animation.BOUNCE);
          setTimeout(() => {
            userMarker.setAnimation(null);
          }, 1400);
        }
        
        // Show notification
        const notification = document.createElement('div');
        notification.style.cssText = `
          position: fixed;
          top: 120px;
          left: 50%;
          transform: translateX(-50%);
          background: linear-gradient(135deg, #3498db, #2980b9);
          color: white;
          padding: 10px 20px;
          border-radius: 20px;
          font-size: 13px;
          font-weight: 600;
          z-index: 2000;
          box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
          animation: slideDown 0.3s ease-out;
        `;
        notification.innerHTML = `<i class="fas fa-location-arrow"></i> Kembali ke lokasi Anda`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
          notification.style.animation = 'fadeOut 0.3s ease-out';
          setTimeout(() => notification.remove(), 300);
        }, 2000);
      }
    });
  }

  // Initialize filter functionality
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

    // TAMBAH: Close filter saat klik di luar
    document.addEventListener('click', (e) => {
      if (!filterPanel.contains(e.target) && !filterToggle.contains(e.target)) {
        filterPanel.classList.remove('active');
      }
    });

    // Radius slider dengan gradient update
    radiusSlider.addEventListener('input', (e) => {
      const value = e.target.value;
      radiusValue.textContent = value;
      
      // TAMBAH: Update gradient background
      const percentage = ((value - 0.5) / (5 - 0.5)) * 100;
      e.target.style.background = `linear-gradient(to right, #ED1C24 0%, #ED1C24 ${percentage}%, #e9ecef ${percentage}%, #e9ecef 100%)`;
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
      radiusSlider.style.background = 'linear-gradient(to right, #ED1C24 0%, #ED1C24 100%, #e9ecef 100%, #e9ecef 100%)';
      categoryChips.forEach(c => c.classList.remove('active'));
      categoryChips[0].classList.add('active');
    });

    // Apply filter
    applyBtn.addEventListener('click', () => {
      currentRadius = parseFloat(radiusSlider.value);
      const activeChip = document.querySelector('.category-chip.active');
      currentCategory = activeChip.dataset.category;
      
      filterVendors();
      updateRadiusCircle(); // TAMBAH: Update radius circle
      filterPanel.classList.remove('active');
      
      // TAMBAH: Show notification
      showFilterNotification();
      
      // Track filter usage
      trackEvent('Filter', 'Apply', `Radius: ${currentRadius}km, Category: ${currentCategory}`);
    });
    
    // TAMBAH: Initialize gradient on load
    const initialPercentage = ((radiusSlider.value - 0.5) / (5 - 0.5)) * 100;
    radiusSlider.style.background = `linear-gradient(to right, #ED1C24 0%, #ED1C24 ${initialPercentage}%, #e9ecef ${initialPercentage}%, #e9ecef 100%)`;
  }

  // TAMBAH: Function untuk show filter notification
  function showFilterNotification() {
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 120px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #27ae60, #229954);
      color: white;
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 14px;
      font-weight: 600;
      z-index: 2000;
      box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
      animation: slideDown 0.3s ease-out;
    `;
    notification.innerHTML = `<i class="fas fa-check-circle"></i> Filter diterapkan`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'fadeOut 0.3s ease-out';
      setTimeout(() => notification.remove(), 300);
    }, 2000);
  }

  // Update radius circle on map
  function updateRadiusCircle() {
    if (radiusCircle) {
      radiusCircle.setMap(null);
    }

    if (userLocation && currentRadius > 0) {
      radiusCircle = new google.maps.Circle({
        strokeColor: '#3498db',
        strokeOpacity: 0.5,
        strokeWeight: 2,
        fillColor: '#3498db',
        fillOpacity: 0.15,
        map: map,
        center: userLocation,
        radius: currentRadius * 1000, // Convert km to meters
        clickable: false
      });
    }
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
          'mie': ['mie', 'mi'],
          'snack': ['kue', 'martabak', 'snack', 'gorengan'],
          'minuman': ['minuman', 'es', 'teh', 'kopi', 'jus'],
          'bakso': ['bakso', 'baso'],
          'siomay': ['siomay', 'somay', 'batagor'] // TAMBAH
        };
        
        const keywords = categoryMap[currentCategory] || [];
        const matchCategory = keywords.some(keyword => {
          const vendorInfo = (vendor.informasi || '').toLowerCase();
          const vendorName = vendor.nama.toLowerCase();
          const vendorType = (vendor.jenis || '').toLowerCase();
          
          return vendorInfo.includes(keyword) || 
                 vendorName.includes(keyword) ||
                 vendorType.includes(keyword);
        });
        
        if (!matchCategory) return false;
      }

      return true;
    });

    displayVendors(filtered);
    updateQuickStats(filtered);
  }

  // Update quick stats dengan animasi
  function updateQuickStats(vendors) {
    const openCount = vendors.filter(v => isVendorOpen(v.jam_buka, v.jam_tutup)).length;
    const closedCount = vendors.length - openCount;

    // TAMBAH: Animasi counter
    animateCounter('openCount', openCount);
    animateCounter('closedCount', closedCount);
    animateCounter('totalCount', vendors.length);
  }

  // TAMBAH: Function untuk animasi counter
  function animateCounter(elementId, targetValue) {
    const element = document.getElementById(elementId);
    const currentValue = parseInt(element.textContent) || 0;
    const duration = 500; // ms
    const steps = 20;
    const increment = (targetValue - currentValue) / steps;
    const stepDuration = duration / steps;
    
    let step = 0;
    const timer = setInterval(() => {
      step++;
      const newValue = Math.round(currentValue + (increment * step));
      element.textContent = newValue;
      
      if (step >= steps) {
        element.textContent = targetValue;
        clearInterval(timer);
      }
    }, stepDuration);
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
          updateQuickStats(allVendors);
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
      
      // TAMBAH: Auto retry setelah 5 detik
      setTimeout(() => {
        console.log('Auto retry loading vendors...');
        loadVendors();
      }, 5000);
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
    
    // TAMBAH: Update sheet title dengan animasi
    const sheetTitle = document.getElementById("sheet-title");
    sheetTitle.style.opacity = '0';
    setTimeout(() => {
      sheetTitle.textContent = `${sortedVendors.length} penjual ditemukan`;
      sheetTitle.style.transition = 'opacity 0.3s ease';
      sheetTitle.style.opacity = '1';
    }, 150);

    const locationList = document.getElementById("location-list");
    
    // TAMBAH: Fade out animation
    locationList.style.opacity = '0';
    
    setTimeout(() => {
      locationList.innerHTML = "";

      // Clear existing markers dengan animasi
      locationMarkers.forEach((marker, index) => {
        setTimeout(() => {
          marker.setMap(null);
        }, index * 20);
      });
      locationMarkers = [];

      // TAMBAH: Create vendors dengan stagger animation
      sortedVendors.forEach((vendor, index) => {
        setTimeout(() => {
          createVendorCard(vendor, index);
          createVendorMarker(vendor, index);
        }, index * 50);
      });
      
      // Fade in animation
      setTimeout(() => {
        locationList.style.transition = 'opacity 0.5s ease';
        locationList.style.opacity = '1';
      }, 100);
      
      // TAMBAH: Adjust bottom sheet height
      setTimeout(() => {
        adjustBottomSheetHeight();
      }, 500);
    }, 200);
  }

  function createVendorCard(vendor, index) {
    const card = document.createElement('div');
    card.className = 'vendor-card';
    card.dataset.lat = vendor.latitude;
    card.dataset.lng = vendor.longitude;
    card.onclick = () => selectLocation(card, vendor);
    
    // TAMBAH: Stagger animation
    card.style.animationDelay = `${index * 0.05}s`;

    const distance = userLocation ? calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude}) : '0.0';
    const isOpen = isVendorOpen(vendor.jam_buka, vendor.jam_tutup);

    card.innerHTML = `
      <div class="vendor-header">
        <div class="vendor-main-info">
          <div class="vendor-name">${vendor.nama}</div>
          <div class="vendor-type">${vendor.informasi || 'Penjual keliling'}</div>
        </div>
        <div class="vendor-status-container">
          <!-- UBAH: Ganti status dengan badge -->
          <div class="vendor-status-badge ${isOpen ? 'open' : 'closed'}">
            ${isOpen ? '● Buka' : '● Tutup'}
          </div>
          <div class="vendor-distance">
            <i class="fas fa-map-marker-alt"></i>
            ${distance} km
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
    
    // TAMBAH: Ambil jenis penjual dari database
    const vendorType = (vendor.jenis || vendor.kategori || 'default').toLowerCase();
    
    const getCartIcon = (type, isOpen, vendorName) => {
      const baseColor = isOpen ? '#ED1C24' : '#95a5a6';
      const accentColor = isOpen ? '#c0392b' : '#7f8c8d';
      
      // TAMBAH: Potong nama vendor maksimal 12 karakter
      const displayName = vendorName.length > 12 ? vendorName.substring(0, 10) + '..' : vendorName;
      
      switch(type) {
        case 'bakso':
          return `
            <svg width="80" height="100" viewBox="0 0 80 100" xmlns="http://www.w3.org/2000/svg">
              <!-- TAMBAH: Nama Penjual di Atas -->
              <rect x="10" y="5" width="60" height="20" rx="10" fill="white" stroke="${baseColor}" stroke-width="2" filter="url(#shadow)"/>
              <text x="40" y="17" font-family="Arial, sans-serif" font-size="9" font-weight="bold" fill="${baseColor}" text-anchor="middle">${displayName}</text>
              
              <!-- Shadow -->
              <ellipse cx="40" cy="95" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
              
              <!-- Wheels -->
              <circle cx="20" cy="85" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
              <circle cx="20" cy="85" r="4" fill="#34495e"/>
              <circle cx="20" cy="85" r="2" fill="#7f8c8d"/>
              
              <circle cx="52" cy="85" r="7" fill="#2c3e50" stroke="#1a252f" stroke-width="2"/>
              <circle cx="52" cy="85" r="4" fill="#34495e"/>
              <circle cx="52" cy="85" r="2" fill="#7f8c8d"/>
              
              <!-- Cart Base -->
              <rect x="10" y="65" width="52" height="15" rx="2" fill="${baseColor}" stroke="${accentColor}" stroke-width="2"/>
              <rect x="12" y="67" width="48" height="11" rx="1" fill="rgba(255,255,255,0.1)"/>
              
              <!-- Canopy Frame -->
              <path d="M8 65 Q36 45 64 65" fill="none" stroke="#8B4513" stroke-width="3"/>
              <rect x="7" y="64" width="3" height="5" rx="1" fill="#8B4513"/>
              <rect x="60" y="64" width="3" height="5" rx="1" fill="#8B4513"/>
              
              <!-- Canopy -->
              <defs>
                <pattern id="stripes-${vendor.id}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                  <rect width="4" height="8" fill="${baseColor}"/>
                  <rect x="4" width="4" height="8" fill="${accentColor}"/>
                </pattern>
              </defs>
              <path d="M8 65 Q36 45 64 65 L64 60 Q36 40 8 60 Z" fill="url(#stripes-${vendor.id})" stroke="#8B4513" stroke-width="1"/>
              
              <!-- Glass display -->
              <rect x="12" y="52" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)" stroke="#5d9cad" stroke-width="1.5"/>
              <rect x="14" y="54" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)"/>
              
              <!-- Bowl with meatballs -->
              <ellipse cx="30" cy="58" rx="10" ry="4" fill="#fff" stroke="#ddd" stroke-width="1"/>
              <ellipse cx="30" cy="56" rx="10" ry="4" fill="#f5f5f5" stroke="#ddd" stroke-width="1"/>
              <circle cx="27" cy="55" r="2.5" fill="#8B4513"/>
              <circle cx="33" cy="54.5" r="2.8" fill="#A0522D"/>
              <circle cx="30" cy="56.5" r="2.3" fill="#8B4513"/>
              
              <!-- Steam effect when open -->
              ${isOpen ? `
              <g opacity="0.6">
                <path d="M25 52 Q27 45 29 52" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round">
                  <animate attributeName="d" values="M25 52 Q27 45 29 52;M25 52 Q23 43 21 52;M25 52 Q27 45 29 52" dur="2s" repeatCount="indefinite"/>
                </path>
              </g>` : ''}
              
              <!-- Shadow filter -->
              <defs>
                <filter id="shadow">
                  <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                </filter>
              </defs>
            </svg>
          `;
          
        case 'siomay':
        case 'batagor':
          return `
            <svg width="80" height="100" viewBox="0 0 80 100" xmlns="http://www.w3.org/2000/svg">
              <!-- Nama Penjual -->
              <rect x="10" y="5" width="60" height="20" rx="10" fill="white" stroke="#f39c12" stroke-width="2" filter="url(#shadow)"/>
              <text x="40" y="17" font-family="Arial, sans-serif" font-size="9" font-weight="bold" fill="#f39c12" text-anchor="middle">${displayName}</text>
              
              <!-- Shadow -->
              <ellipse cx="40" cy="95" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
              
              <!-- Wheels -->
              <circle cx="20" cy="85" r="7" fill="#2c3e50"/>
              <circle cx="52" cy="85" r="7" fill="#2c3e50"/>
              
              <!-- Cart Base -->
              <rect x="10" y="65" width="52" height="15" rx="2" fill="${baseColor}"/>
              
              <!-- Canopy -->
              <path d="M8 65 Q36 45 64 65" fill="none" stroke="#8B4513" stroke-width="3"/>
              <path d="M8 65 Q36 45 64 65 L64 60 Q36 40 8 60 Z" fill="url(#stripes-${vendor.id})" stroke="#8B4513" stroke-width="1"/>
              
              <!-- Glass display with steamed food -->
              <rect x="12" y="52" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)"/>
              <rect x="14" y="54" width="42" height="9" rx="1" fill="rgba(255,255,255,0.6)"/>
              
              <!-- Siomay/Batagor pieces -->
              <rect x="18" y="56" width="5" height="4" rx="1" fill="#F4A460"/>
              <rect x="25" y="55" width="5" height="4" rx="1" fill="#DEB887"/>
              <rect x="32" y="56" width="5" height="4" rx="1" fill="#CD853F"/>
              
              <defs>
                <pattern id="stripes-${vendor.id}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                  <rect width="4" height="8" fill="#f39c12"/>
                  <rect x="4" width="4" height="8" fill="#e67e22"/>
                </pattern>
                <filter id="shadow">
                  <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                </filter>
              </defs>
            </svg>
          `;
          
        case 'minuman':
        case 'es':
        case 'kopi':
          return `
            <svg width="80" height="100" viewBox="0 0 80 100" xmlns="http://www.w3.org/2000/svg">
              <!-- Nama Penjual -->
              <rect x="10" y="5" width="60" height="20" rx="10" fill="white" stroke="#3498db" stroke-width="2" filter="url(#shadow)"/>
              <text x="40" y="17" font-family="Arial, sans-serif" font-size="9" font-weight="bold" fill="#3498db" text-anchor="middle">${displayName}</text>
              
              <!-- Shadow -->
              <ellipse cx="40" cy="95" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
              
              <!-- Wheels -->
              <circle cx="20" cy="85" r="7" fill="#2c3e50"/>
              <circle cx="52" cy="85" r="7" fill="#2c3e50"/>
              
              <!-- Cart Base -->
              <rect x="10" y="65" width="52" height="15" rx="2" fill="${baseColor}"/>
              
              <!-- Canopy -->
              <path d="M8 65 Q36 45 64 65" fill="none" stroke="#8B4513" stroke-width="3"/>
              <path d="M8 65 Q36 45 64 65 L64 60 Q36 40 8 60 Z" fill="url(#stripes-${vendor.id})" stroke="#8B4513" stroke-width="1"/>
              
              <!-- Glass display -->
              <rect x="12" y="52" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)"/>
              
              <!-- Drink glass -->
              <path d="M20 58 L20 63 L34 63 L34 58 Z" fill="#87CEEB"/>
              <ellipse cx="27" cy="63" rx="7" ry="1" fill="#4682B4"/>
              
              <!-- Ice cubes -->
              <rect x="23" y="60" width="2" height="2" rx="0.3" fill="rgba(255,255,255,0.8)"/>
              <rect x="29" y="60" width="2" height="2" rx="0.3" fill="rgba(255,255,255,0.8)"/>
              
              <defs>
                <pattern id="stripes-${vendor.id}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                  <rect width="4" height="8" fill="#3498db"/>
                  <rect x="4" width="4" height="8" fill="#2980b9"/>
                </pattern>
                <filter id="shadow">
                  <feDropShadow dx="1" dy="2" stdDeviation="2" flood-color="rgba(0,0,0,0.5)"/>
                </filter>
              </defs>
            </svg>
          `;
          
        default:
          return `
            <svg width="80" height="100" viewBox="0 0 80 100" xmlns="http://www.w3.org/2000/svg">
              <!-- Nama Penjual -->
              <rect x="10" y="5" width="60" height="20" rx="10" fill="white" stroke="${baseColor}" stroke-width="2" filter="url(#shadow)"/>
              <text x="40" y="17" font-family="Arial, sans-serif" font-size="9" font-weight="bold" fill="${baseColor}" text-anchor="middle">${displayName}</text>
              
              <!-- Shadow -->
              <ellipse cx="40" cy="95" rx="32" ry="4" fill="rgba(0,0,0,0.2)"/>
              
              <!-- Wheels -->
              <circle cx="20" cy="85" r="7" fill="#2c3e50"/>
              <circle cx="52" cy="85" r="7" fill="#2c3e50"/>
              
              <!-- Cart Base -->
              <rect x="10" y="65" width="52" height="15" rx="2" fill="${baseColor}"/>
              
              <!-- Canopy -->
              <path d="M8 65 Q36 45 64 65" fill="none" stroke="#8B4513" stroke-width="3"/>
              <path d="M8 65 Q36 45 64 65 L64 60 Q36 40 8 60 Z" fill="url(#stripes-${vendor.id})"/>
              
              <!-- Glass display -->
              <rect x="12" y="52" width="46" height="13" rx="2" fill="rgba(173, 216, 230, 0.4)"/>
              
              <defs>
                <pattern id="stripes-${vendor.id}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
                  <rect width="4" height="8" fill="${baseColor}"/>
                  <rect x="4" width="4" height="8" fill="${accentColor}"/>
                </pattern>
                <filter id="shadow">
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
        scaledSize: new google.maps.Size(80, 100), // UBAH: size lebih besar
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(40, 100) // UBAH: anchor point
      },
      animation: google.maps.Animation.DROP // TAMBAH: animasi drop
    });

    // TAMBAH: Animasi bounce saat hover (untuk desktop)
    marker.addListener('mouseover', () => {
      if (window.innerWidth > 768) {
        marker.setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(() => marker.setAnimation(null), 700);
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
            <span style="font-size: 10px; padding: 4px 10px; border-radius: 12px; font-weight: bold; 
                         background: ${isOpen ? 'linear-gradient(135deg, #d4edda, #c3e6cb)' : 'linear-gradient(135deg, #f8d7da, #f5c6cb)'};
                         color: ${isOpen ? '#27ae60' : '#e74c3c'};">
              ${isOpen ? '● BUKA' : '● TUTUP'}
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
              ${userLocation ? calculateDistance(userLocation, {lat: vendor.latitude, lng: vendor.longitude}) : '0.0'} km
            </div>
          </div>

          <div style="display: flex; gap: 6px;">
            <button onclick="openDetailPage(${vendor.id})" 
                   style="flex: 1; background: linear-gradient(135deg, #3498db, #2980b9); color: white; border: none; padding: 8px 12px; 
                          border-radius: 15px; font-size: 11px; font-weight: bold; cursor: pointer;
                          transition: all 0.3s ease; box-shadow: 0 2px 6px rgba(52, 152, 219, 0.3);" 
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(52, 152, 219, 0.4)'" 
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(52, 152, 219, 0.3)'">
              <i class="fas fa-utensils" style="margin-right: 4px;"></i>
              Lihat Menu
            </button>
            <a href="https://wa.me/${vendor.whatsapp}" target="_blank" 
               style="background: linear-gradient(135deg, #25d366, #128c7e); color: white; border: none; padding: 8px 12px; 
                      border-radius: 15px; text-decoration: none; font-size: 11px; 
                      font-weight: bold; transition: all 0.3s ease; display: flex; align-items: center; gap: 4px;
                      box-shadow: 0 2px 6px rgba(37, 211, 102, 0.3);" 
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(37, 211, 102, 0.4)'" 
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(37, 211, 102, 0.3)'">
              <i class="fab fa-whatsapp"></i>
              Chat
            </a>
          </div>
        </div>
      `);
      infoWindow.open(map, marker);
      
      // TAMBAH: Scroll to vendor card
      const cards = document.querySelectorAll('.vendor-card');
      if (cards[index]) {
        cards[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        cards[index].classList.add('active');
        setTimeout(() => cards[index].classList.remove('active'), 3000);
      }
    });

    locationMarkers.push(marker);
  }

  function selectLocation(card, vendor) {
    // Track vendor selection
    trackEvent('Vendor', 'Select', vendor.nama);
    
    const lat = parseFloat(card.dataset.lat);
    const lng = parseFloat(card.dataset.lng);
    
    // TAMBAH: Smooth pan ke lokasi
    map.panTo({ lat, lng });
    
    // TAMBAH: Zoom dengan animasi
    const currentZoom = map.getZoom();
    if (currentZoom < 17) {
      let targetZoom = 17;
      const zoomInterval = setInterval(() => {
        const zoom = map.getZoom();
        if (zoom < targetZoom) {
          map.setZoom(zoom + 1);
        } else {
          clearInterval(zoomInterval);
        }
      }, 100);
    }
    
    // Remove active dari semua cards
    document.querySelectorAll('.vendor-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    
    // Trigger marker click dengan delay untuk animasi smooth
    const cardIndex = Array.from(document.querySelectorAll('.vendor-card')).indexOf(card);
    if (locationMarkers[cardIndex]) {
      setTimeout(() => {
        google.maps.event.trigger(locationMarkers[cardIndex], 'click');
      }, 300);
    }
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

  // TAMBAH: Function untuk auto adjust bottom sheet height
  function adjustBottomSheetHeight() {
    const vendorCount = document.querySelectorAll('.vendor-card').length;
    
    if (vendorCount === 0) {
      bottomSheet.style.height = '200px';
    } else if (vendorCount <= 2) {
      bottomSheet.style.height = '35vh';
    } else {
      bottomSheet.style.height = '50vh';
    }
  }

  // TAMBAH: Swipe gesture untuk close filter panel
  let touchStartY = 0;
  let touchEndY = 0;

  document.getElementById('filterPanel').addEventListener('touchstart', (e) => {
    touchStartY = e.changedTouches[0].screenY;
  }, { passive: true });

  document.getElementById('filterPanel').addEventListener('touchend', (e) => {
    touchEndY = e.changedTouches[0].screenY;
    handleSwipe();
  });

  function handleSwipe() {
    const swipeDistance = touchStartY - touchEndY;
    
    // Swipe up to close (minimal 50px)
    if (swipeDistance > 50) {
      document.getElementById('filterPanel').classList.remove('active');
    }
  }

  // TAMBAH: Track user interactions
  function trackEvent(category, action, label) {
    // Uncomment jika menggunakan Google Analytics
    // if (typeof gtag !== 'undefined') {
    //   gtag('event', action, {
    //     'event_category': category,
    //     'event_label': label
    //   });
    // }
    
    console.log(`Track: ${category} - ${action} - ${label}`);
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

    // TAMBAH: Keyboard shortcuts
    document.addEventListener('keydown', function(event) {
      // ESC untuk close
      if (event.key === 'Escape') {
        const filterPanel = document.getElementById('filterPanel');
        const lightbox = document.getElementById('lightbox');
        const menuDetailPage = document.getElementById('menuDetailPage');
        const detailPage = document.getElementById('detailPage');
        const deliveryModal = document.getElementById('deliveryModal');
        
        if (lightbox.style.display === 'block') {
          hideLightbox();
        } else if (menuDetailPage.style.display === 'block') {
          closeMenuDetailPage();
        } else if (detailPage.style.display === 'block') {
          closeDetailPage();
        } else if (deliveryModal.style.display === 'flex') {
          closeDeliveryModal();
        } else if (filterPanel.classList.contains('active')) {
          filterPanel.classList.remove('active');
        }
      }
      
      // F untuk focus search (hanya jika tidak ada modal terbuka)
      if (event.key === 'f' && event.ctrlKey) {
        event.preventDefault();
        document.getElementById('search-input').focus();
      }
      
      // C untuk center map
      if (event.key === 'c' && event.ctrlKey) {
        event.preventDefault();
        document.getElementById('centerMapBtn').click();
      }
    });
  });

  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      if (map) {
        google.maps.event.trigger(map, 'resize');
        if (userLocation) {
          map.setCenter(userLocation);
        }
      }
      adjustBottomSheetHeight();
    }, 250);
  });

  window.addEventListener('load', () => {
    setTimeout(() => {
      if (map) {
        google.maps.event.trigger(map, 'resize');
      }
    }, 100);

    // TAMBAH: Performance monitoring
    if (performance && performance.timing) {
      const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
      console.log(`%cPage Load Time: ${loadTime}ms`, 'color: #f39c12; font-size: 12px;');
    }
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

  // TAMBAH: Online/Offline detection
  window.addEventListener('online', () => {
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 120px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #27ae60, #229954);
      color: white;
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 14px;
      font-weight: 600;
      z-index: 2000;
      box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
      animation: slideDown 0.3s ease-out;
    `;
    notification.innerHTML = `<i class="fas fa-wifi"></i> Koneksi kembali normal`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'fadeOut 0.3s ease-out';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
    
    // Reload vendors
    loadVendors();
  });

  window.addEventListener('offline', () => {
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 120px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      color: white;
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 14px;
      font-weight: 600;
      z-index: 2000;
      box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
      animation: slideDown 0.3s ease-out;
    `;
    notification.innerHTML = `<i class="fas fa-wifi-slash"></i> Koneksi internet terputus`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'fadeOut 0.3s ease-out';
      setTimeout(() => notification.remove(), 300);
    }, 5000);
  });

  // TAMBAH: Debug info
  console.log('%c🗺️ Sekitarmu Map Initialized', 'color: #ED1C24; font-size: 16px; font-weight: bold;');
  console.log('%cVersion: 2.0', 'color: #3498db; font-size: 12px;');
  console.log('%cFeatures: Filter, Radius Circle, Animations, Smooth Scroll', 'color: #27ae60; font-size: 12px;');

  // TAMBAH: Register service worker (jika ingin PWA)
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      // Uncomment jika sudah buat service-worker.js
      // navigator.serviceWorker.register('/service-worker.js')
      //   .then(registration => console.log('SW registered:', registration))
      //   .catch(error => console.log('SW registration failed:', error));
    });
  }
</script>

<!-- Google Maps API Hampir fiks ini -->
<script async
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAulkhTQ36NXoZ7_SMNRv1nv2hz6jmrZxc&libraries=places&callback=initMap">
</script>
</body>
</html>