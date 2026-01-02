# 📡 Backend REST API Mahasiswa (CodeIgniter 4)

Backend ini merupakan **REST API berbasis CodeIgniter 4** yang digunakan untuk mengelola **data mahasiswa** (CRUD).  
API ini berperan sebagai **server** yang diakses oleh aplikasi **Android (Kotlin + Retrofit)**.

---

## 🎯 Fitur Utama

- REST API menggunakan CodeIgniter 4
- CRUD Data Mahasiswa
  - Create (Tambah data)
  - Read (Lihat daftar & detail)
  - Update (Ubah data)
  - Delete (Hapus data)
- Format response **JSON**
- Validasi data di backend
- Terhubung dengan database **MySQL**

---

## 🧱 Teknologi yang Digunakan

- PHP ≥ 8.0
- CodeIgniter 4
- MySQL / MariaDB
- Composer
- REST API

---

## 📂 Struktur Database

Database: **db_mahasiswa**

File SQL sudah tersedia di repository ini: https://github.com/ikhsansetiaji/TAMWSP-CI4.git

2️⃣ Install Dependency

composer install

3️⃣ Konfigurasi Environment
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost

database.default.database = db_mahasiswa

database.default.username = root

database.default.password =

database.default.DBDriver = MySQLi

database.default.port = 3306

4️⃣ Import Database

5️⃣ Jalankan Server

Gunakan salah satu perintah berikut:

php spark serve --host=0.0.0.0 --port=8080

atau

php -S 0.0.0.0:8080 -t public

🔗 Endpoint API
Method Endpoint Keterangan

GET /mahasiswa Ambil semua data

GET /mahasiswa/{id} Detail mahasiswa

POST /mahasiswa Tambah data

POST /mahasiswa/update/{id} Update data

DELETE /mahasiswa/{id} Hapus data

📱 Integrasi dengan Android

Backend ini digunakan oleh aplikasi Android berikut:

🔗 Android App Repository:
https://github.com/ikhsansetiaji/Android-CRUD-Mahasiswa

Aplikasi Android menggunakan:

Kotlin

Retrofit

ConstraintLayout

RecyclerView

📌 Catatan Pengembangan

Backend ini tidak menangani autentikasi

Aplikasi Android tidak mengakses database secara langsung

Seluruh komunikasi menggunakan REST API + JSON

👨‍🎓 Author

**Ikhsan Setiaji**

Mahasiswa

Project Tugas Akhir / UAS Mobile & Web Service
