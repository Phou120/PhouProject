<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
        if($this->isMethod('put') && $this->routeIs('edit.food')
            ||$this->isMethod('delete') && $this->routeIs('delete.food')
            ||$this->isMethod('put') && $this->routeIs('update.food.status')
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

        if($this->isMethod('put') && $this->routeIs('update.food.status')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('food', 'id')
                ],
                'status'=>[
                    'required',
                    Rule::in('open', 'closed')
                ]
            ];
        }

        if($this->isMethod('delete') && $this->routeIs('delete.food')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('food', 'id')
                ],
            ];
        }

        if($this->isMethod('put') && $this->routeIs('edit.food')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('food', 'id')
                ],
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('food', 'name')
                    ->ignore($this->id),
                ],
                'type_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('types', 'id')
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

        if($this->isMethod('post') && $this->routeIs('add.food')){
            return [
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('food', 'name')
                    ->ignore($this->id),
                ],
                'type_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('types', 'id')
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

    }
}
