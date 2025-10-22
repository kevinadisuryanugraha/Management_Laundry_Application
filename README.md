# 🧺 @MavinsLaundry: Laundry Point of Sales (POS) System

## Modern Management for Laundry Services

**@MavinsLaundry** adalah sistem Point of Sales (POS) dan manajemen yang dirancang khusus untuk bisnis _laundry_ atau binatu. Aplikasi ini fokus pada efisiensi transaksi, manajemen member, layanan, dan pelaporan status pekerjaan.

---

## ✨ Fitur Utama (Core Features)

| Kategori           | Fitur                   | Peran Akses      | Deskripsi                                                                                                                |
| :----------------- | :---------------------- | :--------------- | :----------------------------------------------------------------------------------------------------------------------- |
| **Manajemen Data** | **Manajemen Layanan**   | Admin            | Mengelola daftar layanan yang ditawarkan (misalnya: Cuci Dan Gosok, Hanya Gosok), Harga, dan Satuan (kg/pcs).            |
|                    | **Manajemen Member**    | Admin            | Mendaftarkan, mengedit, dan melihat daftar _member_ dengan fitur Filter tanggal dan Cetak Member.                        |
|                    | **Manajemen User**      | Admin            | Mengelola daftar pengguna sistem dan menetapkan peran (Admin, Kasir, Manajemen).                                         |
| **Transaksi**      | **Create Transaksi**    | Kasir            | Form untuk membuat pesanan baru, memilih Member, Layanan, Qty, Tanggal Masuk, dan Estimasi Selesai.                      |
|                    | **Manajemen Transaksi** | Admin, Manajemen | Melihat daftar transaksi lengkap (TRX-...) dengan status (Pending, Proses, Selesai) dan opsi Aksi (Detail, Edit, Struk). |
|                    | **Struk/Invoice**       | Kasir            | Mencetak struk transaksi yang mencantumkan detail pesanan, total, dan Estimasi Selesai.                                  |
| **Laporan**        | **Dashboard Overview**  | Admin, Manajemen | Menampilkan total Pendapatan (Rp 522.450), Total Transaksi, Total Member, dan Grafik Pemasukan Harian.                   |
|                    | **Laporan Detail**      | Admin, Manajemen | Laporan Transaksi dan Laporan Keuangan dengan fitur filter periode, dan opsi Cetak PDF.                                  |

---

## 👥 Role-Based Access Control (RBAC)

Sistem ini mendukung manajemen multi-pengguna dengan tiga peran utama (Admin, Kasir, Manajemen)[cite: 730].

| Peran         | Fokus Utama                | Akses Kritis                                                                  |
| :------------ | :------------------------- | :---------------------------------------------------------------------------- |
| **Admin**     | **Manajemen Sistem Penuh** | Akses penuh ke Manajemen User, Layanan, Member, dan semua Laporan.            |
| **Manajemen** | **Analisis & Pengawasan**  | Akses ke Dashboard, Laporan Transaksi/Keuangan, dan Manajemen Member/Layanan. |
| **Kasir**     | **Pencatatan & Transaksi** | Fokus pada Form Create Transaksi dan mencatat pembayaran (Struk Transaksi).   |

---

## 🛠️ Tech Stack & Tools

_(Asumsi teknologi utama sama dengan proyek Anda sebelumnya)_

<div align='center'>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" alt="PHP" width="48" height="48" style="margin: 4px;" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" alt="Laravel" width="48" height="48" style="margin: 4px;" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-plain.svg" alt="Bootstrap" width="48" height="48" style="margin: 4px;" />
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg" alt="MySQL" width="48" height="48" style="margin: 4px;" />
  <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="Git" width="48" height="48" style="margin: 4px;" />
</div>

---

## ⚙️ Instalasi Proyek

1.  **Clone Repositori:**

    ```bash
    git clone [https://github.com/kevinadisuryanugraha/mavins-laundry-pos.git](https://github.com/kevinadisuryanugraha/mavins-laundry-pos.git)
    cd mavins-laundry-pos
    ```

2.  **Instal Dependensi PHP (Composer):**

    ```bash
    composer install
    ```

3.  **Konfigurasi Lingkungan:**

    -   Duplikat file `.env.example` menjadi `.env`.
    -   Atur kunci aplikasi: `php artisan key:generate`

4.  **Konfigurasi Database:**

    -   Buat database baru.
    -   Perbarui kredensial database di file `.env`.

5.  **Jalankan Migrasi & Seeder:**

    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Aplikasi:**
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di `http://127.0.0.1:8000/login`[cite: 566].

---

## 📸 Dokumentasi (Screenshots)

*Semua *screenshot* disimpan dalam folder `readme_asset` di repositori ini.*

### 1. Otentikasi & Dashboard Utama

|                                                    Halaman Login                                                     |                                                      Dashboard Overview                                                       |
| :------------------------------------------------------------------------------------------------------------------: | :---------------------------------------------------------------------------------------------------------------------------: |
| ![Login Page](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/login.png) | ![Dashboard Admin](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/dashboard.png) |

<br/>

### 2. Manajemen Member & Layanan

|                                                             Manage Member                                                             |                                                        Manage Layanan (Service)                                                         |
| :-----------------------------------------------------------------------------------------------------------------------------------: | :-------------------------------------------------------------------------------------------------------------------------------------: |
| ![Manage Member Table](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/manage_member.png) | ![Manage Layanan Table](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/manage_layanan.png) |

<br/>

### 3. Proses Transaksi

|                                                           Form Create Transaksi                                                            |                                                           Struk Transaksi                                                           |
| :----------------------------------------------------------------------------------------------------------------------------------------: | :---------------------------------------------------------------------------------------------------------------------------------: |
| ![Form Create Transaksi](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/create_transaksi.png) | ![Struk Transaksi](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/struk_transaksi.png) |

<br/>

### 4. Detail Transaksi & User Management

|                                                           Detail Transaksi                                                            |                                                            Manajemen User                                                            |
| :-----------------------------------------------------------------------------------------------------------------------------------: | :----------------------------------------------------------------------------------------------------------------------------------: |
| ![Detail Transaksi](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/detail_transaksi.png) | ![Manajemen User Table](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/manage_user.png) |

<br/>

### 5. Laporan Transaksi & Keuangan

|                                                               Laporan Transaksi                                                               |                                                              Laporan Keuangan                                                               |
| :-------------------------------------------------------------------------------------------------------------------------------------------: | :-----------------------------------------------------------------------------------------------------------------------------------------: |
| ![Laporan Transaksi Table](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/laporan_transaksi.png) | ![Laporan Keuangan Graph](https://raw.githubusercontent.com/kevinadisuryanugraha/mavins-laundry-pos/main/readme_asset/laporan_keuangan.png) |

---

## 👨‍💻 Kontributor

| Nama                       | Peran                | GitHub                                                          |
| :------------------------- | :------------------- | :-------------------------------------------------------------- |
| **Kevin Adisurya Nugraha** | Full-Stack Developer | [kevinadisuryanugraha](https://github.com/kevinadisuryanugraha) |
