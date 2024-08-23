<?php

namespace App\Services\Mutasi;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Services\Mutasi\Dto\CreateMutasiDto;
use App\Services\Mutasi\Dto\MutasiDto;
use App\Services\Mutasi\Dto\UpdateMutasiDto;
use App\Services\Mutasi\Interfaces\MutasiRepositoryInterface;
use App\Services\Mutasi\Interfaces\MutasiServiceInterface;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiService implements MutasiServiceInterface
{
    use ResponseFormatter;
    protected $mutasiRepository;

    public function __construct(MutasiRepositoryInterface $mutasiRepository)
    {
        $this->mutasiRepository = $mutasiRepository;
    }


    public function getAllMutasi(): array
    {
        try {
            $response = $this->mutasiRepository->getAllMutasi();
            if (!$response['success']) {
                throw new Error($response['code'], $response['message'], $response['error']);
            }

            return $this->paginateResponse(Code::SUCCESS, $response, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }


    public function getMutasiById(int $id): array
    {
        try {
            $response = $this->mutasiRepository->getMutasiById($id);
            if (!$response['success']) {
                throw new Error($response['code'], $response['message'], $response['error']);
            }

            return $this->success(Code::SUCCESS, $response['data'], Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }


    public function createMutasi(Request $request): array
    {
        DB::beginTransaction();
        try {
            $mutasi = new CreateMutasiDto(
                $request->input('tanggal'),
                $request->input('jenis_mutasi'),
                $request->input('jumlah'),
                $request->input('user_id'),
                $request->input('barang_id'),
            );
            $mutasi->validate();
            if (!$mutasi) {
                throw new Error(401, 'Unauthorized');
            }

            $newMutasi = $this->mutasiRepository->createMutasi($mutasi);
            if (!$newMutasi) {
                throw new Error(422, "Failed to create new Barang");
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $newMutasi, Message::successCreate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }


    public function updateMutasi(Request $request, int $id): array
    {
        DB::beginTransaction();
        try {
            $mutasi = new UpdateMutasiDto(
                $request->input('tanggal'),
                $request->input('jenis_mutasi'),
                $request->input('jumlah'),
                $request->input('user_id'),
                $request->input('barang_id'),
            );
            $mutasi->validate();
            if (!$mutasi->isValid()) {
                throw new Error($mutasi->getCode(), $mutasi->getError());
            }

            $updatedMutasi = $this->mutasiRepository->updateMutasi($id, $mutasi);
            if (!$updatedMutasi) {
                throw new Error(422, "Failed to update Barang");
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $updatedMutasi, Message::successUpdate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }


    public function deleteMutasi(int $id): array
    {
        DB::beginTransaction();
        try {
            $deletedMutasi = $this->mutasiRepository->deleteMutasi($id);
            if (!$deletedMutasi['success']) {
                throw new Error($deletedMutasi['code'], $deletedMutasi['message'], $deletedMutasi['error']);
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $deletedMutasi, Message::successDelete);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }


    public function getMutasiHistoryByUserId(int $userId)
    {
        try {
            $result = $this->mutasiRepository->getMutasiHistoryByUserId($userId);
            if ($result['code'] === Code::NOT_FOUND) {
                return $this->success($result['code'], $result['data'], $result['message']);
            }

            return $this->success(Code::SUCCESS, $result, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }


    public function getMutasiHistoryByBarangId(string $barangId): array
    {
        try {
            $result = $this->mutasiRepository->getMutasiHistoryByBarangId($barangId);
            if ($result['code'] === Code::NOT_FOUND) {
                return $this->success($result['code'], $result['data'], $result['message']);
            }

            return $this->success(Code::SUCCESS, $result, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }
}
