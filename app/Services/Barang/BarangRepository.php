<?php

namespace App\Services\Barang;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Models\Barang;
use App\Services\Barang\Dto\BarangDto;
use App\Services\Barang\Dto\CreateBarangDto;
use App\Services\Barang\Dto\UpdateBarangDto;
use App\Services\Barang\Interfaces\BarangRepositoryInterface;
use App\Traits\PaginationResponse;
use App\Traits\RequestFilter;
use App\Traits\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;

class BarangRepository implements BarangRepositoryInterface
{
  use ResponseFormatter, PaginationResponse, RequestFilter;
  protected $barang;

  public function __construct(Barang $barang)
  {
    $this->barang = $barang;
  }

  public function getAllBarang(): array
  {
    try {
      $query = $this->barang->when($this->getCari(), function ($query, $cari) {
        return $query->where('nama_barang', 'like', '%' . $cari . '%')
          ->orWhere('kategori', 'like', '%' . $cari . '%');
      });

      $data = $this->paginate($query, $this->getLimit(), $this->getPage())->getQueryData();
      $response = array();

      foreach ($data as $barang) {
        $response[] = BarangDto::fromData($barang)->toArray();
      }

      return $this->setArray($response)->toArray(Code::SUCCESS, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getBarangById(string $id): array
  {
    try {
      $query = Barang::find($id);
      if (!$query) {
        throw new Error(404, 'Not Found');
      }
      $barangDto = BarangDto::fromData((object) $query->toArray());
      return $this->success(Code::SUCCESS, $barangDto->toArray(), Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function createBarang(CreateBarangDto $data): array
  {
    try {
      $barang = $data->toArray();
      $newBarang = Barang::create($barang);
      return $this->success(Code::SUCCESS, $newBarang->toArray(), Message::success);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function updateBarang(string $id, UpdateBarangDto $data): array
  {
    try {
      $barang = Barang::findOrFail($id);
      $barang->update($data->toArray());
      return $this->success(Code::SUCCESS, $barang->toArray(), Message::success);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function deleteBarang(string $id): array
  {
    try {
      $barang = $this->barang->where('id', $id)->delete();
      if (!$barang) {
        throw new Error(Code::NOT_FOUND, Message::errorDelete);
      }
      return $this->success(Code::SUCCESS, [], Message::successDelete);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }
}
