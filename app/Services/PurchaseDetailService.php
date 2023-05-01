<?php

namespace App\Services;


use App\Traits\ResponseAPI;

class PurchaseDetailService
{
    use ResponseAPI;

    public function addPurchaseDetail($request)
    {
        return $request->all();
    }
}
