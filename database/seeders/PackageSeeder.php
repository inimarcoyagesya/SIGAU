<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Package::create([
        'name' => 'Paket Bulanan',
        'description' => 'Berlangganan 1 bulan',
        'price' => 30000,
        'duration' => 30,
        'features' => json_encode(['fitur1', 'fitur2']),
    ]);
}
}
