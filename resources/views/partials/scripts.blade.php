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
    }
  </style>
</head>
<body>
  <!-- Header dengan Login/Register -->
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

  <!-- Footer dengan CS dan Copyright -->
  <div class="footer">
    <div class="footer-left">
      <div class="cs-info">
        <i class="fab fa-whatsapp"></i>
        <span>CS: +62 812 3456 7890</span>
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
    
    let cartType = 'default';
    const vendorName = vendor.nama.toLowerCase();
    
    if (vendorName.includes('bakso')) {
      cartType = 'bakso';
    } else if (vendorName.includes('siomay')) {
      cartType = 'siomay';
    } else if (vendorName.includes('es') || vendorName.includes('minuman')) {
      cartType = 'beverage';
    }

    const getCartIcon = (type, isOpen) => {
      const baseColor = isOpen ? '#ED1C24' : '#95a5a6';
      const accentColor = isOpen ? '#c0392b' : '#7f8c8d';
      
      switch(type) {
        case 'bakso':
          return `
            <svg width="65" height="70" viewBox="0 0 65 70" xmlns="http://www.w3.org/2000/svg">
              <ellipse cx="32" cy="67" rx="25" ry="3" fill="rgba(0,0,0,0.15)"/>
              <rect x="8" y="45" width="35" height="14" rx="2" fill="${baseColor}" stroke="white" stroke-width="1.5"/>
              <rect x="10" y="47" width="31" height="10" rx="1" fill="rgba(255,255,255,0.2)"/>
              <path d="M5 45 Q32 30 50 45 L47 42 Q32 27 10 42 Z" fill="${accentColor}" stroke="white" stroke-width="1.5"/>
              <line x1="12" y1="42" x2="12" y2="45" stroke="#666" stroke-width="2"/>
              <line x1="43" y1="42" x2="43" y2="45" stroke="#666" stroke-width="2"/>
              <circle cx="16" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="39" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="16" cy="59" r="2.5" fill="#666"/>
              <circle cx="39" cy="59" r="2.5" fill="#666"/>
              <ellipse cx="27" cy="40" rx="8" ry="3" fill="white" stroke="#ddd"/>
              <ellipse cx="27" cy="38" rx="8" ry="3" fill="#f8f9fa" stroke="#ddd"/>
              <circle cx="24" cy="37" r="2" fill="#8B4513"/>
              <circle cx="30" cy="36" r="2.2" fill="#A0522D"/>
              <circle cx="27" cy="39" r="1.8" fill="#8B4513"/>
              ${isOpen ? `
              <g opacity="0.7">
                <path d="M20 35 Q22 28 24 35" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" fill="none">
                  <animate attributeName="d" values="M20 35 Q22 28 24 35;M20 35 Q18 26 16 35;M20 35 Q22 28 24 35" dur="2s" repeatCount="indefinite"/>
                </path>
                <path d="M30 34 Q32 27 34 34" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" fill="none">
                  <animate attributeName="d" values="M30 34 Q32 27 34 34;M30 34 Q28 25 26 34;M30 34 Q32 27 34 34" dur="2.3s" repeatCount="indefinite"/>
                </path>
              </g>` : ''}
              <circle cx="50" cy="25" r="4" fill="#FDBCB4" stroke="white" stroke-width="1"/>
              <ellipse cx="50" cy="23" rx="5" ry="2" fill="#2c3e50"/>
              <rect x="46" y="29" width="8" height="14" rx="1" fill="#FF6B35"/>
              <rect x="42" y="32" width="3" height="8" rx="1.5" fill="#FDBCB4"/>
              <rect x="54" y="32" width="3" height="6" rx="1.5" fill="#FDBCB4"/>
              <ellipse cx="48" cy="43" rx="2" ry="1" fill="#333"/>
              <ellipse cx="52" cy="43" rx="2" ry="1" fill="#333"/>
            </svg>
          `;
          
        case 'siomay':
          return `
            <svg width="65" height="70" viewBox="0 0 65 70" xmlns="http://www.w3.org/2000/svg">
              <ellipse cx="32" cy="67" rx="25" ry="3" fill="rgba(0,0,0,0.15)"/>
              <rect x="8" y="45" width="35" height="14" rx="2" fill="${baseColor}" stroke="white" stroke-width="1.5"/>
              <rect x="10" y="47" width="31" height="10" rx="1" fill="rgba(255,255,255,0.2)"/>
              <path d="M5 45 Q32 30 50 45 L47 42 Q32 27 10 42 Z" fill="${accentColor}" stroke="white" stroke-width="1.5"/>
              <line x1="12" y1="42" x2="12" y2="45" stroke="#666" stroke-width="2"/>
              <line x1="43" y1="42" x2="43" y2="45" stroke="#666" stroke-width="2"/>
              <circle cx="16" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="39" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="16" cy="59" r="2.5" fill="#666"/>
              <circle cx="39" cy="59" r="2.5" fill="#666"/>
              <rect x="20" y="38" width="14" height="8" rx="2" fill="#DEB887" stroke="#CD853F" stroke-width="1"/>
              <line x1="22" y1="40" x2="32" y2="40" stroke="#CD853F"/>
              <line x1="22" y1="42" x2="32" y2="42" stroke="#CD853F"/>
              <line x1="22" y1="44" x2="32" y2="44" stroke="#CD853F"/>
              <ellipse cx="24" cy="39" rx="1.5" ry="1" fill="#F5DEB3"/>
              <ellipse cx="27" cy="39" rx="1.5" ry="1" fill="#F5DEB3"/>
              <ellipse cx="30" cy="39" rx="1.5" ry="1" fill="#F5DEB3"/>
              <ellipse cx="25" cy="41" rx="1.5" ry="1" fill="#F5DEB3"/>
              <ellipse cx="28" cy="41" rx="1.5" ry="1" fill="#F5DEB3"/>
              ${isOpen ? `
              <g opacity="0.7">
                <path d="M22 36 Q24 29 26 36" stroke="rgba(255,255,255,0.8)" stroke-width="1.5" fill="none">
                  <animate attributeName="d" values="M22 36 Q24 29 26 36;M22 36 Q20 27 18 36;M22 36 Q24 29 26 36" dur="2s" repeatCount="indefinite"/>
                </path>
              </g>` : ''}
              <circle cx="50" cy="25" r="4" fill="#FDBCB4" stroke="white" stroke-width="1"/>
              <ellipse cx="50" cy="23" rx="5" ry="2" fill="#2c3e50"/>
              <rect x="46" y="29" width="8" height="14" rx="1" fill="#4CAF50"/>
              <rect x="42" y="32" width="3" height="8" rx="1.5" fill="#FDBCB4"/>
              <rect x="54" y="32" width="3" height="6" rx="1.5" fill="#FDBCB4"/>
              <ellipse cx="48" cy="43" rx="2" ry="1" fill="#333"/>
              <ellipse cx="52" cy="43" rx="2" ry="1" fill="#333"/>
            </svg>
          `;
          
        default:
          return `
            <svg width="65" height="70" viewBox="0 0 65 70" xmlns="http://www.w3.org/2000/svg">
              <ellipse cx="32" cy="67" rx="25" ry="3" fill="rgba(0,0,0,0.15)"/>
              <rect x="8" y="45" width="35" height="14" rx="2" fill="${baseColor}" stroke="white" stroke-width="1.5"/>
              <rect x="10" y="47" width="31" height="10" rx="1" fill="rgba(255,255,255,0.2)"/>
              <path d="M5 45 Q32 30 50 45 L47 42 Q32 27 10 42 Z" fill="${accentColor}" stroke="white" stroke-width="1.5"/>
              <line x1="12" y1="42" x2="12" y2="45" stroke="#666" stroke-width="2"/>
              <line x1="43" y1="42" x2="43" y2="45" stroke="#666" stroke-width="2"/>
              <circle cx="16" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="39" cy="59" r="5" fill="#333" stroke="white" stroke-width="1.5"/>
              <circle cx="16" cy="59" r="2.5" fill="#666"/>
              <circle cx="39" cy="59" r="2.5" fill="#666"/>
              <rect x="15" y="40" width="4" height="3" rx="1" fill="#F4A460"/>
              <rect x="22" y="39" width="4" height="3" rx="1" fill="#DEB887"/>
              <rect x="29" y="40" width="4" height="3" rx="1" fill="#CD853F"/>
              <circle cx="50" cy="25" r="4" fill="#FDBCB4" stroke="white" stroke-width="1"/>
              <ellipse cx="50" cy="23" rx="5" ry="2" fill="#2c3e50"/>
              <rect x="46" y="29" width="8" height="14" rx="1" fill="#FF9800"/>
              <rect x="42" y="32" width="3" height="8" rx="1.5" fill="#FDBCB4"/>
              <rect x="54" y="32" width="3" height="6" rx="1.5" fill="#FDBCB4"/>
              <ellipse cx="48" cy="43" rx="2" ry="1" fill="#333"/>
              <ellipse cx="52" cy="43" rx="2" ry="1" fill="#333"/>
            </svg>
          `;
      }
    };
    
    const marker = new google.maps.Marker({
      position: { lat: vendor.latitude, lng: vendor.longitude },
      map,
      title: vendor.nama,
      icon: {
        url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(getCartIcon(cartType, isOpen)),
        scaledSize: new google.maps.Size(52, 56),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(26, 56)
      }
    });

    marker.addListener('click', () => {
      marker.setAnimation(google.maps.Animation.BOUNCE);
      setTimeout(() => {
        marker.setAnimation(null);
      }, 2000);

      infoWindow.setContent(`
        <div style="padding: 15px; max-width: 280px; font-family: 'Segoe UI', sans-serif;">
          <div style="display: flex; align-items: center; margin-bottom: 12px;">
            <div style="width: 8px; height: 8px; background: ${isOpen ? '#27ae60' : '#ED1C24'}; border-radius: 50%; margin-right: 8px;"></div>
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