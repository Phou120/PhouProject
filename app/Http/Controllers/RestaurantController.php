<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RestaurantService;
use App\Http\Requests\RestaurantRequest;

class RestaurantController extends Controller
{

    public $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function addRestaurant(RestaurantRequest $request)
    {
        return $this->restaurantService->addRestaurant($request);
    }

    public function editRestaurant(RestaurantRequest $request)
    {
        return $this->restaurantService->editRestaurant($request);
    }

    public function deleteRestaurant(RestaurantRequest $request)
    {
        return $this->restaurantService->deleteRestaurant($request);
    }

    public function listRestaurants()
    {
        return $this->restaurantService->listRestaurants();
    }
}
