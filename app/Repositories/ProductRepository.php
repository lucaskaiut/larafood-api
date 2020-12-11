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
                        ->join('category_product', 'category_product.product_id', '=', 'products.id')
                        ->join('categories', 'category_product.category_id', '=', 'categories.id')
                        ->where('tenants.uuid', $uuid)
                        ->where(function($query) use ($categories) {
                            if(!empty($categories))
                            $query->whereIn('categories.url', $categories);
                        })
                        ->select('products.*')
                        ->get();

        return $products;
    }

    public function getProductByUrl(string $url)
    {
        $product = $this->entity->where('url', $url)->get();

        return $product;
    }
}