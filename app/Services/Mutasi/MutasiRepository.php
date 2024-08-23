<?php

namespace App\Services\Mutasi;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Models\Mutasi;
use App\Services\Mutasi\Dto\CreateMutasiDto;
use App\Services\Mutasi\Dto\MutasiDto;
use App\Services\Mutasi\Dto\UpdateMutasiDto;
use App\Services\Mutasi\Interfaces\MutasiRepositoryInterface;
use App\Traits\PaginationResponse;
use App\Traits\RequestFilter;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;

class MutasiRepository implements MutasiRepositoryInterface
{
  use ResponseFormatter, PaginationResponse, RequestFilter;
  protected $mutasi;

  public function __construct(Mutasi $mutasi)
  {
    $this->mutasi = $mutasi;
  }

  public function getAllMutasi(): array
  {
    try {
      $query = $this->mutasi->when($this->getCari(), function ($query, $cari) {
        return $query->where('jenis_mutasi', 'like', '%' . $cari . '%');
      });

      $data = $this->paginate($query, $this->getLimit(), $this->getPage())->getQueryData();
      $response = array();

      foreach ($data as $mutasi) {
        $response[] = MutasiDto::fromData($mutasi)->toArray();
      }

      return $this->setArray($response)->toArray(Code::SUCCESS, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getMutasiById(int $id): array
  {
    try {
      $query = Mutasi::findOrFail($id);
      if (!$query) {
        throw new Error(404, 'Not Found');
      }
      $mutasi = MutasiDto::fromData((object) $query->toArray());
      return $this->success(Code::SUCCESS, $mutasi->toArray(), Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function createMutasi(CreateMutasiDto $data): array
  {
    try {
      $mutasi = $data->toArray();
      $newMutasi = Mutasi::create($mutasi);
      return $this->success(Code::SUCCESS, $newMutasi->toArray(), Message::success);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function updateMutasi(int $id, UpdateMutasiDto $data): array
  {
    try {
      $mutasi = Mutasi::findOrFail($id);
      if (!$mutasi) {
        throw new Error(404, 'Not Found');
      }
      $mutasi->update($data->toArray());
      return $this->success(Code::SUCCESS, $mutasi->toArray(), Message::success);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function deleteMutasi(int $id): array
  {
    try {
      $mutasi = $this->mutasi->where('id', $id)->delete();
      if (!$mutasi) {
        throw new Error(Code::NOT_FOUND, Message::errorDelete);
      }

      return $this->success(Code::SUCCESS, $mutasi, Message::success);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getMutasiHistoryByUserId(int $userId): array
  {
    try {
      $query = $this->mutasi->where('user_id', $userId);
      $query = $query->when(request('cari'), function ($query, $cari) {
        return $query->where('jenis_mutasi', 'like', '%' . $cari . '%');
      });

      $mutasiHistory = $query->paginate(10);

      return $this->success(Code::SUCCESS, $mutasiHistory->toArray(), Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getMutasiHistoryByBarangId(string $barangId): array
  {
    try {
      $query = $this->mutasi->where('barang_id', $barangId);

      $query = $query->when(request('cari'), function ($query, $cari) {
        return $query->where('jenis_mutasi', 'like', '%' . $cari . '%');
      });

      $mutasiHistory = $query->paginate(10);

      return $this->success(Code::SUCCESS, $mutasiHistory->toArray(), Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }
}
