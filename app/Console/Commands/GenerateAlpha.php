<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class GenerateAlpha extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'alpha:generate';

    /**
     * Deskripsi command
     */
    protected $description = 'Generate Alpha otomatis untuk siswa yang tidak melakukan presensi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::parse('2026-08-02');

        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        if (!$tahunAjaran) {

            $this->error('Tidak ada Tahun Ajaran aktif.');

            return Command::FAILURE;
        }

        $siswas = Siswa::where('aktif', true)->get();

        $jumlahAlpha = 0;

        foreach ($siswas as $siswa) {

            $sudahPresensi = Presensi::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if ($sudahPresensi) {
                continue;
            }

            Presensi::create([

                'siswa_id'        => $siswa->id,
                'guru_id'         => 1,
                'scanner_id'      => 1,
                'scan_by'         => 'admin',
                'tahun_ajaran_id' => $tahunAjaran->id,
                'tanggal'         => $today,
                'jam_scan'        => '23:59:59',
                'status'          => 'Alpha',
                'metode'          => 'Manual',
                'keterangan'      => 'Alpha otomatis oleh sistem',
                'device_name'     => 'System Scheduler',

            ]);

            $jumlahAlpha++;
        }

        $this->info("Berhasil membuat {$jumlahAlpha} data Alpha.");

        return Command::SUCCESS;
    }
}