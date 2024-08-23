<?php

namespace App\Services\Barang\Interfaces;

use App\Services\Barang\Dto\CreateBarangDto;
use App\Services\Barang\Dto\UpdateBarangDto;

interface BarangRepositoryInterface
{
  public function getAllBarang(): array;
  public function getBarangById(string $id): array;
  public function createBarang(CreateBarangDto $data): array;
  public function updateBarang(string $id, UpdateBarangDto $data): array;
  public function deleteBarang(string $id): array;
}
