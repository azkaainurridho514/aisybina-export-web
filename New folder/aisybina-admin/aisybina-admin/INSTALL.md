# Fondasi admin + modul Kategori

Susunan folder di zip ini sama dengan susunan project Laravel. Salin ke project.

## 1. File baru (salin apa adanya)

| File | Fungsi |
|---|---|
| `config/site.php` | `public_root` (path folder publik, dipakai produksi) |
| `app/Support/Asset.php` | URL aset dengan `?v=` dari waktu ubah file |
| `app/Support/SiteCache.php` | Peta cache: nama kunci + kunci yang dihapus per data |
| `app/Observers/CategoryObserver.php` | Menghapus cache saat kategori berubah |
| `resources/views/layouts/admin.blade.php` | Layout semua halaman admin baru |
| `resources/views/admin/partials/sidebar.blade.php` | Menu (link asli, aktif otomatis) |
| `resources/views/admin/partials/pagination.blade.php` | Pagination gaya admin |
| `resources/views/admin/categories/index.blade.php` | Halaman Kategori + modal |
| `resources/views/admin/dashboard/index.blade.php` | Halaman Dashboard |
| `public/assets/js/admin/common.js` | CSRF, request, flash toast, sidebar, logout |
| `public/assets/js/admin/categories.js` | Modal tambah/ubah/hapus Kategori |

## 2. File yang diganti

`app/Http/Controllers/Admin/CategoryController.php`
`app/Http/Controllers/Admin/DashboardController.php` (method `getData` diganti `index`)

## 3. Dua perubahan kecil

**routes/web.php**, di grup admin, ganti route daftar kategori:

```php
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('admin.categories.index');
```

Route `show`, `store`, `update`, `destroy` tidak berubah.

Dashboard, ganti route lama `/dashboard`:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
```

**app/Providers/AppServiceProvider.php**, di `boot()`:

```php
\App\Models\Category::observe(\App\Observers\CategoryObserver::class);
```

## 4. Produksi (.env)

```
PUBLIC_ROOT=/home/aisy8672/public_html
```

Lokal dikosongkan. Setelah mengubah .env di produksi: `php artisan config:clear`
(atau `config:cache` bila memang dipakai).

## 5. Yang tetap memakai file lama

`assets/js/13-utils.js` dipakai apa adanya. File `00`-`12` dan admin lama
tidak disentuh. `GET /admin/categories` tetap membalas JSON bila diminta JSON
(admin lama), dan menampilkan halaman bila dibuka dari browser.

## 6. Kontrak cache untuk sisi guest

Sisi guest wajib memakai nama kunci dari `SiteCache`, misalnya:

```php
Cache::rememberForever(SiteCache::CATEGORIES, fn () => Category::orderBy('name')->get());
```

Kalau nama kunci berbeda, `Cache::forget` dari admin tidak akan menghapusnya.
Daftar lengkap ada di `SiteCache::MAP`.

## 7. Perubahan perilaku

- Kategori yang masih dipakai produk **tidak bisa dihapus** (pesan 422).
- `id` tidak lagi diisi manual di `store` (sudah dibuat otomatis oleh `HasUuids`).
- Tabel daftar menampilkan deskripsi sebagai teks polos (HTML editor dibuang).
- Pencarian memakai Enter (bukan langsung saat mengetik).

## 8. Cek setelah dipasang

1. Buka `/admin/categories`: daftar muncul tanpa loading.
2. Tambah kategori: halaman reload ke halaman 1, toast tampil.
3. Edit: modal terisi, simpan, halaman tetap di halaman yang sama.
4. Cari nama, pindah halaman: `?search=` dan `?page=` ikut terbawa.
5. Hapus kategori berisi produk: muncul pesan penolakan.
6. Hapus satu-satunya data di halaman 2: otomatis kembali ke halaman 1.
7. Buka `/admin` (admin lama): bagian Kategori di sana masih jalan.
8. Logout dari halaman baru.

## 9. Dashboard

- Angka statistik memakai `Cache::remember(SiteCache::STATS, 600, ...)` (10 menit).
- Cache dihapus otomatis saat kategori berubah. Untuk produk, inquiry, dan
  proses, penghapusan otomatis menyusul saat modulnya dipindahkan; sebelum itu
  angka menyesuaikan sendiri paling lama 10 menit.
- Admin lama tetap mendapat JSON dari `GET /admin/dashboard`.
- Link Dashboard di sidebar otomatis mengarah ke `/admin/dashboard` setelah route diberi nama.
