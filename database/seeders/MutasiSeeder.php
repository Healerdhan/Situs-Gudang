<?php

namespace Database\Seeders;

use App\Models\Mutasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mutasi::factory()->count(5)->create();
    }
}
