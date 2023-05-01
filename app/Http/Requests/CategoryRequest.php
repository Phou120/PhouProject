<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if($this->isMethod('put') && $this->routeIs('edit.category')
            ||$this->isMethod('delete') && $this->routeIs('delete.category')
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
        if($this->isMethod('delete') && $this->routeIs('delete.category')){
            return [
                'id' =>[
                    'required',
                    'numeric',
                    Rule::exists('categories', 'id')
                ],
            ];
        }

        if($this->isMethod('put') && $this->routeIs('edit.category')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('categories', 'id')
                ],
                'name' =>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('categories', 'name')
                    ->ignore($this->id),
                ],
                'restaurant_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('restaurants', 'id'),

                ]
            ];
        }


        if($this->isMethod('post') && $this->routeIs('add.category')){
            return [
                'name' =>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('categories', 'name')
                    ->ignore($this->id),
                ],
                'restaurant_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('restaurants', 'id')
                ]
            ];
        }
    }
}
