<?php

namespace App\Services;

use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantService
{
    private $repository;

    public function __construct(TenantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTenants()
    {
        return $this->repository->getAllTenants();
    }

    public function getTenantByUuid(string $uuid)
    {
        return $this->repository->getTenantByUuid($uuid);
    }
}
