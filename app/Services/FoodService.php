<?php

namespace App\Services;


use App\Models\Food;
use App\Traits\ResponseAPI;

class FoodService
{
    use ResponseAPI;

    public function addFood($request)
    {
        $addFood = new Food();
        $addFood->name = $request['name'];
        $addFood->type_id = $request['type_id'];
        $addFood->qty = $request['qty'];
        $addFood->price = $request['price'];
        $addFood->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function editFood($request)
    {
        $editFood = Food::find($request['id']);
        $editFood->name = $request['name'];
        $editFood->type_id = $request['type_id'];
        $editFood->qty = $request['qty'];
        $editFood->price = $request['price'];
        $editFood->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function deleteFood($request)
    {
        $deleteFood = Food::find($request['id']);
        $deleteFood->delete();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function listFoods()
    {
        $masters = Food::select(
            'food.*',
            'type.name as type_name'
        )->join(
            'types as type',
            'type.id', '=', 'food.type_id',
        )->orderBy('id', 'desc')->get();

        return response()->json([
            'listFoods' => $masters
        ]);
    }

    public function updateFoodStatus($request)
    {
        $updateStatus = Food::find($request['id']);
        $updateStatus->status = $request['status'];
        $updateStatus->save();

        return $this->success('ຜ່ານແລ້ວ', 200);

    }
}
