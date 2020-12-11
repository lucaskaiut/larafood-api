<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\TenantResource;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index(Request $request)
    {
        $per_page = $request->get('per_page', 15);

        $tenants = $this->tenantService->getAllTenants($per_page);

        return TenantResource::collection($tenants);
    }

    public function show(TenantFormRequest $request)
    {
        if(!$tenant = $this->tenantService->getTenantByUuid($request->company_token))
            return response()->json(['message' => 'Not Found'], 404);

        return TenantResource::collection($tenant);
    }
}
