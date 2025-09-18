````markdown
# 💰 Kas GoNet V1

Aplikasi **Manajemen Kas** berbasis **PHP CodeIgniter 4** & **MySQL**.  
Didesain untuk membantu organisasi, komunitas, maupun usaha kecil dalam mencatat **kas masuk**, **kas keluar**, dan **pengajuan dana** dengan sistem **multi-role (Admin & User)**.  

---

## ✨ Fitur Utama

### 🔑 Autentikasi
- Login & Register
- Role: **Admin** dan **User**

### 👤 Admin
- 📊 Dashboard kas
- ➕ CRUD **Kas Masuk**
- ➖ CRUD **Kas Keluar**
- 👥 Manajemen User
- 📑 Pengelolaan Pengajuan dari User
- 📈 Laporan kas

### 👥 User
- 🏠 Dashboard user
- 📑 CRUD **Pengajuan**

---

## 🚀 Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/Yks889/kas-gonetv1.git
cd kas-gonetv1
````

### 2️⃣ Install Dependensi

```bash
composer install
```

### 3️⃣ Konfigurasi Environment

Salin `.env.example` menjadi `.env` lalu sesuaikan:

```bash
cp .env.example .env
```

Atur database MySQL:

```ini
database.default.hostname = localhost
database.default.database = kas_gonet
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### 4️⃣ Migrasi & Seeder

```bash
php spark migrate
php spark db:seed
```

### 5️⃣ Jalankan Server

```bash
php spark serve
```

Akses di browser:
👉 `http://localhost:8080`

---

## 📂 Struktur Folder

```
app/
├── Config/        # Konfigurasi aplikasi
├── Controllers/   # Logic Admin & User
│   ├── Admin/     # Dashboard, Kas, Laporan, Pengajuan, User
│   └── User/      # Dashboard, Pengajuan
├── Database/      # Migration & Seeder
├── Filters/       # Middleware Role & Auth
├── Helpers/       # Helper custom
├── Models/        # Model database (Kas, User, Pengajuan, dll)
├── Views/         # Tampilan (Admin, User, Auth, Layouts)
```

---

## 🛠️ Teknologi yang Digunakan

* 🐘 [PHP 8+](https://www.php.net/)
* ⚡ [CodeIgniter 4](https://codeigniter.com/)
* 🗄️ [MySQL](https://www.mysql.com/)
* 📦 [Composer](https://getcomposer.org/)

---

## 👨‍💻 Kontribusi

Kontribusi sangat terbuka 🎉

1. Fork repo ini
2. Buat branch baru:

   ```bash
   git checkout -b fitur-baru
   ```
3. Commit perubahan:

   ```bash
   git commit -m "Tambah fitur baru"
   ```
4. Push ke branch:

   ```bash
   git push origin fitur-baru
   ```
5. Buat **Pull Request**

---

## 📜 Lisensi

Proyek ini dilisensikan di bawah **MIT License**.
Silakan gunakan & kembangkan sesuai kebutuhan.

---

## 📩 Kontak

Dikembangkan oleh **[@Yks889](https://github.com/Yks889)**
💬 Untuk pertanyaan & saran, silakan buat **issue** di repo ini.

```
