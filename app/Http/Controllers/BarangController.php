<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Services\Barang\Interfaces\BarangServiceInterface;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    protected $barangService;

    public function __construct(BarangServiceInterface $barangService)
    {
        $this->barangService = $barangService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->barangService->getAllBarang());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->barangService->createBarang($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->barangService->getBarangById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->barangService->updateBarang($request, $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->barangService->deleteBarang($id));
    }
}
