<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function getCategoriesByTenantUuid(string $uuid);

    public function getCategoriesByTenantId(int $tenantId);

    public function getCategoryByUuid(string $uuid);

    public function getCategoriesGrouped();
}
