<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'url', 'image'];

    use TenantTrait;

    public function search($filter = null){
        $results = $this
            ->where('name', 'LIKE', "%{$filter}%")
            ->orWhere('description', 'LIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }

    public function categoriesAvailable($filter = null){
        $categories = Category::whereNotIn('id', function($query){
            $query->select('category_product.category_id');
            $query->from('category_product');
            $query->whereRaw("product_id = {$this->id}");
        })
            ->where(function($queryFilter) use ($filter){
                if($filter)
                    $queryFilter->where('categories.name', 'LIKE', "%{$filter}%");
            })
            ->paginate();

        return $categories;
    }
}
