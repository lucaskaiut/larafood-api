<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $entity;

    public function __construct(Product $product)
    {
        $this->entity = $product;
    }

    public function getProductsByTenantUuid(string $uuid, array $categories)
    {
        $products = $this->entity
                        ->join('tenants', 'tenants.id', '=', 'products.tenant_id')
                        ->leftJoin('category_product', 'category_product.product_id', '=', 'products.id')
                        ->leftJoin('categories', 'category_product.category_id', '=', 'categories.id')
                        ->where('tenants.uuid', $uuid)
                        ->where(function($query) use ($categories) {
                            if(!empty($categories))
                            $query->whereIn('categories.url', $categories);
                        })
                        ->select('products.*')
                        ->distinct('products.id')
                        ->get();

        return $products;
    }

    public function getProductByUuid(string $uuid)
    {
        $product = $this->entity->where('uuid', $uuid)->first();

        return $product;
    }
}
