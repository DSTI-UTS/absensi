# APP

- iseed before migrate:rollback
- php artisan optimize:clear
- php artisan config:clear

## Sedang dikerjakan

- [ ] Laporan mata kuliah
- [ ] jika telat maka wajib isi detail (opsional attachment)
- [ ] izin 1/5 hari
- [ ] izin 1 hari

## Databases

- php artisan iseed human_resources,structures,structural_positions,classesy,subjects,meetings,presences

## Tools

- [Bootstrap form builder](https://startbootstrap.com/sb-form-builder)

## Tutorial

- [Laravel permission](https://imansugirman.com/menggunakan-laravel-permission-dari-spatie)
  http://forum.centos-webpanel.com/index.php?topic=10177.0

STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION

## TIPS

- Validasi valid URL from server (bukan ketikan)

```
return URL::temporarySignedRoute(
    'download.sub-lecturer',
    now()->addMinutes(5),
    ['query', request()->getQueryString()]
);
use Illuminate\Support\Facades\URL;

if (URL::hasValidSignature($request)) {
  // URL asli dan belum kadaluarsa
} else {
  // URL tidak asli atau telah kadaluarsa
}
```
