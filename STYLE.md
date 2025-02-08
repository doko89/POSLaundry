Berikut adalah versi **Markdown** yang diperbarui untuk **style web aplikasi Smart Laundry**, dengan penambahan panduan desain responsif agar tampilan lebih optimal di berbagai perangkat seperti **HP (mobile)**, **Tablet**, dan **Desktop**:

---

# **Style Guide untuk Smart Laundry Web Application**

## **Typography**
- **Font Utama**: `Roboto`
- **Font Secondary**: `Open Sans`
- **Ukuran Font**:
  - Header: 
    - Desktop: `24px` (Bold)
    - Tablet: `20px` (Bold)
    - Mobile: `18px` (Bold)
  - Subheader: 
    - Desktop: `18px` (Semi-Bold)
    - Tablet: `16px` (Semi-Bold)
    - Mobile: `14px` (Semi-Bold)
  - Body Text: 
    - Desktop: `14px` (Regular)
    - Tablet: `13px` (Regular)
    - Mobile: `12px` (Regular)
  - Small Text: 
    - Desktop: `12px` (Light)
    - Tablet: `11px` (Light)
    - Mobile: `10px` (Light)

## **Warna**
- **Primary Color**: `#4CAF50` (Hijau)
- **Secondary Color**: `#FF9800` (Oranye)
- **Background Color**: `#F5F5F5` (Abu-abu Muda)
- **Text Color**: 
  - Dark: `#333333`
  - Light: `#FFFFFF`

## **Responsiveness**
Untuk memastikan tampilan responsif di berbagai perangkat, gunakan pendekatan **Grid System** atau **Flexbox** dengan media queries.

### **Breakpoints Media Queries**
- **Mobile**: `< 640px`
- **Tablet**: `640px - 1024px`
- **Desktop**: `> 1024px`

```css
/* Contoh CSS Media Queries */
@media (max-width: 640px) {
  /* Styles for Mobile */
}

@media (min-width: 641px) and (max-width: 1024px) {
  /* Styles for Tablet */
}

@media (min-width: 1025px) {
  /* Styles for Desktop */
}
```

## **Button Styles**
- **Primary Button**:
  - Background: `#4CAF50`
  - Text Color: `#FFFFFF`
  - Border: `none`
  - Padding: 
    - Desktop: `10px 20px`
    - Tablet: `8px 16px`
    - Mobile: `6px 12px`
  - Radius: `5px`

- **Secondary Button**:
  - Background: `#FF9800`
  - Text Color: `#FFFFFF`
  - Border: `none`
  - Padding: 
    - Desktop: `10px 20px`
    - Tablet: `8px 16px`
    - Mobile: `6px 12px`
  - Radius: `5px`

- **Disabled Button**:
  - Background: `#CCCCCC`
  - Text Color: `#666666`
  - Border: `none`
  - Padding: 
    - Desktop: `10px 20px`
    - Tablet: `8px 16px`
    - Mobile: `6px 12px`
  - Radius: `5px`

## **Input Fields**
- **Default Input**:
  - Background: `#FFFFFF`
  - Border: `1px solid #DDDDDD`
  - Border Radius: `5px`
  - Padding: 
    - Desktop: `10px`
    - Tablet: `8px`
    - Mobile: `6px`
  - Placeholder Color: `#AAAAAA`

- **Focus Input**:
  - Border: `2px solid #4CAF50`
  - Box Shadow: `0px 0px 5px rgba(76, 175, 80, 0.5)`

## **Table Design**
- **Header**:
  - Background: `#4CAF50`
  - Text Color: `#FFFFFF`
  - Padding: 
    - Desktop: `10px`
    - Tablet: `8px`
    - Mobile: `6px`
  - Border: `1px solid #DDDDDD`

- **Body**:
  - Background: `#FFFFFF`
  - Text Color: `#333333`
  - Padding: 
    - Desktop: `10px`
    - Tablet: `8px`
    - Mobile: `6px`
  - Border: `1px solid #DDDDDD`

### **Responsive Table**
Untuk tabel, gunakan teknik **horizontal scrolling** atau **stacked layout** pada mobile:
```css
@media (max-width: 640px) {
  table {
    display: block;
    overflow-x: auto;
  }
}
```

## **Alerts**
- **Success Alert**:
  - Background: `#C8E6C9`
  - Text Color: `#2E7D32`
  - Border: `1px solid #388E3C`
  - Padding: 
    - Desktop: `10px`
    - Tablet: `8px`
    - Mobile: `6px`
  - Radius: `5px`

- **Error Alert**:
  - Background: `#FFCDD2`
  - Text Color: `#C62828`
  - Border: `1px solid #B71C1C`
  - Padding: 
    - Desktop: `10px`
    - Tablet: `8px`
    - Mobile: `6px`
  - Radius: `5px`

## **Sidebar Responsiveness**
- **Desktop**:
  - Sidebar tetap terbuka di sisi kiri.
  - Lebar sidebar: `250px`.

- **Tablet**:
  - Sidebar dapat dilipat (toggleable).
  - Lebar sidebar saat terbuka: `200px`.
  - Icon-only mode saat dilipat.

- **Mobile**:
  - Sidebar disembunyikan secara default.
  - Buka sidebar menggunakan tombol hamburger (`☰`).
  - Tampilan fullscreen saat sidebar dibuka.

```css
@media (max-width: 640px) {
  .sidebar {
    display: none;
  }
  .sidebar.active {
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 999;
  }
}
```

## **Spacing**
- **Margin**: 
  - Desktop: `10px`
  - Tablet: `8px`
  - Mobile: `6px`
- **Padding**: 
  - Desktop: `15px`
  - Tablet: `12px`
  - Mobile: `10px`

## **Card Layout**
Gunakan **card layout** untuk menampilkan data seperti daftar kios, pengguna, atau transaksi. Pastikan card responsif dengan lebar maksimal `100%`.

```css
.card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 10px;
}

@media (max-width: 640px) {
  .card {
    padding: 10px;
    margin-bottom: 8px;
  }
}
```

---

### **Catatan Tambahan**
- Gunakan **Tailwind CSS** atau **Material-UI** untuk mempermudah implementasi responsif design.
- Pastikan semua gambar menggunakan atribut `width: 100%` dan `height: auto` agar responsif.
- Untuk navigasi, gunakan **burger menu** pada mobile dan tablet untuk menghemat ruang.

---

Dengan panduan ini, aplikasi **Smart Laundry** akan memiliki tampilan yang optimal di semua perangkat, mulai dari **mobile**, **tablet**, hingga **desktop**.