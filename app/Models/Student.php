<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property string $student_id
 * @property string|null $nama_lengkap
 * @property string|null $gender
 * @property string|null $tempat_tanggal_lahir
 * @property string|null $nim
 * @property string|null $password
 * @property string|null $nik
 * @property string|null $program_studi_id
 * @property string|null $sesi_kuliah
 * @property string|null $periode_masuk
 * @property string|null $angkatan
 * @property string|null $no_tes
 * @property string|null $status_masuk
 * @property string|null $jalur_masuk
 * @property string|null $tanggal_daftar
 * @property string|null $gelombang_pendaftaran
 * @property string|null $status_akademik
 * @property string|null $status_mahasiswa
 * @property string|null $agama
 * @property string|null $status_nikah
 * @property string|null $kewarganegaraan
 * @property string|null $status_domisili
 * @property string|null $alamat
 * @property string|null $kelurahan
 * @property string|null $kecamatan
 * @property string|null $kota_tinggal
 * @property string|null $kode_pos
 * @property string|null $negara
 * @property string|null $no_telp
 * @property string|null $no_hp
 * @property string|null $email
 * @property string|null $hubungan_biaya
 * @property string|null $sumber_dana_beasiswa
 * @property string|null $jumlah_saudara
 * @property string|null $jumlah_saudara_laki
 * @property string|null $jumlah_saudara_perempuan
 * @property string|null $status_bekerja
 * @property string|null $pekerjaan
 * @property string|null $institusi_kantor
 * @property string|null $jabatan
 * @property string|null $alamat_institusi_kantor
 * @property string|null $no_asuransi
 * @property string|null $hoby
 * @property string|null $tahu_kampus_ini_dari
 * @property string|null $nim_lama
 * @property string|null $pt_asal
 * @property string|null $tahun_masuk_pt_asal
 * @property string|null $nama_ayah
 * @property string|null $tanggal_lahir_ayah
 * @property string|null $status_ayah
 * @property string|null $tanggal_meniggal_ayah
 * @property string|null $pendidikan_ayah
 * @property string|null $pendidikan_terakhir_ayah
 * @property string|null $pekerjaan_ayah
 * @property string|null $nama_ibu
 * @property string|null $tanggal_lahir_ibu
 * @property string|null $status_ibu
 * @property string|null $tanggal_meninggal_ibu
 * @property string $created_at
 * @property string $updated_at
 * @property-read \App\Models\StudentDetail|null $detail
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAlamatInstitusiKantor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAngkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGelombangPendaftaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereHoby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereHubunganBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereInstitusiKantor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereJalurMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereJumlahSaudara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereJumlahSaudaraLaki($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereJumlahSaudaraPerempuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereKelurahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereKewarganegaraan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereKodePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereKotaTinggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNamaAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNamaIbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNegara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNimLama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNoAsuransi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNoTes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePekerjaanAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePendidikanAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePendidikanTerakhirAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePeriodeMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereProgramStudiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePtAsal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSesiKuliah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusAkademik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusBekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusDomisili($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusIbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusMahasiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStatusNikah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSumberDanaBeasiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTahuKampusIniDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTahunMasukPtAsal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTanggalDaftar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTanggalLahirAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTanggalLahirIbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTanggalMeniggalAyah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTanggalMeninggalIbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTempatTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Student withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $fillable = [
        'student_id',
        'nama_lengkap',
        'gender',
        'tempat_tanggal_lahir',
        'nim',
        'password',
        'nik',
        'program_studi_id',
        'sesi_kuliah',
        'periode_masuk',
        'angkatan',
        'no_tes',
        'status_masuk',
        'jalur_masuk',
        'tanggal_daftar',
        'gelombang_pendaftaran',
        'status_akademik',
        'status_mahasiswa',
        'agama',
        'status_nikah',
        'kewarganegaraan',
        'status_domisili',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_tinggal',
        'kode_pos',
        'negara',
        'no_telp',
        'no_hp',
        'email',
        'hubungan_biaya',
        'sumber_dana_beasiswa',
        'jumlah_saudara',
        'jumlah_saudara_laki',
        'jumlah_saudara_perempuan',
        'status_bekerja',
        'pekerjaan',
        'institusi_kantor',
        'jabatan',
        'alamat_institusi_kantor',
        'no_asuransi',
        'hoby',
        'tahu_kampus_ini_dari',
        'nim_lama',
        'pt_asal',
        'tahun_masuk_pt_asal',
        'nama_ayah',
        'tanggal_lahir_ayah',
        'status_ayah',
        'tanggal_meniggal_ayah',
        'pendidikan_ayah',
        'pendidikan_terakhir_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'tanggal_lahir_ibu',
        'status_ibu',
        'tanggal_meninggal_ibu',
    ];

    public $timestamps = false;

    public function genId($nim)
    {
        $nim = preg_replace('/\D/', '', $nim);
        $random = rand(10000000, 99999999);
        $random = str_pad($random, 8, "0", STR_PAD_LEFT);
        $uniqid = hash('md5', $nim . $random);
        $string = str_replace('-', '', $uniqid);
        $parts = [
            substr($string, 0, 8),
            substr($string, 8, 4),
            substr($string, 12, 4),
            substr($string, 16, 4),
            substr($string, 20, 12)
        ];
        return implode('-', $parts);
    }

    public function detail()
    {
        return $this->hasOne(StudentDetail::class, 'student_id', 'student_id');
    }
}
