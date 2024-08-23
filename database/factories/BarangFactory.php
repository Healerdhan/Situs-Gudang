<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'nama_barang' => $this->faker->word,
            'kode' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            'kategori' => $this->faker->word,
            'lokasi' => $this->faker->word,
        ];
    }
}
