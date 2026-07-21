# 🌍 Supply Chain Risk Management System

## 📖 Deskripsi

Supply Chain Risk Management System adalah aplikasi berbasis web yang dirancang untuk membantu perusahaan dalam memantau, menganalisis, dan mengelola risiko rantai pasok global. Sistem ini mengintegrasikan data cuaca, ekonomi, nilai tukar mata uang, pelabuhan, berita internasional, serta indikator risiko negara untuk mendukung pengambilan keputusan yang lebih cepat dan akurat.

---

# 🎯 Tujuan Sistem

Sistem ini dikembangkan untuk:

- Memantau kondisi negara yang berpotensi memengaruhi rantai pasok global.
- Mengidentifikasi risiko berdasarkan faktor cuaca, ekonomi, mata uang, berita, dan infrastruktur pelabuhan.
- Membantu perusahaan memilih negara tujuan impor yang lebih aman.
- Memberikan peringatan dini (early warning system) terhadap potensi gangguan supply chain.
- Menyediakan dashboard analitik untuk mendukung pengambilan keputusan berbasis data.

---

# ⚙️ Teknologi yang Digunakan

| Teknologi | Fungsi |
|-----------|---------|
| Laravel 12 | Framework Backend |
| PHP 8.x | Bahasa Pemrograman Backend |
| MySQL | Database Management System |
| Bootstrap 5 | User Interface Framework |
| JavaScript | Interaktivitas Frontend |
| Chart.js | Visualisasi Data dan Grafik |
| Leaflet.js | Peta Interaktif |
| Open-Meteo API | Data Cuaca Real-time |
| GNews API | Data Berita Global |
| REST Countries API | Data negara, bendera, kode negara, populasi, wilayah, dan koordinat geografis |
| World Bank API | Data ekonomi negara seperti GDP, inflasi, ekspor, impor, dan indikator pembangunan |
| Laravel Scheduler | Otomatisasi Pembaruan Data |
| Laravel Queue | Pemrosesan Background Job |

---

# 🔗 Endpoint Utama Sistem

| Method | Endpoint | Fungsi |
|---------|----------|---------|
| GET | /ui/dashboard | Dashboard utama |
| GET | /ui/countries/{id} | Detail negara |
| GET | /ui/analytics | Global Analytics Center |
| GET | /ui/news | Global News Intelligence |
| GET | /ui/ports | Global Port Monitoring |
| GET | /ui/articles | Daftar artikel |
| GET | /ui/articles/{slug} | Detail artikel |
| GET | /watchlist | Monitoring watchlist |
| GET | /ui/intelligence | Intelligence Dashboard |
| GET | /comparison/data | Perbandingan negara |

Secara keseluruhan sistem memiliki lebih dari 30 endpoint yang mencakup autentikasi, dashboard, analitik, monitoring, watchlist, artikel, manajemen pelabuhan, dan panel administrasi.

---

# ⏰ Scheduler dan Automation

Sistem menggunakan Laravel Scheduler untuk melakukan pembaruan data secara otomatis, meliputi:

- Update data cuaca.
- Update nilai tukar mata uang.
- Update berita global.
- Perhitungan ulang Risk Score.
- Pembuatan Alert otomatis.

# Instalasi
Clone Repository
git clone https://github.com/agustiandapadil-boop/supply-chain-risk-management.git

- Masuk ke Folder Project
``` bash
cd supply-chain-risk-management
```

- Install Dependency
``` bash
composer install
```

- Salin File Environment
``` bash
cp .env.example .env
```

- Generate Application Key
``` bash
php artisan key:generate
```

- Konfigurasi Database
Edit file .env
DB_DATABASE=supply_chain_risk
DB_USERNAME=root
DB_PASSWORD=

- Jalankan Migrasi
``` bash
php artisan migrate
```

- Jalankan Seeder
``` bash
php artisan db:seed
```

Menjalankan scheduler:

```bash
php artisan schedule:work
```

Menjalankan queue:

```bash
php artisan queue:work
```

Menjalankan server:

```bash
php artisan serve
```

---