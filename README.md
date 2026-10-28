# Certified Drug Test Center (CDTC)

Professional, HIPAA-compliant drug and alcohol testing platform built on Laravel with **Option 2 ("Corporate Clean Trust & Speed")** design, **PayTrace payment gateway**, **Super Admin CMS & Page Builder**, and **100% SEO-optimized PSEO architecture**.

---

## 🔑 Super Admin Credentials
- **Admin Login URL:** `http://127.0.0.1:8000/admin/login`
- **Super Admin Email:** `admin@certifieddrugtesting.com`
- **Super Admin Password:** `Admin@CDTC2026!`

---

## 🚀 Live Frontend URLs (Option 2 Design)
- **Homepage:** `http://127.0.0.1:8000/` (Default primary design: Option 2)
- **Product Detail:** `http://127.0.0.1:8000/product/5-panel-nondot`
- **Category Hub:** `http://127.0.0.1:8000/category/urine`
- **CMS Dynamic Page:** `http://127.0.0.1:8000/about-us`
- **PSEO State Directory:** `http://127.0.0.1:8000/locations`
- **PSEO State Hub:** `http://127.0.0.1:8000/locations/florida`
- **PSEO City Landing:** `http://127.0.0.1:8000/locations/florida/orlando`
- **Express Checkout:** `http://127.0.0.1:8000/checkout`
- **Automated XML Sitemap:** `http://127.0.0.1:8000/sitemap.xml`

---

## 📦 Deployment & Database Migration Pipeline

### Option A: One-Command Live Setup (Zero-dependency)
Runs migrations and loads pre-packaged JSON fixtures for instant setup:
```bash
php artisan migrate:fresh --seed
```
This sets up in ~1.7 seconds:
- Super Admin user
- 15 Product Categories
- 123 Products with pricing & panel breakdowns
- 399 CMS Pages
- 51 States & Major Cities
- Default PayTrace & Brand settings

### Option B: Sync Data from Local ADT Database (`accrediteddrugte_s2`)
If you make new changes to the local ADT database and want to re-import everything:
```bash
php artisan cdtc:import-adt
```
This reads directly from `accrediteddrugte_s2`, transfers all products, pages, states, and 7,382 Quest/Labcorp locations into `cdtc`, and regenerates the JSON fixtures in `database/seeders/data/`.

---

## 💳 PayTrace Payment Gateway Integration
Manage credentials directly in Super Admin under **Settings & PayTrace**:
- `PAYTRACE_USERNAME`
- `PAYTRACE_PASSWORD` (stored encrypted in MySQL using AES-256)
- `PAYTRACE_INTEGRATOR_ID`
- `PAYTRACE_TEST_MODE` (`1` for Sandbox with simulated approvals, `0` for Live production)

When donors register and pay online, an **Electronic Donor Pass** with a unique barcode and assigned Quest / Labcorp facility instructions is generated immediately.

---

## 🧩 Super Admin Features
1. **Product Catalog Management:** Add/edit products, specimen types (Urine, Hair, Alcohol, Saliva, Blood, DNA), DOT flags, turnaround times, and pricing.
2. **CMS & Visual Page Builder:**
   - **Rich Text & Photo Toolbar:** Easily bold, format headings H2/H3, bullet points, links, and click **📷 Upload & Insert Photo** to upload images directly to the server.
   - **Visual Modular Block Builder:** Hero sections, FAQ accordions, test showcases, and CTA callouts.
   - **100% SEO Inspector:** Live Google SERP desktop snippet preview with title and description character counters.
3. **PSEO Location Network:** 7,382 physical collection sites across 3,164 cities with real-time ZIP lookup API (`/api/locations/search?zip=...`).