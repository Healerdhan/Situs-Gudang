<?php

namespace App\Services\BarangHistory;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Models\BarangHistory;
use App\Services\BarangHistory\Dto\BarangHistoryDto;
use App\Services\BarangHistory\Dto\CreateBarangHistoryDto;
use App\Services\BarangHistory\Interfaces\BarangHistoryRepositoryInterface;
use App\Traits\PaginationResponse;
use App\Traits\RequestFilter;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;

class BarangHistoryRepository implements BarangHistoryRepositoryInterface
{
  use ResponseFormatter, PaginationResponse, RequestFilter;
  protected $barangHistory;

  public function __construct(BarangHistory $barangHistory)
  {
    return $this->barangHistory = $barangHistory;
  }

  public function getAllHistories(): array
  {
    try {
      $query = $this->barangHistory
        ->join('barangs', 'barang_histories.barang_id', '=', 'barangs.id')
        ->select('barang_histories.*', 'barangs.nama_barang')
        ->when($this->getCari(), function ($query, $cari) {
          return $query->where('barang_histories.changed_by', 'like', '%' . $cari . '%');
        })
        ->when($this->getBarangId(), function ($query, $barangId) {
          return $query->where('barang_histories.barang_id', $barangId);
        });

      $data = $this->paginate($query, $this->getLimit(), $this->getPage())->getQueryData();
      $response = array();

      foreach ($data as $histoy) {
        $response[] = BarangHistoryDto::fromData($histoy)->toArray();
      }

      return $this->setArray($response)->toArray(Code::SUCCESS, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getHistoryById(string $id): array
  {
    try {
      $query = BarangHistory::with('barang')
        ->leftJoin('barangs', 'barang_histories.barang_id', '=', 'barangs.id')
        ->select('barang_histories.*', 'barangs.nama_barang')
        ->where('barang_histories.id', $id)
        ->firstOrFail();
      if (!$query) {
        throw new Error(404, 'Not Found');
      }
      $response = BarangHistoryDto::fromData($query)->toArray();
      return $this->success(Code::SUCCESS, $response, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function createHistory(CreateBarangHistoryDto $data): array
  {
    try {
      $history = $data->toArray();
      $newHistory = BarangHistory::create($history);
      $response = BarangHistoryDto::fromData($newHistory)->toArray();
      return $this->success(Code::SUCCESS, $response, Message::successCreate);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getHistoriesByBarangId(string $barangId): array
  {
    try {
      $query = $this->barangHistory->where('barang_id', $barangId);

      $query = $query->when($this->getCari(), function ($query, $cari) {
        return $query->where('changed_by', 'like', '%' . $cari . '%');
      });

      $data = $this->paginate($query, $this->getLimit(), $this->getPage())->getQueryData();
      $response = array();

      foreach ($data as $history) {
        $response[] = BarangHistoryDto::fromData($history)->toArray();
      }

      return $this->setArray($response)->toArray(Code::SUCCESS, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }
}
