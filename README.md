# 🛒 Sembako Mart - Integrated Laravel Project

Sembako Mart adalah aplikasi berbasis web sistem manajemen toko kelontong (Inventory & Sales Management System) yang dikembangkan menggunakan **Laravel**. Proyek ini dirancang untuk memenuhi seluruh persyaratan teknis, alur bisnis, serta integritas data tingkat lanjut untuk Ujian Tengah Semester (UTS) Web Programming 2.

---

## 📌 1. Project Overview
Aplikasi ini memfasilitasi pengelolaan inventaris toko sembako secara terintegrasi, mulai dari pencatatan data master (kategori, produk, supplier), pengelolaan transaksi masuk (*purchase*), transaksi keluar (*sales*), hingga pemantauan statistik real-time melalui dashboard interaktif dengan sistem keamanan berbasis *role* (Admin & Staff).

---

## ⚙️ 2. Requirements & Tech Stack
* **Framework:** Laravel (PHP)
* **Database:** MySQL / MariaDB
* **Frontend:** Blade Templates, Tailwind CSS
* **Authentication & Authorization:** Laravel Breeze / Custom Middleware (Admin & Staff)
* **Database Transactions:** Atomic operations using `DB::transaction`

---

## 🚀 3. Installation Guide (Langkah-langkah Instalasi)
Ikuti langkah berikut untuk menjalankan proyek ini di lingkungan lokal (*clean environment*):

1. **Clone Repository**
   ```bash
   git clone [https://github.com/ranitanjung163-alt/sembako-mart.git](https://github.com/ranitanjung163-alt/sembako-mart.git)
   cd sembako-mart
