<?php

namespace App\Repositories;

use App\Models\OrderEvaluation;
use App\Repositories\Contracts\OrderEvaluationRepositoryInterface;

class OrderEvaluationRepository implements OrderEvaluationRepositoryInterface
{
    protected $entity;

    public function __construct(OrderEvaluation $orderEvaluation)
    {
        $this->entity = $orderEvaluation;
    }

    public function newOrderEvaluation(int $orderId, int $clientId, array $data)
    {
        $data = [
            'client_id' => $clientId,
            'order_id' => $orderId,
            'stars' => $data['stars'],
            'comment' => isset($data['comment']) ? $data['comment'] : ''
        ];

        return $this->entity->create($data);
    }

    public function getEvaluationsByOrderId(int $orderId)
    {
        return $this->entity->where('order_id', $orderId)->get();
    }

    public function getEvaluationsByClientId(int $clientId)
    {
        return $this->entity->where('client_id', $clientId)->get();
    }

    public function getEvaluationById(int $id)
    {
        return $this->entity->find($id);
    }
}
