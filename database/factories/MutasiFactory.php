<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mutasi>
 */
class MutasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $barang = Barang::inRandomOrder()->first();
        $barangId = $barang ? $barang->id : null;

        return [
            'tanggal' => $this->faker->date(),
            'jenis_mutasi' => $this->faker->word,
            'jumlah' => $this->faker->numberBetween(1, 100),
            'user_id' => User::inRandomOrder()->first()->id,
            'barang_id' => $barangId
        ];
    }
}
