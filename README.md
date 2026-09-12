<p align="center">
  <img src="https://img.shields.io/badge/Laravel-v13-red?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.5-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/Midtrans-Payment%20Gateway-green?style=for-the-badge" />
  <img src="https://img.shields.io/badge/Tailwind%20CSS-CDN-38bdf8?style=for-the-badge&logo=tailwindcss" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479a1?style=for-the-badge&logo=mysql" />
</p>

<h1 align="center">🌸 Fleure Flower</h1>
<p align="center"><strong>Toko Bunga Premium — Laravel + Midtrans</strong></p>
<p align="center">Website katalog dan toko bunga premium dengan sistem pembayaran Midtrans, panel admin lengkap, keranjang belanja, dan desain editorial minimalis.</p>

---

## ✨ Fitur Utama

| Fitur | Status |
|---|---|
| 🏠 Halaman Beranda dengan Hero Section | ✅ |
| 🌸 Katalog Koleksi + Filter Kategori | ✅ |
| 🛒 Keranjang Belanja (Session-based) | ✅ |
| 💳 Checkout + Payment via Midtrans Snap | ✅ |
| 🔔 Webhook Midtrans (auto-update status) | ✅ |
| 🗺️ Kontak & Google Maps embed | ✅ |
| 🛠️ Panel Admin — Dashboard, Produk, Pesanan | ✅ |
| 📦 Upload Foto Produk (storage:link) | ✅ |
| 📱 Responsif — Mobile, Tablet, Desktop | ✅ |

---

## 🎨 Design System

- **Font**: Playfair Display (heading) + Montserrat (body)
- **Warna Utama**: `#1d2e24` (dark green) · `#F4F1EA` (cream) · `#2a4334`
- **Style**: Editorial, minimalis, premium
- **Icons**: [Phosphor Icons](https://phosphoricons.com/)
- **CSS**: [Tailwind CSS CDN](https://tailwindcss.com/)
- **Bahasa**: Indonesia

---

## 🚀 Instalasi Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- Node.js (opsional untuk dev)

### Langkah-langkah

```bash
# 1. Clone repository
git clone https://github.com/PranataGM/Fleure-Flower.git
cd Fleure-Flower

# 2. Install dependencies
composer install

# 3. Buat file .env
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Edit .env sesuai konfigurasi lokal
# DB_DATABASE=fleure_flower
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Buat database di MySQL, lalu jalankan migration
php artisan migrate

# 7. Seed data awal (admin + settings)
php artisan db:seed

# 8. Buat symlink storage
php artisan storage:link

# 9. Jalankan server
php artisan serve
```

---

## 💳 Konfigurasi Midtrans

Daftarkan akun di [dashboard.sandbox.midtrans.com](https://dashboard.sandbox.midtrans.com), lalu tambahkan ke `.env`:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/snap.js
```

**Webhook URL** (daftarkan di dashboard Midtrans):
```
http://localhost/midtrans/callback
```

---

## 🔐 Akses Admin

| URL | Keterangan |
|---|---|
| `/admin` | Dashboard admin |
| `/admin/login` | Login admin |

**Kredensial default:**
- Username: `admin`
- Password: `admin123`

> ⚠️ **Ubah password setelah pertama kali login!**

---

## 🗃️ Struktur Database

```
admins          — akun admin
products        — data produk (buket, fresh_flower, amplop)
orders          — pesanan pelanggan
order_items     — detail item per pesanan
settings        — pengaturan toko (WhatsApp, Instagram, Alamat)
```

---

## 📁 Struktur Folder Utama

```
app/
├── Http/Controllers/
│   ├── Admin/          — AuthController, DashboardController, dll
│   ├── CartController.php
│   ├── CheckoutController.php
│   ├── HomeController.php
│   └── KoleksiController.php
├── Http/Middleware/
│   └── AdminAuthenticated.php
└── Models/
    ├── Admin.php
    ├── Order.php / OrderItem.php
    ├── Product.php
    └── Setting.php

resources/views/
├── layouts/app.blade.php   — Layout publik
├── home.blade.php
├── koleksi.blade.php
├── cart.blade.php
├── checkout.blade.php
├── payment.blade.php
├── order-success.blade.php
└── admin/
    ├── layouts/app.blade.php
    ├── login.blade.php
    ├── dashboard.blade.php
    ├── products/ (index, create, edit)
    ├── orders/ (index, show)
    └── settings.blade.php

routes/web.php      — Semua route publik & admin
config/midtrans.php — Konfigurasi Midtrans
```

---

## 🔄 Alur Pembelian

```
Koleksi → Tambah ke Keranjang → Checkout (isi data) → Halaman Payment → Midtrans Snap → Sukses
```

---

## 📌 Issues & Roadmap

Lihat semua rencana pengembangan di tab [Issues](https://github.com/PranataGM/Fleure-Flower/issues).

---

## 🤝 Kontribusi

1. Fork repository
2. Buat branch baru: `git checkout -b feature/nama-fitur`
3. Commit: `git commit -m "feat: tambah fitur xyz"`
4. Push: `git push origin feature/nama-fitur`
5. Buat Pull Request ke branch `main`

---

<p align="center">Made with ❤️ for <strong>Fleure Flower</strong></p>
