# 🛒 Sembako Mart - Integrated Laravel Project

Sembako Mart adalah aplikasi berbasis web sistem manajemen toko kelontong (Inventory & Sales Management System) yang dikembangkan menggunakan **Laravel**. Proyek ini dirancang untuk memenuhi seluruh persyaratan teknis, alur bisnis, serta integritas data tingkat lanjut untuk Ujian Tengah Semester (UTS) Web Programming 2.

---

## 📌 1. Project Overview
Aplikasi ini memfasilitasi pengelolaan inventaris toko sembako secara terintegrasi, mulai dari pencatatan data master (kategori, produk, supplier), pengelolaan transaksi masuk (*purchase*), transaksi keluar (*sales*), hingga pemantauan statistik real-time melalui dashboard interaktif dengan sistem keamanan berbasis *role* (Admin & Staff).

---

## ⚙️ 2. Requirements & Tech Stack
- **Framework:** Laravel (PHP)
- **Database:** MySQL / MariaDB
- **Frontend:** Blade Templates, Tailwind CSS
- **Authentication & Authorization:** Laravel Breeze / Custom Middleware (Admin & Staff)
- **Database Transactions:** Atomic operations using `DB::transaction`

---

## 🗄️ 3. Struktur Database (ERD & Schema)
Aplikasi ini menggunakan database relasional MySQL dengan struktur tabel minimal sebagai berikut:

- **`users`**: id (PK), name, email (unique), password, role
- **`categories`**: id (PK), name (unique)
- **`products`**: id (PK), category_id (FK), sku (unique), name, purchase_price, selling_price, stock, minimum_stock
- **`purchases`**: id (PK), supplier_id (FK), user_id (FK), purchase_number (unique), total, status, purchased_at
- **`purchase_items`**: id (PK), purchase_id (FK), product_id (FK), quantity, unit_cost, subtotal
- **`sales`**: id (PK), user_id (FK), sale_number (unique), total, status, sold_at
- **`sale_items`**: id (PK), sale_id (FK), product_id (FK), quantity, unit_price, subtotal

---

## 🚀 4. Installation Guide (Langkah-langkah Instalasi)
Ikuti langkah berikut untuk menjalankan proyek ini di lingkungan lokal (*clean environment*):

1. **Clone Repository**
   ```bash
   git clone https://github.com/ranitanjung163-alt/sembako-mart.git
   cd sembako-martart
