<?php

namespace Modules\Pkl\Jobs;

use App\Models\TempSiswa;
use App\Models\Tingkat;
use App\Models\Upload_siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessSiswaUploade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $upload;

    /**
     * Create a new job instance.
     */
    public function __construct(Upload_siswa $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->upload->update([
            'status' => 'processing',
            'processing_started_at' => now()
        ]);

        try {
            $errors = []; // Array untuk menyimpan semua error
            $rowCount = 0;

            // Ambil file dari MinIO/S3
            $filePath = $this->upload->path . $this->upload->filename;
            $extension = pathinfo($this->upload->original_name, PATHINFO_EXTENSION);

            // Buat file sementara di server
            $tempFile = tempnam(sys_get_temp_dir(), 'excel_') . '.' . $extension;
            file_put_contents($tempFile, Storage::disk('s3')->get($filePath));

            // Buka file dengan PhpSpreadsheet
            $spreadsheet = IOFactory::load($tempFile);
            $sheet = $spreadsheet->getActiveSheet();
            $dataRows = $sheet->toArray();

            // Gunakan Database Transaction
            DB::beginTransaction();
            foreach ($dataRows as $index => $row) {
                if ($index == 0) continue; // Lewati header

                try {
                    // Validasi data sebelum insert
                    if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                        throw new \Exception("Data tidak lengkap pada baris ke-" . ($index + 1));
                    }

                    $tingkat_id = $row[3] ?? null;
                    $getTingkat = Tingkat::find($tingkat_id);

                    // Insert ke TempSiswa
                    TempSiswa::create([
                        'upload_siswa_id' => $this->upload->id, // Pastikan field ini sesuai
                        'nis' => $row[1] ?? null,
                        'nama' => $row[2] ?? null,
                        'tingkat_id' => $tingkat_id,
                        'romawi' => $getTingkat->romawi,
                        'jurusan_id' => $this->upload->jurusan_id,
                        'tahun_akademik' => $this->upload->tahun_akademik,
                    ]);

                    $rowCount++;
                } catch (\Exception $e) {
                    if ($e->getCode() == 23000) { // Kode 23000 untuk constraint violation
                        $errors[] = [
                            'baris' => $index,
                            'diskripsi' => "Baris ke-" . ($index + 1) . ": NIS sudah digunakan " . $row[1]
                        ];
                    } elseif (strpos($e->getMessage(), 'tingkat_id') !== false) {
                        $errors[] = [
                            'baris' => $index,
                            'diskripsi' => "Baris ke-" . ($index + 1) . ": Tingkat wajjib di isi dan sesuai dengan data " . $row[1]
                        ];
                    } else {
                        $errors[] = [
                            'baris' => $index,
                            'diskripsi' => "Baris ke-" . ($index + 1) . ": NIS sudah digunakan " . $e->getMessage()
                        ];
                    }
                }
            }

            // Jika ada error, rollback transaksi
            if (!empty($errors)) {
                DB::rollBack();
                $this->upload->update([
                    'status' => 'failed',
                    // 'errors' => implode("\n", $errors),
                    'errors' => json_encode($errors),
                    'processing_completed_at' => now()
                ]);
                return;
            }

            // Jika tidak ada error, commit transaksi
            DB::commit();

            // Update jumlah siswa dan status berhasil
            $this->upload->update([
                'row_count' => $rowCount,
                'status' => 'completed',
                'processing_completed_at' => now()
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error besar
            DB::rollBack();
            Log::error("Proses upload siswa gagal: " . $e->getMessage());

            // Simpan error ke database
            $this->upload->update([
                'status' => 'failed',
                'errors' => $e->getMessage(),
                'processing_completed_at' => now()
            ]);
        }
    }
}
