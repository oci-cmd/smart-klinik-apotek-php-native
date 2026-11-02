# SmartClinic & Apotek Farmasi Terpadu (Smart Clinic ERP)
### Contoh Acuan Projek Mahasiswa — Pemrograman Web Dasar
**STMIK IKMI Cirebon — Semester Ganjil 2026/2027**
**Disusun Oleh: Rosidin, S. Kom., M. Kom.**

Repositori resmi contoh acuan projek (*role model project*) yang menggabungkan kompetensi Program Studi **S1 Sistem Informasi (SI)** dan **D3/D4 Komputerisasi Akuntansi (KA)** pada mata kuliah **Pemrograman Web Dasar** menggunakan arsitektur bersih **Full-Stack OOP MVC PHP Native 8+**, **MySQL**, **PDO Prepared Statements**, **CSS Responsif**, dan **Vanilla JavaScript**.

---

## 🌟 Fitur Utama Sistem

1. **Halaman Depan (Public Landing Page)**:
   - Profil klinik modern, katalog layanan 5 poli medis, dan katalog obat apotek terintegrasi.
   - Tombol pintas menuju Portal Petugas / CMS.
2. **Halaman Login Interaktif**:
   - Fitur **Eye Toggle Visible / Invisible Password** (👁️ / 🙈) berbasis JavaScript.
   - Enkripsi kata sandi **Bcrypt** (`PASSWORD_BCRYPT`).
   - Proteksi sesi aman (*Session Fixation & Hijacking Prevention*).
3. **5 Modul CRUD Terpadu**:
   - **Modul 1 (SI)**: Master Layanan Poli Medis & Katalog Obat (Batas minimum stok & Expired Alert).
   - **Modul 2 (SI)**: Registrasi Pasien & Antrean Rekam Medis Elektronik (EMR).
   - **Modul 3 (KA)**: Bagan Akun Standar (COA) Finansial Klinik & Proteksi Kepatuhan Audit.
   - **Modul 4 (KA)**: Kasir Billing Pasien & Pencatatan Kas Masuk/Keluar (Validasi Anti-Saldo Minus).
   - **Modul 5 (SI + KA)**: SPK Prioritas Pengadaan Obat Farmasi (Metode SAW) & Audit Log OWASP.

---

## 🛠️ Panduan Menjalankan di Komputer Lokal

```bash
# 1. Masuk ke direktori
cd /Users/rosidin/Sites/smart-klinik-apotek

# 2. Jalankan PHP Built-in Server (Contoh port 8383 atau 8000)
php -S localhost:8383

# 3. Inisialisasi Database (Hanya 1 Klik di Browser)
http://localhost:8383/setup.php

# 4. Akses Aplikasi
http://localhost:8383
```

---

## 🔐 Kredensial Login Demo (Password: `admin123`)
- **Super Admin**: `admin`
- **Dokter Poli**: `dokter1`
- **Kasir Billing**: `kasir1`
- **Apoteker Farmasi**: `apoteker1`

---
&copy; 2026 **STMIK IKMI Cirebon** — Pemrograman Web Dasar.
