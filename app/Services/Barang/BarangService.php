<?php

namespace App\Services\Barang;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Models\Barang;
use App\Services\Barang\Dto\CreateBarangDto;
use App\Services\Barang\Dto\UpdateBarangDto;
use App\Services\Barang\Interfaces\BarangRepositoryInterface;
use App\Services\Barang\Interfaces\BarangServiceInterface;
use App\Traits\ResponseFormatter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangService implements BarangServiceInterface
{
    use ResponseFormatter;
    protected $barangRepository;

    public function __construct(BarangRepositoryInterface $barangRepository)
    {
        $this->barangRepository = $barangRepository;
    }

    public function getAllBarang(): array
    {
        try {
            $response = $this->barangRepository->getAllBarang();
            if (!$response['success']) {
                throw new Error($response['code'], $response['message'], $response['error']);
            }

            return $this->paginateResponse(Code::SUCCESS, $response, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }

    public function getBarangById(string $id): array
    {
        try {
            $response = $this->barangRepository->getBarangById($id);
            if ($response['code'] === Code::NOT_FOUND) {
                return $this->success($response['code'], $response['data'], $response['message']);
            }

            return $this->success(Code::SUCCESS, $response['data'], Message::successGet);
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function createBarang(Request $request): array
    {
        DB::beginTransaction();
        try {
            $barang = new CreateBarangDto(
                $request->input('nama_barang'),
                $request->input('kode'),
                $request->input('kategori'),
                $request->input('lokasi'),
            );
            $barang->validate();
            if (!$barang) {
                throw new Error(401, 'Unauthorized');
            }

            $newBarang = $this->barangRepository->createBarang($barang);
            if (!$newBarang) {
                throw new Error(422, "Failed to create new Barang");
            }
            DB::commit();
            return $this->success(Code::SUCCESS, $newBarang, Message::successCreate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function updateBarang(Request $request, string $id): array
    {
        DB::beginTransaction();
        try {
            $barang = new UpdateBarangDto(
                $request->input('id'),
                $request->input('nama_barang'),
                $request->input('kode'),
                $request->input('kategori'),
                $request->input('lokasi'),
            );
            $barang->validate();
            if (!$barang->isValid()) {
                throw new Error($barang->getCode(), $barang->getError());
            }
            $updatedBarang = $this->barangRepository->updateBarang($id, $barang);
            if (!$updatedBarang) {
                throw new Error(422, "Failed to update Barang");
            }
            DB::commit();
            return $this->success(Code::SUCCESS, $updatedBarang, Message::successUpdate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function deleteBarang(string $id): array
    {
        DB::beginTransaction();
        try {
            $deletedBarang = $this->barangRepository->deleteBarang($id);
            if (!$deletedBarang['success']) {
                throw new Error($deletedBarang['code'], $deletedBarang['message'], $deletedBarang['error']);
            }
            DB::commit();
            return $this->success(Code::SUCCESS, $deletedBarang, Message::successDelete);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }
}
