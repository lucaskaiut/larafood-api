<?php

namespace App\Tenant\Observers;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Model;

class TenantObserver {
    public function creating(Model $model){
        $manegerTenant = app(ManagerTenant::class);

        if($identify = $manegerTenant->getTenantIdentify())
            $model->tenant_id = $identify;
    }
}
