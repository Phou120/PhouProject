<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\ResponseAPI;

class CategoryService
{
    use ResponseAPI;

    public function addCategory($request)
    {
        $addCategory = new Category();
        $addCategory->name = $request['name'];
        $addCategory->restaurant_id = $request['restaurant_id'];
        $addCategory->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function editCategory($request)
    {
        $editCategory = Category::find($request['id']);
        $editCategory->name = $request['name'];
        $editCategory->restaurant_id = $request['restaurant_id'];
        $editCategory->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function deleteCategory($request)
    {
        $deleteCategory = Category::find($request['id']);
        $deleteCategory->delete();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function listCategories()
    {
        $masters = Category::select(
            'categories.*',
            'rest.name as rest_name',
            'rest.phone as rest_phone',
            'rest.address as rest_address',
            'rest.logo as rest_logo',

        )->join(
            'restaurants as rest',
            'rest.id', '=', 'categories.restaurant_id',
        )->orderBy('id', 'desc')->get();

        return response()->json([
            'listCategories' => $masters
        ]);

    }
}
