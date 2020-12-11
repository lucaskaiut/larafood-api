<?php

namespace App\Models;

use App\Models\Traits\TenantAccessorsTrait;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use TenantAccessorsTrait;

    protected $fillable = ['cnpj', 'name', 'url', 'email', 'logo', 'active', 'subscription', 'expires_at', 'subscription_id', 'subscription_ative', 'subscription_suspended'];

    /*
     * Relationships
     */

    public function users(){
        return $this->hasMany(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function tables(){
        return $this->hasMany(Table::class);
    }
}
