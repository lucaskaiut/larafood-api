<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrder;
use App\Http\Requests\Api\StoreOrderEvaluation;
use App\Http\Resources\OrderEvaluationResource;
use App\Services\OrderEvaluationService;
use Illuminate\Http\Request;

class OrderEvaluationController extends Controller
{
    protected $evaluationService;

    public function __construct(OrderEvaluationService $orderEvaluationService)
    {
        $this->evaluationService = $orderEvaluationService;
    }

    public function store(StoreOrderEvaluation $request)
    {
        $data = $request->only('stars', 'comment');

        $evaluation = $this->evaluationService->createNewEvaluation($request->identify, $data);

        return new OrderEvaluationResource($evaluation);
    }
}
