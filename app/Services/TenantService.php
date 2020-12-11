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
}
