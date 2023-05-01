<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
        if($this->isMethod('post') && $this->routeIs('edit.restaurant')
            || $this->isMethod('delete') && $this->routeIs('delete.restaurant')

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
        if($this->isMethod('delete') && $this->routeIs('delete.restaurant')){
            return [
                'id' =>[
                    'required',
                    'numeric',
                    Rule::exists('restaurants', 'id')
                ]
            ];
        }

        if($this->isMethod('post') && $this->routeIs('add.restaurant')){
            return [
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('restaurants', 'name')
                    ->ignore($this->id),
                ],
                'phone' => 'required|min:5|max:28',
                'address' => 'required',
                'logo'=>[
                    'nullable',
                    'mimes:jpg,png,jpeg,gif,raw,tiff,psd',
                    'max:2048'
                    ]
                ];
            }

            if ($this->isMethod('post') && $this->routeIs('edit.restaurant')){
                return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('restaurants', 'id')
                ],
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('restaurants', 'name')
                    ->ignore($this->id),
                ],
                'phone' => 'required|min:5|max:28',
                'address' => 'required',
                'logo'=>[
                    'nullable',
                    'mimes:jpg,png,jpeg,gif,raw,tiff,psd',
                    'max:2048'
                ]
            ];

        }
    }
}
