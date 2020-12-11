<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductFormRequest;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function getProductsByTenantUuid(TenantFormRequest $request)
    {
        $products = $this->service->getProductsByTenantUuid($request->company_token, $request->post('categories', []));

        return ProductResource::collection($products);
    }

    public function show(ProductFormRequest $request)
    {
        $product = $this->service->getProductByUrl($request->url);

        return ProductResource::collection($product);
    }
}
