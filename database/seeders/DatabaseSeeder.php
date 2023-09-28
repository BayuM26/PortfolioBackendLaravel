<?php

namespace Database\Seeders;

use App\Models\portofolio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $file = file('public/Aplikasi_SPPSekolah.jpg');
        // $imageName = time();
        // $imagePath = public_path(). '/files';

        // $file->move($imagePath, $imageName);
        // $path = Storage::putFile('image', 'public/Aplikasi_SPPSekolah.jpg');
        // // dd($path);
        // portofolio::create([
        //     'portofolioName' => 'APLIKASI PEMBAYARAN SPP',
        //     'imagePortofolio' => $path,
        // ]);
    }
}
