<?php

namespace App\Services\BarangHistory\Interfaces;

use App\Services\BarangHistory\Dto\CreateBarangHistoryDto;

interface BarangHistoryRepositoryInterface
{
  public function getAllHistories(): array;
  public function getHistoryById(string $id): array;
  public function createHistory(CreateBarangHistoryDto $data): array;
  public function getHistoriesByBarangId(string $barangId): array;
}
