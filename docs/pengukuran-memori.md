# Pengukuran Memori: get() vs lazyById()

Dataset: 51.442 row pada tabel `transactions` (1.442 hasil seeder + 50.000 dummy).

Lingkungan pengujian: PHP 8.5.9 CLI, Windows.

## Hasil Pengukuran

### Pengukuran apple-to-apple pada memory_limit = 512 MB

| Cara baca data | Peak memory (MB) | Jumlah row |
|---|---|---|
| `Transaction::lazyById()` | 41.4 | 51.442 |
| `Transaction::get()` | 97.7 | 51.442 |

Selisih: 97.7 - 41.4 = 56.3 MB (2.36x lebih besar untuk `get()`).

### Pengukuran pada memory_limit default (128 MB)

| Cara baca data | Peak memory (MB) | Status |
|---|---|---|
| `Transaction::lazyById()` | 70.8 | Berhasil |
| `Transaction::get()` | ≥ 128 (exhausted) | **Gagal** — Fatal Error `Allowed memory size of 134217728 bytes exhausted` di `Model.php:701` |

## Kesimpulan Kelompok

1. `lazyById()` membaca data per chunk (default 1.000 row), sehingga hanya
   sebagian row yang berada di memori pada satu waktu. Pada pengukuran
   apple-to-apple (memory_limit 512 MB), `lazyById()` hanya memakai
   **41.4 MB** untuk 51.442 row — sangat dekat dengan angka pengajar (38 MB).

2. `get()` memuat seluruh 51.442 row sekaligus. Pada pengukuran yang sama,
   `get()` memakai **97.7 MB** — sekitar **56.3 MB (2.36x)** lebih besar dari
   `lazyById()`. Angka ini juga dekat dengan pengajar (96 MB).

3. Pada `memory_limit` default 128 MB, `get()` **gagal total**:
   PHP menghentikan eksekusi dengan Fatal Error "Allowed memory size of
   134217728 bytes exhausted" di `Model.php:701`, tepat ketika Laravel
   mencoba membuat object `Transaction` berikutnya. `lazyById()` pada
   konfigurasi default masih berhasil (peak 70.8 MB).

4. Menarik untuk dicatat: pada percobaan pertama (memory_limit 128 MB),
   `lazyById()` terukur 70.8 MB; setelah memory_limit dinaikkan ke 512 MB,
   peak turun menjadi 41.4 MB. Hal ini terjadi karena PHP memiliki ruang
   lebih untuk garbage collector bekerja optimal, sehingga object yang
   sudah selesai diproses lebih cepat dilepas dari memori.

5. Selisih peak memory akan **semakin lebar** seiring bertambahnya jumlah
   row, karena `get()` memuat semua row sekaligus (O(n)), sedangkan
   `lazyById()` memuat sebesar chunk (O(chunk_size)). Untuk export CSV
   maupun proses lain yang membaca banyak row, `lazyById()` adalah
   pilihan yang tepat — persis seperti yang dipakai di
   `ReportController::exportCsv()` pada Langkah 3.
