<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $entity;

    public function __construct(Category $category)
    {
        $this->entity = $category;
    }

    public function getCategoriesByTenantUuid(string $uuid)
    {
        return $this->entity
            ->join('tenants', 'tenants.id', '=', 'categories.tenant_id')
            ->where('tenants.uuid', $uuid)
            ->select('categories.*')
            ->get();
    }

    public function getCategoriesByTenantId(int $tenantId)
    {
        return $this->entity->where('tenant_id', $tenantId)->get();
    }

    public function getCategoryByUrl(string $url)
    {
        return $this->entity->where('url', $url)->get();
    }

}
