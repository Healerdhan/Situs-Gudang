<?php

namespace App\Services\BarangHistory\Interfaces;

use Illuminate\Http\Request;

interface BarangHistoryServiceInterface
{
  public function getAllHistories(): array;
  public function getHistoryById(string $id): array;
  public function createHistory(Request $request): array;
  public function getHistoriesByBarangId(string $barangId): array;
}
