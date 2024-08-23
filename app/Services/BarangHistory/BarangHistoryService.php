<?php

namespace App\Services\BarangHistory;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Services\BarangHistory\Dto\CreateBarangHistoryDto;
use App\Services\BarangHistory\Interfaces\BarangHistoryRepositoryInterface;
use App\Services\BarangHistory\Interfaces\BarangHistoryServiceInterface;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangHistoryService implements BarangHistoryServiceInterface
{
    use ResponseFormatter;
    protected $baranghistoryRepository;

    public function __construct(BarangHistoryRepositoryInterface $baranghistoryRepository)
    {
        $this->baranghistoryRepository = $baranghistoryRepository;
    }


    public function getAllHistories(): array
    {
        try {
            $response = $this->baranghistoryRepository->getAllHistories();
            if (!$response['success']) {
                throw new Error($response['code'], $response['message'], $response['error']);
            }

            return $this->paginateResponse(Code::SUCCESS, $response, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }


    public function getHistoryById(string $id): array
    {
        try {
            $response = $this->baranghistoryRepository->getHistoryById($id);
            if ($response['code'] === Code::NOT_FOUND) {
                return $this->success($response['code'], $response['data'], $response['message']);
            }

            return $this->success(Code::SUCCESS, $response['data'], Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }


    public function createHistory(Request $request): array
    {
        DB::beginTransaction();
        try {
            $history = new CreateBarangHistoryDto(
                $request->input('barang_id'),
                $request->input('change_description'),
                $request->input('changed_at'),
                $request->input('changed_by'),
            );
            $history->validate();
            if (!$history) {
                throw new Error(401, 'Unauthorized');
            }

            $newHistory = $this->baranghistoryRepository->createHistory($history);
            if (!$newHistory) {
                throw new Error(422, "Failed to create new Barang");
            }
            DB::commit();
            return $this->success(Code::SUCCESS, $newHistory, Message::successCreate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function getHistoriesByBarangId(string $barangId): array
    {
        try {
            $response = $this->baranghistoryRepository->getHistoriesByBarangId($barangId);
            if (!$response['success']) {
                throw new Error($response['code'], $response['message'], $response['error']);
            }

            return $this->paginateResponse(Code::SUCCESS, $response, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }
}
