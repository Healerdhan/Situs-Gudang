<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Services\Mutasi\Interfaces\MutasiServiceInterface;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    protected $mutasiService;

    public function __construct(MutasiServiceInterface $mutasiService)
    {
        $this->mutasiService = $mutasiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->getAllMutasi());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->createMutasi($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->getMutasiById($id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->updateMutasi($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->deleteMutasi($id));
    }

    public function getMutasiHistoryByUserId(int $userId): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->getMutasiHistoryByUserId($userId));
    }

    public function getMutasiHistoryByBarangId(string $barangId): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->mutasiService->getMutasiHistoryByBarangId($barangId));
    }
}
