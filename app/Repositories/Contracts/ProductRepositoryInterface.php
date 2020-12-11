<?php


namespace App\Repositories\Contracts;


interface ProductRepositoryInterface
{
    public function getProductsByTenantUuid(string $uuid, array $categories);

    public function getProductByUrl(string $url);
}
