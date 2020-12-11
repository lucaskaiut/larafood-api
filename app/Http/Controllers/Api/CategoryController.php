<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryFormRequest;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategoriesByTenant(TenantFormRequest $request)
    {
        $categories = $this->categoryService->getCategoriesByTenantUuid($request->company_token);

        return CategoryResource::collection($categories);
    }

    public function show(CategoryFormRequest $request)
    {
        return new CategoryResource($this->categoryService->getCategoryByUrl($request->url));
    }
}
