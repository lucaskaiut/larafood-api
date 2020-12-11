<?php


namespace App\Models\Traits;


trait TenantAccessorsTrait
{
    public function getExpiresAtAttribute($value){
        if($value)
            return date('d/m/Y', strtotime($value));
    }

    public function getSubscriptionAttribute($value){
        if($value)
            return date('d/m/Y', strtotime($value));
    }
}
