<?php

namespace App\Services\Barang\Interfaces;

use Illuminate\Http\Request;

interface BarangServiceInterface
{
  public function getAllBarang(): array;
  public function getBarangById(string $id): array;
  public function createBarang(Request $request): array;
  public function updateBarang(Request $request, string $id): array;
  public function deleteBarang(string $id): array;
}
