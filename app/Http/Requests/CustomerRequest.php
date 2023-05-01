<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        if($this->isMethod('post') && $this->routeIs('edit.customer')
           ||$this->isMethod('delete') && $this->routeIs('delete.customer')
           ||$this->isMethod('put') && $this->routeIs('update.customer.status')
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

        if($this->isMethod('put') && $this->routeIs('update.customer.status')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('customers', 'id')
                ],
                'status'=>[
                    'required',
                    Rule::in('pending', 'paid', 'complete', 'cancel')
                ]
            ];
        }

        if($this->isMethod('delete') && $this->routeIs('delete.customer')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('customers', 'id')
                ],
            ];
        }


        if($this->isMethod('post') && $this->routeIs('edit.customer')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('customers', 'id')
                ],
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('customers', 'name')
                    ->ignore($this->id),
                ],
                'phone'=> [
                    'required',
                    'min:5',
                    'max:20'
                ],
                'address'=> 'required',
                'profile' =>[
                    'nullable',
                    'mimes:jpg,png,jpeg,gif,raw,tiff,psd',
                    'max:2048'
                ]
            ];
        }

        if($this->isMethod('post') && $this->routeIs('add.customer')){
            return [
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('customers', 'name')
                    ->ignore($this->id),
                ],
                'phone'=> [
                    'required',
                    'min:5',
                    'max:20'
                ],
                'address'=> 'required',
                'profile' =>[
                    'nullable',
                    'mimes:jpg,png,jpeg,gif,raw,tiff,psd',
                    'max:2048'
                ]
            ];
        }


    }
}
