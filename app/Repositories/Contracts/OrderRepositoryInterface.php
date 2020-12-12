<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function createNewOrder(string $identify, float $total, string $status, string $comment, int $tenant_id, int $client_id = null, int $table_id = null);

    public function getOrderByIdentify(string $identify);

    public function setOrderProducts(int $orderId, array $products);

    public function getClientAuthenticatedOrders(int $clientId);
}
