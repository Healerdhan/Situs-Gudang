<?php

namespace App\Services\Mutasi\Interfaces;

use App\Services\Mutasi\Dto\CreateMutasiDto;
use App\Services\Mutasi\Dto\UpdateMutasiDto;

interface MutasiRepositoryInterface
{
  public function getAllMutasi(): array;
  public function getMutasiById(int $id): array;
  public function createMutasi(CreateMutasiDto $data): array;
  public function updateMutasi(int $id, UpdateMutasiDto $data): array;
  public function deleteMutasi(int $id): array;
  public function getMutasiHistoryByUserId(int $userId): array;
  public function getMutasiHistoryByBarangId(string $barangId): array;
}
