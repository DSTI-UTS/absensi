-   iseed before migrate:rollback
-   php artisan optimize:clear
-   php artisan config:clear

# APP

-   faculty and study program is just home base detail in profile
-   structure is the main key for indexing supervisor and subordinate

## Flowcart presensi pengajaran

-   Civitas UTS login
-   pilih presensi pengajaran
-   pilih mata kuliah
-   pilih kelas
-   pilih pertemuan ke-n
-   lalu input foto mulai
-   lalu input foro selesai
-   selesai

## Update

-   Setelah kelas selesai, generate link untuk mahasiswa untuk isi kehadiran dan data aduan
-   absen 1x saja
-   filter semester

## Tools

-   [Bootstrap form builder](https://startbootstrap.com/sb-form-builder)

## Tutorial

-   [Laravel permission](https://imansugirman.com/menggunakan-laravel-permission-dari-spatie)

### List problem

-   Cannot create relationship => make sure the order list and time is ASC
-   Sepertinya append admin fakultas dan prodi bisa dihalaman list masing-masings
-   Kalau pakai strucrure_id bisa didapat semua structure dibawahnya
    -- misal kaprodi -> semua dosen atau staff dibawahnya
    -- jika ingin dibagi maka lakukan grouping sdm_type
    -- jika dosen maka tampilkan hasil pengajaran
    -- jika jika tidak dosen maka ambil semua absen kehadiran
