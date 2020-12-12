<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class OrderService
{
    protected $orderRepository;
    protected $tenantRepository;
    protected $tableRepository;
    protected $productRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, TenantRepositoryInterface $tenantRepository, TableRepositoryInterface $tableRepository, ProductRepositoryInterface $productRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->tenantRepository = $tenantRepository;

        $this->tableRepository = $tableRepository;

        $this->productRepository = $productRepository;
    }

    public function getClientAuthenticatedOrders()
    {
        $clientId = $this->getOrderClientId();

        $orders = $this->orderRepository->getClientAuthenticatedOrders($clientId);

        return $orders;
    }

    public function getOrderByIdentify(string $identify)
    {
        $order = $this->orderRepository->getOrderByIdentify($identify);

        return $order;
    }

    public function createNewOrder(array $order)
    {
        $identify = $this->generateOrderIdentify();
        $products = $this->getOrderProducts($order['products'] ?? []);
        $total = $this->calcOrderTotal($products);
        $status = 'open';
        $comment = isset($order['comment']) ? $order['comment'] : '';
        $tenantId = $this->getOrderTenantId($order['company_token']);
        $clientId = $this->getOrderClientId();
        $tableId = $this->getOrderTableId($order['table'] ?? null);

        $order = $this->orderRepository->createNewOrder($identify, $total, $status, $comment, $tenantId, $clientId, $tableId);

        $this->orderRepository->setOrderProducts($order->id, $products);

        return $order;
    }

    private function generateOrderIdentify()
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        $characteres = $smallLetters.$numbers;

        $identify = substr(str_shuffle($characteres), 0, 8);

        if($this->orderRepository->getOrderByIdentify($identify))
            $this->getIdentifyOrder();

        return $identify;
    }

    private function getOrderProducts(array $orderProducts): array
    {
        $products = [];
        foreach($orderProducts as $productOrder)
        {
            $product = $this->productRepository->getProductByUuid($productOrder['identify']);

            $products[] = [
                'id' => $product->id,
                'quantity' => $productOrder['quantity'],
                'price' => $product->price
            ];
        }

        return $products;
    }

    private function calcOrderTotal(array $products): float
    {
        $total = 0;

        foreach($products as $product)
        {
            $total += $product['price'] * $product['quantity'];
        }

        return (float)$total;
    }

    private function getOrderTenantId(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $tenant->id;
    }

    private function getOrderClientId()
    {
        $client = auth()->check() ? auth()->user()->id : null;

        return $client;
    }

    private function getOrderTableId(string $uuid = null)
    {
        if($uuid) {
            $table = $this->tableRepository->getTableByUuid($uuid);
            return $table->id;
        }
        return null;
    }
}
