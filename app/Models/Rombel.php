<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rombel extends Model
{
    use HasFactory, SoftDeletes;

    // Daftar kolom yang diizinkan untuk mass-assignment
    protected $fillable = [
        'kode',           // Kode unik untuk rombel
        'label',
        'name',           // Nama rombel
        'walikelas_id',   // ID wali kelas (relasi ke tabel Pegawai)
        'jurusan_id',     // ID jurusan (relasi ke tabel Jurusan)
        'jurusan_name',
        'tingkat_id',     // ID tingkat (relasi ke tabel Tingkat)
        'romawi',
        'kapasitas',      // Kapasitas maksimal siswa dalam rombel
        'tahun_ajaran',   // Tahun ajaran yang terkait dengan rombel
        'tipe',           // Tipe rombel (misalnya reguler, inklusi, dsb.)
        'is_active',      // Status aktif/nonaktif rombel
    ];

    /**
     * Relasi: Rombel memiliki wali kelas.
     * Relasi ini menghubungkan ke model Pegawai berdasarkan kolom walikelas_id.
     */
    public function waliKelas()
    {
        return $this->belongsTo(Pegawai::class, 'walikelas_id');
    }

    /**
     * Relasi: Rombel terkait dengan tingkat pendidikan.
     * Relasi ini menghubungkan ke model Tingkat berdasarkan kolom tingkat_id.
     */
    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'tingkat_id');
    }

    /**
     * Relasi: Rombel terkait dengan jurusan tertentu.
     * Relasi ini menghubungkan ke model Jurusan berdasarkan kolom jurusan_id.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Event model: Booted
     * Event ini dipanggil setiap kali model diinisialisasi.
     * 
     * - Fungsi `saving`: Dijadikan hook saat model akan disimpan (baik saat create maupun update).
     * - Logika: Ketika tingkat_id berubah, kolom `romawi` akan diisi berdasarkan data tingkat terkait.
     */
    protected static function booted()
    {
        static::creating(function ($rombel) {
            do {
                // Generate kode unik dengan format ROM-###
                $rombel->kode = 'ROM-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            } while (self::where('kode', $rombel->kode)->exists()); // Cek duplikasi
        });

        static::saving(function ($rombel) {
            // Ambil data rombel lama sebelum perubahan
            $existingRombel = self::find($rombel->id);
            
            // Periksa jika kolom tingkat_id atau jurusan_id mengalami perubahan
            // Cari data tingkat berdasarkan ID
            $tingkat = Tingkat::findOrFail($rombel->tingkat_id);
            $rombel->romawi = $tingkat->romawi;

            // Jika jurusan_id berubah, update jurusan_name
            $jurusan = Jurusan::findOrFail($rombel->jurusan_id);
            $rombel->jurusan_name = $jurusan->name; // Update jurusan_name
            // Jika label belum diatur, hitung label berdasarkan jumlah rombel yang ada
            if (empty($rombel->label)) {
                // Hitung jumlah rombel yang ada untuk tingkat dan jurusan ini
                $existingRombels = Rombel::where('tingkat_id', $rombel->tingkat_id)
                    ->where('jurusan_id', $rombel->jurusan_id)
                    ->count();

                // Tentukan label berdasarkan jumlah rombel yang sudah ada (A, B, C, dst.)
                $label = chr(65 + $existingRombels); // 65 adalah ASCII 'A'
                $rombel->label = $label;
            }

            // Format nama rombel: Romawi + Jurusan + Label
            $rombel->name = $rombel->romawi . ' ' . $jurusan->kode . ' ' . $rombel->label;
        });
    }

    // private function doSave2(){
    //     static::saving(function ($rombel) {
    //         // Periksa jika kolom tingkat_id atau jurusan_id mengalami perubahan
    //         if ($rombel->isDirty('tingkat_id') || $rombel->isDirty('jurusan_id') || $rombel->isDirty('label')) {
    //             // Cari data tingkat berdasarkan ID
    //             if ($rombel->isDirty('tingkat_id')) {
    //                 $tingkat = Tingkat::findOrFail($rombel->tingkat_id);
    //                 $rombel->romawi = $tingkat->romawi;
    //             }

    //             // Jika jurusan_id berubah, update jurusan_name
    //             if ($rombel->isDirty('jurusan_id')) {
    //                 $jurusan = Jurusan::findOrFail($rombel->jurusan_id);
    //                 $rombel->jurusan_name = $jurusan->name; // Update jurusan_name
    //             }
    //             // Jika label belum diatur, hitung label berdasarkan jumlah rombel yang ada
    //             if (empty($rombel->label)) {
    //                 // Hitung jumlah rombel yang ada untuk tingkat dan jurusan ini
    //                 $existingRombels = Rombel::where('tingkat_id', $rombel->tingkat_id)
    //                     ->where('jurusan_id', $rombel->jurusan_id)
    //                     ->count();

    //                 // Tentukan label berdasarkan jumlah rombel yang sudah ada (A, B, C, dst.)
    //                 $label = chr(65 + $existingRombels); // 65 adalah ASCII 'A'
    //                 $rombel->label = $label;
    //             }

    //             // Format nama rombel: Romawi + Jurusan + Label
    //             $rombel->name = $rombel->romawi . ' ' . $jurusan->kode . ' ' . $rombel->label;
    //         }
    //     });
    // }
}
