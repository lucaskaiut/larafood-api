<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TableFormRequest;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\TableResource;
use App\Models\Tenant;
use App\Services\TableService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $service)
    {
        $this->tableService = $service;
    }

    public function getTablesByTenantUuid(TenantFormRequest $request)
    {
        $tables = $this->tableService->getTablesByTenantUuid($request->company_token);

        return TableResource::collection($tables);
    }

    public function show(TableFormRequest $request)
    {
        $table = $this->tableService->getTableByUuid($request->uuid);

        return TableResource::collection($table);
    }
}
