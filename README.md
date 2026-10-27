<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


Tantangan 5, Menjelaskan validasi numeric pada field total:
Validasi numeric di field total masih belum cukup karena itu hanya melakukan pengecekan di sisi client, di server kita harus cek lagi apakah benar produk yang dibeli dengan harganya jika dikalikan akan menghasilkan total yang sesuai, sehingga kita tidak mendapat kerugian jika data yang dikirim dari client ke server sudah dimodifikasi

## Skenario Uji Manual

Persiapan: jalankan `php artisan migrate:fresh --seed`, lalu `php artisan serve`
(dan `npm run dev` di terminal kedua).

### Peran: Admin (admin@pos.test / password)

| No | Langkah | Hasil yang diharapkan |
|----|---------|-----------------------|
| 1 | Buka `/login`, masuk sebagai admin@pos.test | Berhasil masuk, diarahkan ke `/pos` |
| 2 | Lihat navigasi | Menu Produk dan Kategori tampil |
| 3 | Buka `/products` | Daftar produk tampil normal |
| 4 | Klik Keluar | Kembali ke halaman `/login` |

### Peran: Kasir (kasir@pos.test / password)

| No | Langkah | Hasil yang diharapkan |
|----|---------|-----------------------|
| 1 | Buka `/login`, masuk sebagai kasir@pos.test | Berhasil masuk, diarahkan ke `/pos` |
| 2 | Lihat navigasi | Menu Produk dan Kategori tidak tampil, tombol Keluar tetap ada |
| 3 | Buka `/pos` | Halaman kasir tampil normal |
| 4 | Buka `/products` lewat address bar | Halaman 403 "Anda tidak memiliki akses untuk halaman ini." |
| 5 | Klik Keluar | Kembali ke halaman `/login` |

### Tanpa login (tamu)

| No | Langkah | Hasil yang diharapkan |
|----|---------|-----------------------|
| 1 | Buka `/products` | Diarahkan ke `/login` |
| 2 | Login dengan kata sandi salah | Pesan "Email atau kata sandi salah." |
| 3 | `curl -i http://127.0.0.1:8000/pos -H "Accept: application/json"` | Status 401, isi `{"message":"Unauthenticated."}` |


## Perbandingan Import Produk: Manual vs Laravel Excel

Kami membandingkan import manual (`ReportController` dan `ProcessProductImport`) dengan import memakai Laravel Excel (`ProductsImport` dengan `ToModel`, `WithHeadingRow`, dan `WithChunkReading`).

Versi Laravel Excel lebih ringkas, karena pembacaan header, validasi per row, dan pembacaan per chunk cukup dideklarasikan lewat interface, tanpa `str_getcsv`, `array_combine`, dan pengecekan jumlah column secara manual. Library ini juga mencatat nomor row dan pesan error untuk row yang gagal validasi.

Versi manual lebih mudah dikontrol dan dipahami alurnya. Kami bisa menghitung produk baru dan diperbarui lewat `wasRecentlyCreated`, tanpa dependency tambahan, dan sudah terhubung ke queue. Versi Laravel Excel yang kami buat berjalan langsung di request.

Catatan: proyek kami memakai Laravel Excel v4, sehingga method `model()` perlu tipe kembalian `Model|array|null`. Ini contoh bahwa memakai library membawa konsekuensi versi.

Kesimpulan: Laravel Excel lebih praktis untuk file besar dan format beragam, sedangkan versi manual cukup untuk kebutuhan sederhana yang butuh kontrol penuh.