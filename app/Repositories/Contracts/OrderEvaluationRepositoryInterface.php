<?php

namespace App\Repositories\Contracts;

interface OrderEvaluationRepositoryInterface
{
    public function newOrderEvaluation(int $orderId, int $clientId, array $data);

    public function getEvaluationsByOrderId(int $orderId);

    public function getEvaluationsByClientId(int $clientId);

    public function getEvaluationById(int $id);
}
