<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PurchaseDetailService;

class PurchaseDetailController extends Controller
{
    public $purchaseDetailService;

    public function __construct(PurchaseDetailService $purchaseDetailService)
    {
        $this->purchaseDetailService = $purchaseDetailService;
    }

    public function addPurchaseDetail(Request $request)
    {
        return $request->all();
    }
}
