<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use TenantTrait;

    protected $fillable = ['name', 'description', 'tenant_id'];

    public function search($filter = null){
        $results = $this
            ->where('name', 'LIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }

    public function tentant(){
        return $this->belongsTo(Tenant::class);
    }
}
