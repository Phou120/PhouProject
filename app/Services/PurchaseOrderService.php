<?php

namespace App\Services;

use App\Models\Food;
use App\Models\User;
use App\Models\Customer;
use App\Traits\ResponseAPI;
use App\Models\PurchaseOrder;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderService
{
    use ResponseAPI;

    public function addPurchaseOrder($request)
    {
        DB::beginTransaction();

        $addOrder = new PurchaseOrder();
        $addOrder->order_date = $request['order_date'];
        $addOrder->customer_id = $request['customer_id'];
        $addOrder->created_by = Auth::user('api')->id;
        $addOrder->save();

        if(count($request['details']) > 0){
            foreach($request['details'] as $item){
                $getFood = $this->checkPrice($item['food_id']);
                if(isset($getFood)){

                    $addDetail = new PurchaseDetail();
                    $addDetail->purchase_id = $addOrder['id'];
                    $addDetail->food_id = $item['food_id'];
                    $addDetail->qty = $item['amount'];
                    $addDetail->price = $getFood['price'];
                    $addDetail->sub_total = $getFood['price'] * $item['amount'];
                    $addDetail->save();

                    /** reduce Stock */
                    $update = Food::find($item['food_id']);
                    $update->qty -= $item['amount'];
                    $update->save();
                }
            }
        }
        DB::commit();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function checkPrice($id)
    {
        return Food::find($id);
    }

    public function addPurchaseDetail($request)
    {
        DB::beginTransaction();

            $addDetail = new PurchaseDetail();
            $addDetail->purchase_id = $request['id'];
            $addDetail->food_id = $request['food_id'];
            $addDetail->qty = $request['qty'];
            $addDetail->price = $request['price'];
            $addDetail->sub_total = $request['price'] * $request['qty'];
            $addDetail->save();

            /** reduce Stock */
            $update = Food::find($request['food_id']);
            $update->qty -= $request['qty'];
            $update->save();


        DB::commit();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function editPurchaseOrder($request)
    {
        $editOrder = PurchaseOrder::find($request['id']);
        $editOrder->order_date = $request['order_date'];
        $editOrder->customer_id = $request['customer_id'];
        $editOrder->created_by = Auth::user('api')->id;
        $editOrder->save();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function deletePurchaseOrder($request)
    {
        $deleteOrder = PurchaseOrder::find($request['id']);
        $deleteOrder->delete();

        return $this->success('ຜ່ານແລ້ວ', 200);
    }

    public function listPurchaseOrders()
    {
        $items = PurchaseOrder::select(
            'purchase_orders.*',

        )->orderBy('purchase_orders.id', 'desc')
        ->get();
        $items->transform(function($item){
             $sub_total = PurchaseDetail::where('purchase_id', $item['id'])
             ->select(DB::raw("IFNULL(sum(purchase_details.sub_total), 0) as total"))
             ->first()->total;

            //Merge Data Or Push Data => ( create new columns )
             $item['sub_total2'] = $sub_total;


            return $item;
        });

        return response()->json([
            'listPurchaseOrders' => $items
        ]);
    }

    public function listPurchaseDetails($id)
    {


        $details = PurchaseDetail::where('purchase_id', $id)->get();
        $details->transform(function($item){
            return $item->format();
        });

        return response()->json([

            'details' => $details
        ]);

    }

    public function deletePurchaseDetail($request)
    {
        $deletePurchase = PurchaseDetail::find($request['id']);
        $deletePurchase->delete();

         /** reduce Stock */
        $updateFood = Food::find($deletePurchase->food_id);
        $updateFood->qty += $deletePurchase['qty'];
        $updateFood->save();


        return $this->success('ຜ່ານແລ້ວ', 200);

    }

    public function editPurchaseDetail($request)
    {
        $editPurchase = PurchaseDetail::find($request['id']);
        $editPurchase->food_id = $request['food_id'];
        $editPurchase->qty = $request['qty'];
        $editPurchase->save();


         /** reduce Stock */
        $update = Food::find($request['food_id']);
        $update->qty -= $request['qty'];
        $update->save();

        return $this->success('ຜ່ານແລ້ວ', 200);

    }
}
