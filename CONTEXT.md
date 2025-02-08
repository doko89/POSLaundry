Berikut adalah versi **Markdown** yang telah diperbarui dengan penambahan fitur **Scan WhatsApp di halaman Admin** untuk memberikan notifikasi pemilik kios apabila waktu berlangganan akan habis:

---

# **Smart Laundry**

## **Deskripsi**
Smart Laundry adalah aplikasi web berbasis Point of Sale (POS) yang dirancang untuk membantu mengatur transaksi pada kios laundry. Aplikasi ini memungkinkan pengelolaan operasional laundry secara efisien dengan tiga peran pengguna utama: **Administrator**, **Owner**, dan **Worker**.

---

## **Menu Sidebar untuk Setiap Peran**

### 1. **Sidebar Administrator**
Menu sidebar untuk Administrator mencakup halaman-halaman berikut:
- **Dashboard**: `/admin/dashboard`
- **Manajemen Kios**: `/admin/kios`
- **Manajemen Pengguna**: `/admin/users`
- **Pengaturan Sistem**: `/admin/settings`
- **Profil**: `/admin/profile`

### 2. **Sidebar Owner**
Menu sidebar untuk Owner mencakup halaman-halaman berikut:
- **Dashboard**: `/owner/dashboard`
- **Manajemen Pekerja**: `/owner/workers`
- **Laporan Keuangan**: `/owner/reports`
- **Pembukuan**: `/owner/accounting`
- **Membuat Layanan**: `/owner/services`
- **Profil**: `/owner/profile`

### 3. **Sidebar Worker**
Menu sidebar untuk Worker mencakup halaman-halaman berikut:
- **Dashboard**: `/worker/dashboard`
- **Tambah Pelanggan**: `/worker/customers`
- **Buat Order**: `/worker/orders`
- **Status Cucian**: `/worker/status`
- **Profil**: `/worker/profile`

---

## **Halaman Profil**
Halaman **Profil** memungkinkan semua pengguna (**Administrator**, **Owner**, dan **Worker**) untuk mengelola informasi akun mereka, termasuk mengubah password. Berikut adalah fitur yang tersedia di halaman ini:
- **Nama Lengkap**: Menampilkan nama lengkap pengguna.
  - **Catatan**: Untuk **Worker**, nama lengkap tidak dapat diedit.
- **Email**: Menampilkan alamat email pengguna.
  - **Catatan**: Untuk **Worker**, email tidak dapat diedit.
- **Formulir Ubah Password**: Input untuk memasukkan password lama, password baru, dan konfirmasi password baru.
- **Validasi Formulir**: Validasi password minimal 8 karakter, kombinasi huruf besar/kecil, angka, dan karakter khusus.
- **Notifikasi Sukses/Error**: Notifikasi jika password berhasil diubah atau terjadi kesalahan.

---

## **Fitur Terkait Kios**

### 1. **Expired Date pada Data Kios**
Setiap kios memiliki **Expired Date**, yaitu tanggal berakhirnya masa sewa kios. Informasi ini penting untuk mengelola status kios (**Aktif**, **Suspend**, **Expired**) dan memberikan notifikasi kepada Administrator atau Owner jika masa sewa hampir habis.

### 2. **Metode Perpanjang Sewa Kios**
Proses perpanjangan sewa kios dilakukan melalui halaman **Manajemen Kios** di halaman Administrator. Langkah-langkah:
1. **Pilih Kios**: Administrator memilih kios yang ingin diperpanjang dari daftar kios.
2. **Formulir Perpanjangan**:
   - Durasi Sewa: Pilih durasi baru (misalnya, 1 bulan, 3 bulan, 6 bulan, atau 1 tahun).
   - Tanggal Mulai: Otomatis dihitung berdasarkan expired date sebelumnya atau bisa disesuaikan manual.
   - Tanggal Berakhir: Otomatis dihitung berdasarkan durasi sewa yang dipilih.
3. **Konfirmasi Pembayaran**: Tambahkan informasi pembayaran (jumlah yang dibayarkan oleh Owner).
4. **Simpan Perubahan**: Status kios diperbarui menjadi **Aktif** dan expired date diperpanjang.

### 3. **Scan QR Code WhatsApp**
Di halaman **Manajemen Kios**, Administrator dapat menambahkan nomor WhatsApp kios dengan cara:
- **Scan QR Code WhatsApp**: Gunakan fitur scan QR Code untuk menghubungkan nomor WhatsApp kios ke aplikasi.
- **Verifikasi Nomor**: Nomor WhatsApp diverifikasi otomatis setelah scan berhasil.
- **Notifikasi Waktu Berlangganan**: Jika waktu berlangganan kios akan habis, sistem akan mengirim notifikasi WhatsApp ke pemilik kios menggunakan nomor yang telah diverifikasi.

---

## **Halaman Administrator**
Administrator adalah pemilik layanan web aplikasi yang bertanggung jawab atas pengaturan sistem, manajemen kios, dan konfigurasi umum aplikasi.

### 1. **Dashboard**
- **Ringkasan Kios**: Jumlah total kios yang aktif, suspend, dan expired.
- **Statistik Pengguna**: Jumlah total pengguna berdasarkan role (Owner, Worker).
- **Notifikasi**: Informasi penting seperti kios yang akan expired atau perlu diperpanjang.

### 2. **Manajemen Kios**
- **Daftar Kios**: Tabel yang menampilkan semua kios beserta statusnya (**Aktif**, **Suspend**, **Expired**).
  - **Tambah/Edit/Hapus Kios**: Formulir untuk membuat, mengedit, atau menghapus kios.
  - **Perpanjang Sewa**: Fitur untuk memperpanjang masa sewa kios.
  - **Scan QR Code WhatsApp**: Fitur untuk menambahkan nomor WhatsApp kios dan mengaktifkan notifikasi otomatis.

### 3. **Manajemen Pengguna**
- **Daftar Pengguna**: Tabel yang menampilkan semua pengguna beserta role mereka.
  - **Tambah/Edit/Hapus Pengguna**: Formulir untuk menambahkan, mengedit, atau menghapus pengguna.

### 4. **Pengaturan Sistem**
- **Konfigurasi Umum**: Pengaturan global seperti mata uang, format tanggal, dll.
- **Backup Data**: Fitur untuk melakukan backup data aplikasi.
- **Log Aktivitas**: Menampilkan log aktivitas penting di sistem.

---

## **Halaman Owner**
Owner adalah penyewa layanan web aplikasi yang bertanggung jawab atas pengelolaan operasional kios laundry mereka.

### 1. **Dashboard**
- **Ringkasan Transaksi**: Jumlah total transaksi harian, mingguan, dan bulanan.
- **Laporan Keuangan**: Grafik atau tabel yang menunjukkan pendapatan dan pengeluaran.
- **Status Cucian**: Jumlah cucian yang sedang diproses, siap diambil, atau sudah diambil.

### 2. **Manajemen Pekerja**
- **Daftar Pekerja**: Tabel yang menampilkan semua pekerja di kios tersebut.
  - **Tambah/Edit/Hapus Pekerja**: Formulir untuk mendaftarkan, mengedit, atau menghapus pekerja.

### 3. **Laporan**
- **Laporan Harian/Mingguan/Bulanan**: Menampilkan laporan transaksi dengan detail pendapatan dan statistik lainnya.
- **Export Laporan**: Fitur untuk mengekspor laporan ke format PDF atau Excel.

### 4. **Pembukuan**
- **Total Pendapatan/Pengeluaran**: Ringkasan keuangan kios.
- **Rincian Transaksi**: Daftar transaksi yang telah dilakukan.
- **Pencatatan Pengeluaran**: Formulir untuk mencatat pengeluaran baru.
- **Filter/Pencarian**: Filter berdasarkan tanggal atau pencarian berdasarkan nomor order/nama pelanggan.
- **Export Data**: Export ke Excel/CSV atau PDF.

---

## **Halaman Worker**
Worker bertugas menangani transaksi sehari-hari di kios laundry.

### 1. **Tambah Data Pelanggan**
- **Formulir Tambah Pelanggan**: Formulir untuk menambahkan data pelanggan baru.
- **Riwayat Pelanggan**: Riwayat transaksi pelanggan tertentu.

### 2. **Membuat Order**
- **Formulir Buat Order**: Formulir untuk membuat order baru.
  - **Generate QR Code**: QR Code otomatis dihasilkan saat order selesai dibuat.
  - **Print Invoice**: Invoice dicetak menggunakan printer Bluetooth matrix 58mm.

---

## **Teknologi yang Digunakan**
- **Frontend**: Blade Templating dengan Tailwind CSS atau Material-UI
- **Backend**: Laravel 10
- **Database**: MySQL
- **QR Code Generator**: Simple QrCode
- **Notifikasi WhatsApp**: Baileys
- **Styling**: Tailwind CSS atau Material-UI

---

## **Fitur Notifikasi WhatsApp**
Aplikasi memiliki fitur notifikasi WhatsApp menggunakan **Baileys**:
- **Notifikasi Order Selesai**: Ketika status order berubah menjadi "Selesai", sistem akan mengirim pesan WhatsApp ke pelanggan.
- **Notifikasi Expired Date Kios**: Mengirim notifikasi ke Owner/Administrator jika masa sewa kios hampir habis.

---

## **Wireframe**
![Wireframe Dashboard](link-gambar-dashboard.png)

---

## **Referensi**
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/)
- [Simple QrCode](https://github.com/SimpleSoftwareIO/simple-qrcode)
- [Baileys GitHub](https://github.com/adiwajshing/Baileys)

--- 
