<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\TenantTrait;

class Category extends Model
{
    use TenantTrait;

    protected $fillable = ['tenant_id', 'name', 'url', 'description'];

    public function search($filter = null){
        $results = $this
            ->where('name', 'LIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
