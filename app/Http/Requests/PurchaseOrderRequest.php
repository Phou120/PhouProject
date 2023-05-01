<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->user()->hasRole('superAdmin|admin');
    }

    public function prepareForValidation()
    {
        if($this->isMethod('put') && $this->routeIs('edit.purchaseOrder')
        ||$this->isMethod('delete') && $this->routeIs('delete.purchaseOrder')
        ||$this->isMethod('delete') && $this->routeIs('delete.purchaseDetail')
        ||$this->isMethod('put') && $this->routeIs('edit.purchaseDetail')
        || $this->isMethod('post') && $this->routeIs('add.purchase.detail')

        ){
            $this->merge([
                'id' => $this->route()->parameters['id'],

            ]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        if($this->isMethod('put') && $this->routeIs('edit.purchaseDetail')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('purchase_details', 'id')
                ],
                'food_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('food', 'id')
                ],
                'qty'=>[
                    'required',
                    'numeric',
                ]
            ];
        }


        if($this->isMethod('delete') && $this->routeIs('delete.purchaseDetail')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('purchase_details', 'id')
                ],
            ];
        }


        if($this->isMethod('post') && $this->routeIs('add.purchase.detail')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('purchase_orders', 'id')
                ],
                'qty'=>[
                    'required',
                    'numeric',
                ],
                'price'=>[
                    'required',
                    'numeric',
                ]
            ];
        }

        if($this->isMethod('delete') && $this->routeIs('delete.purchaseOrder')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('purchase_orders', 'id')
                ],
            ];
        }


        if($this->isMethod('put') && $this->routeIs('edit.purchaseOrder')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('purchase_orders', 'id')
                ],
                'customer_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('customers', 'id')
                ]
            ];
        }

        if($this->isMethod('post') && $this->routeIs('add.purchaseOrder')){
            return [
                'order_date'=>[
                    'required',
                    'date',
                ],
                'customer_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('customers', 'id')
                ],
            ];
        }

    }
}
