<?php

namespace App\Repositories;

use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;

class TableRepository implements TableRepositoryInterface
{
    protected $entity;

    public function __construct(Table $table)
    {
        $this->entity = $table;
    }

    public function getTablesByTenantUuid(string $uuid)
    {
        return $this->entity
            ->join('tenants', 'tenants.id', '=', 'tables.tenant_id')
            ->where('tenants.uuid', $uuid)
            ->select('tables.*')
            ->get();
    }

    public function getTableByUuid(string $uuid)
    {
        return $this->entity->where('uuid', $uuid)->get();
    }
}
