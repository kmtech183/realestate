# 🏰 GujaratRealty — Enterprise Real Estate Platform (Laravel 13)

<p align="center">
  <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80" width="100%" alt="GujaratRealty Hero" style="border-radius: 16px;">
</p>

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg?style=flat-square)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%20%7C%208.4-blue.svg?style=flat-square)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-pink.svg?style=flat-square)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38bdf8.svg?style=flat-square)](https://tailwindcss.com)
[![Pest Test Suite](https://img.shields.io/badge/Tests-36%20Passed%20(100%25)-emerald.svg?style=flat-square)](https://pestphp.com)

> **Live Demo:** [https://realestate.mkdigit.in](https://realestate.mkdigit.in)  
> **Repository:** [https://github.com/kmtech183/realestate.git](https://github.com/kmtech183/realestate.git)

---

## 📖 About The Project

**GujaratRealty** is an enterprise-grade real estate listings and lead management application modeled for high-demand property markets (Ahmedabad & Gandhinagar, Gujarat). Built with **Laravel 13**, **Livewire 3**, **Alpine.js**, and **Tailwind CSS**, it delivers sub-millisecond search performance, reactive client-side filtering, multi-image galleries with **Spatie MediaLibrary**, asynchronous lead notifications, and RESTful API endpoints.

---

## ⚡ Key Architectural Highlights

- **🚀 Reactive Property Catalog:** Instant live search debouncing (`wire:model.live.debounce.350ms`), BHK selectors, price range filtering, and URL query syncing without full-page reloads.
- **🖼️ Spatie MediaLibrary:** Multi-image responsive galleries, auto-conversion thumbnails, and WebP generation.
- **🔒 Granular Authorization & RBAC:** Multi-tier roles (`Admin`, `Agent`, `Buyer`) governed by Model Policies (`PropertyPolicy`, `InquiryPolicy`) and Gates.
- **⚡ High-Speed Caching & Observers:** Deterministic MD5 query caching with automated version-based cache purging via `PropertyObserver`.
- **📨 Asynchronous Queue Pipeline:** Background inquiry notifications (`SendInquiryNotification`) ensuring sub-40ms web response times.
- **🌐 RESTful API V1:** Versioned endpoints (`/api/v1/properties`, `/api/v1/categories`, `/api/v1/market-stats`) with cursor pagination and JsonResources.
- **🧪 100% Pest PHP Test Suite:** Comprehensive unit and feature test coverage across authorization, browsing, filtering, and queues.

---

## 🛠️ Tech Stack & Requirements

- **PHP:** 8.3 / 8.4+
- **Framework:** Laravel 13.x
- **Frontend Reactive Stack:** Livewire 3 + Alpine.js + Tailwind CSS + Vite
- **Media Engine:** `spatie/laravel-medialibrary` (v11)
- **Authentication:** Laravel Breeze (Volt / Livewire stack)
- **Testing:** Pest PHP v4 (`pestphp/pest`)
- **Database:** MySQL 8.0+ / MariaDB / SQLite (In-Memory for testing)

---

## 🚀 Local Development Setup

```bash
# 1. Clone the repository
git clone https://github.com/kmtech183/realestate.git
cd realestate

# 2. Install Composer dependencies
composer install

# 3. Environment Configuration
cp .env.example .env
php artisan key:generate

# 4. Create public storage symlink for MediaLibrary
php artisan storage:link

# 5. Run Migrations & Seed Sample Ahmedabad Real Estate Data
php artisan migrate:fresh --seed

# 6. Install Node dependencies & Build Frontend
npm install
npm run build

# 7. Start the local server
php artisan serve
```

---

## 🧪 Running Automated Tests

Run the complete test suite via Pest:
```bash
php artisan test
```

---

## 👥 Demo Credentials

| Role | Email | Password | Access Area |
|---|---|---|---|
| **Super Admin** | `admin@realestate.test` | `password` | `/admin/dashboard` & Full Control |
| **Listing Agent** | `agent@realestate.test` | `password` | `/agent/dashboard` & Property Management |
| **Prospective Buyer** | `buyer@realestate.test` | `password` | `/favorites` & Inquiries |

---

## 📄 License
This project is open-sourced under the [MIT license](LICENSE).

