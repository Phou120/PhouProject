<?php

namespace App\Services;

use App\Models\Type;
use App\Traits\ResponseAPI;

class TypeService
{
    use ResponseAPI;

    public function addType($request)
    {
        $addType = new Type();
        $addType->name = $request['name'];
        $addType->Category_id = $request['Category_id'];
        $addType->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function editType($request)
    {
        $ediType = Type::find($request['id']);
        $ediType->name = $request['name'];
        $ediType->Category_id = $request['Category_id'];
        $ediType->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function deleteType($request)
    {
        $deleteType = Type::find($request['id']);
        $deleteType->delete();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function listTypes()
    {
        $masters = Type::select(
            'types.*',
            'cate.name as cate_name',
        )
        ->join(
            'categories as cate',
            'cate.id', '=', 'types.category_id'
        )->orderBy('id', 'desc')->get();

        return response()->json([
            'listTypes' => $masters
        ]);
    }
}


