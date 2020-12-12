<?php

namespace App\Services;

use App\Repositories\Contracts\OrderEvaluationRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderEvaluationService
{
    protected $orderEvaluationRepository;
    protected $orderRepository;

    public function __construct(OrderEvaluationRepositoryInterface $evaluationRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->orderEvaluationRepository = $evaluationRepository;

        $this->orderRepository = $orderRepository;
    }

    public function createNewEvaluation(string $identifyOrder, array $data)
    {
        $clientId = $this->getClientId();

        $order = $this->orderRepository->getOrderByIdentify($identifyOrder);

        return $this->orderEvaluationRepository->newOrderEvaluation($order->id, $clientId, $data);
    }

    private function getClientId()
    {
        return auth()->user()->id;
    }
}
