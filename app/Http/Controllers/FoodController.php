<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FoodService;
use App\Http\Requests\FoodRequest;

class FoodController extends Controller
{
    public $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    public function addFood(FoodRequest $request)
    {
        return $this->foodService->addFood($request);
    }

    public function editFood(FoodRequest $request)
    {
        return $this->foodService->editFood($request);
    }

    public function deleteFood(FoodRequest $request)
    {
        return $this->foodService->deleteFood($request);
    }

    public function listFoods()
    {
        return $this->foodService->listFoods();
    }

    public function updateFoodStatus(FoodRequest $request)
    {
        return $this->foodService->updateFoodStatus($request);
    }
}
