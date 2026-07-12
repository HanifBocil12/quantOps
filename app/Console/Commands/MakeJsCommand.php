<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('make:js {name : Nama file JS yang ingin dibuat, contoh: jas atau admin/chart}')]
#[Description('Membuat file JavaScript baru secara otomatis di dalam folder resources/js')]
class MakeJsCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Ambil argumen nama file dari input user
        $name = $this->argument('name');
        
        // 2. Tentukan path lengkap tujuan (resources/js/nama_file.js)
        $path = resource_path("js/{$name}.js");

        // 3. Cek apakah file sudah ada untuk menghindari replace tidak sengaja
        if (File::exists($path)) {
            $this->error("Gagal! File '{$name}.js' sudah ada di folder resources/js.");
            return Command::FAILURE;
        }

        // 4. Buat folder otomatis jika user mengetik sub-folder (contoh: make:js admin/jas)
        $directory = dirname($path);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // 5. Buat file JS kosong dengan komentar template didalamnya
        $template = "// JavaScript File: {$name}.js\n// Created otomatis via Artisan Command\n\n";
        File::put($path, $template);

        $this->info("Sukses! File '{$name}.js' berhasil dibuat.");
        return Command::SUCCESS;
    }
}
