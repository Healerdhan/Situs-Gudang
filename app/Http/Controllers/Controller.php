<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Yajra\DataTables\Facades\DataTables;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    public function response(array $data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $data['code']);
    }

    public function filterResponse(array $data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, 200);
    }

    public function datatable(?array $response, bool $withAction = true): \Illuminate\Http\JsonResponse
    {
        $datatable = DataTables::of($response['data'])
            ->addIndexColumn()
            ->setTotalRecords($response['total_data'])
            ->setFilteredRecords($response['total_data'])
            ->skipPaging();

        if ($withAction) {
            $datatable->addColumn('action', function ($row) {
                if (isset($row['view'])) {
                    return view($row['view'], $row);
                }
            });
        }

        return $datatable->make(true);
    }
}
