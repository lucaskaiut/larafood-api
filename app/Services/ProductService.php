<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getProductsByTenantUuid(string $uuid, array $categories)
    {
        $products = $this->repository->getProductsByTenantUuid($uuid, $categories);

        return $products;
    }

    public function getProductByUrl(string $url)
    {
        $product = $this->repository->getProductByUrl($url);

        return $product;
    }
}
