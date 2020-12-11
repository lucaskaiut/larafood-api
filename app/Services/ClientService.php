<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientService
{
    protected $repository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->repository = $clientRepository;
    }

    public function createNewClient(array $data)
    {
        return $this->repository->createNewClient($data);
    }

    public function getClientById(int $id)
    {
        return $this->repository->getClientById($id);
    }
}
