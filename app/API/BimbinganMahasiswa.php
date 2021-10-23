<?php

namespace App\API;

/**
 * Bimbingan Mahasiswa
 */
trait BimbinganMahasiswa
{
    public static function getBimbinganMahasiswa($request)
    {
        return self::get(`/bimbingan_mahasiswa`, [
            "id_sdm" => $request->id_sdm,
            "id_semester" => $request->id_semester
        ]);
    }

    public static function getBimbinganMahasiswaID($id_aktivitas_mahasiswa)
    {
        return self::get(`/bimbingan_mahasiswa/$id_aktivitas_mahasiswa`);
    }

    public static function putBimbinganMahasiswa($request)
    {
        return self::put(`/bimbingan_mahasiswa/$request->id_aktivitas_mahasiswa/bidang_ilmu`, [
            $request->id_kelompok_bidang
        ]);
    }

    public static function getBimbinganMahasiswaBidang($id_aktivitas_mahasiswa)
    {
        return self::get(`/bimbingan_mahasiswa/$id_aktivitas_mahasiswa/bidang_ilmu`);
    }
}
