<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    protected $entity;

    public function __construct(Order $order)
    {
        $this->entity = $order;
    }

    public function createNewOrder(string $identify, float $total, string $status, string $comment, int $tenant_id, int $client_id = null, int $table_id = null)
    {
        $data = [
            'identify' => $identify,
            'total' => $total,
            'status' => $status,
            'comment' => $comment,
            'tenant_id' => $tenant_id,
            'client_id' => $client_id,
            'table_id' => $table_id
        ];

        return $this->entity->create($data);
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->entity->where('identify', $identify)->first();
    }

    public function setOrderProducts(int $orderId, array $products)
    {
        $order = $this->entity->find($orderId);

        $orderProducts = [];

        foreach($products as $product)
        {
            $orderProducts[$product['id']] = [
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ];
        }

        $order->products()->attach($orderProducts);
    }

    public function getClientAuthenticatedOrders(int $clientId)
    {
        $orders = $this->entity->where('client_id', $clientId)->get();

        return $orders;
    }
}
