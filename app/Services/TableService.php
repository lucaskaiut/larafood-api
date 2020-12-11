<?php

namespace App\Services;

use App\Repositories\Contracts\TableRepositoryInterface;

class TableService
{
    protected $repository;

    public function __construct(TableRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getTablesByTenantUuid(string $uuid)
    {
        return $this->repository->getTablesByTenantUuid($uuid);
    }

    public function getTableById(int $id)
    {
        return $this->repository->getTableById($id);
    }
}
