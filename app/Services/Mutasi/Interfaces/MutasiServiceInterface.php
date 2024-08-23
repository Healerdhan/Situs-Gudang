<?php

namespace App\Services\Mutasi\Interfaces;

use Illuminate\Http\Request;

interface MutasiServiceInterface
{
  public function getAllMutasi(): array;
  public function getMutasiById(int $id): array;
  public function createMutasi(Request $request): array;
  public function updateMutasi(Request $request, int $id): array;
  public function deleteMutasi(int $id): array;
  public function getMutasiHistoryByUserId(int $userId);
  public function getMutasiHistoryByBarangId(string $barangId): array;
}
