# Normalisasi Database - Sistem Informasi Rental Mobil

Proses normalisasi digunakan untuk meminimalkan redundansi data dan menghindari anomali (insert, update, delete) pada database. Berikut adalah tahapan normalisasi dari data tidak ternormalisasi hingga memenuhi bentuk 3NF (Third Normal Form).

---

## 1. Bentuk Tidak Ternormalisasi (Unnormalized Form - UNF) & 1NF (First Normal Form)

Pada tahap **1NF**, kita memastikan bahwa setiap kolom berisi nilai atomik (tunggal) dan tidak ada grup berulang (repeating groups).

### Atribut Unnormalized / 1NF:
Dalam satu baris data sewa, terdapat informasi pelanggan, mobil, transaksi, dan pengembalian yang digabungkan menjadi satu tabel besar:

| Nama Kolom | Jenis Kunci | Deskripsi |
| :--- | :--- | :--- |
| **id_sewa** | PK / Candidate Key | ID unik untuk baris transaksi |
| **id_pelanggan** | - | ID Pelanggan |
| **nama_pelanggan** | - | Nama Pelanggan |
| **no_ktp** | - | Nomor KTP Pelanggan |
| **id_mobil** | - | ID Mobil |
| **merek_mobil** | - | Merek Mobil |
| **plat_nomor** | - | Plat Nomor Mobil |
| **harga_sewa_perhari** | - | Harga sewa per hari |
| **tgl_sewa** | - | Tanggal sewa |
| **tgl_kembali_rencana**| - | Tanggal rencana kembali |
| **total_bayar** | - | Total biaya sewa sementara |
| **tgl_kembali_aktual** | - | Tanggal pengembalian riil |
| **denda** | - | Denda keterlambatan |

> **Kelemahan 1NF**: Redundansi data yang sangat tinggi. Misalnya, jika seorang pelanggan menyewa mobil beberapa kali, maka `nama_pelanggan`, `no_ktp`, `no_telp`, dan `alamat` harus ditulis ulang di setiap baris transaksi sewa. Begitu pula dengan data mobil.

---

## 2. Bentuk Normal Kedua (2NF - Second Normal Form)

Untuk memenuhi **2NF**, database harus sudah memenuhi **1NF** dan **semua atribut non-key harus bergantung sepenuhnya (fully functionally dependent) pada Primary Key**. Atribut yang hanya bergantung pada sebagian key (partial dependency) dipisahkan menjadi tabel tersendiri.

Berdasarkan analisis ketergantungan:
- Informasi pelanggan (`nama`, `no_ktp`, `no_telp`, `alamat`) hanya bergantung pada `id_pelanggan`.
- Informasi mobil (`merek`, `model`, `plat_nomor`, `harga_sewa_perhari`, `status`) hanya bergantung pada `id_mobil`.
- Informasi sewa (`tgl_sewa`, `tgl_kembali_rencana`, `total_bayar`) bergantung pada transaksi itu sendiri (`id_sewa`).
- Informasi pengembalian (`tgl_kembali_aktual`, `denda`) bergantung pada tindakan pengembalian itu sendiri (`id_kembali`), yang memiliki relasi ke transaksi sewa (`id_sewa`).

Oleh karena itu, data dipecah menjadi 4 tabel terpisah:

### A. Tabel Pelanggan
Menyimpan data master pelanggan.
- **Primary Key**: `id_pelanggan`
- **Atribut**: `nama`, `no_ktp`, `no_telp`, `alamat`

### B. Tabel Mobil
Menyimpan data master armada mobil.
- **Primary Key**: `id_mobil`
- **Atribut**: `merek`, `model`, `plat_nomor`, `harga_sewa_perhari`, `status`

### C. Tabel Transaksi_Sewa
Menghubungkan pelanggan dan mobil dalam transaksi penyewaan.
- **Primary Key**: `id_sewa`
- **Foreign Key**: `id_pelanggan` (ke tabel Pelanggan), `id_mobil` (ke tabel Mobil)
- **Atribut**: `tgl_sewa`, `tgl_kembali_rencana`, `total_bayar`

### D. Tabel Pengembalian
Mencatat penyelesaian transaksi sewa.
- **Primary Key**: `id_kembali`
- **Foreign Key**: `id_sewa` (ke tabel Transaksi_Sewa)
- **Atribut**: `tgl_kembali_aktual`, `denda`

---

## 3. Bentuk Normal Ketiga (3NF - Third Normal Form)

Untuk memenuhi **3NF**, database harus sudah memenuhi **2NF** dan **tidak boleh ada ketergantungan transitif** (transitive dependency), yaitu atribut non-primary key tidak boleh menentukan atribut non-primary key lainnya.

Mari kita periksa struktur tabel hasil 2NF:
1. **Tabel Pelanggan**: Atribut `nama`, `no_ktp`, `no_telp`, `alamat` semuanya bergantung langsung pada `id_pelanggan`. Tidak ada atribut non-key yang menentukan atribut non-key lainnya. (Memenuhi 3NF)
2. **Tabel Mobil**: Atribut `merek`, `model`, `plat_nomor`, `harga_sewa_perhari`, `status` semuanya bergantung langsung pada `id_mobil`. Tidak ada ketergantungan transitif. (Memenuhi 3NF)
3. **Tabel Transaksi_Sewa**: Atribut `tgl_sewa`, `tgl_kembali_rencana`, dan `total_bayar` bergantung langsung pada `id_sewa`. Meskipun `total_bayar` dapat dihitung secara logis dari `selisih hari * harga_sewa_perhari`, penyimpanan nilai riil di database diperlukan untuk mengamankan data historis (jika di kemudian hari tarif sewa mobil diubah, total bayar transaksi masa lalu tidak ikut berubah). Tidak ada ketergantungan transitif. (Memenuhi 3NF)
4. **Tabel Pengembalian**: Atribut `tgl_kembali_aktual` dan `denda` bergantung langsung pada `id_kembali` (dan melalui `id_sewa`). Tidak ada ketergantungan transitif antar atribut non-key. (Memenuhi 3NF)

**Kesimpulan**: Struktur tabel hasil dekomposisi pada tahap **2NF** di atas secara otomatis telah memenuhi kriteria **3NF** karena tidak mengandung ketergantungan transitif tersembunyi.
