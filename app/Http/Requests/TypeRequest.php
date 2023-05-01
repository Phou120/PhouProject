<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
        if($this->isMethod('put') && $this->routeIs('edit.type')
            ||$this->isMethod('delete') && $this->routeIs('delete.type')
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
        if($this->isMethod('delete') && $this->routeIs('delete.type')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('types', 'id')
                ],
            ];
        }

        if($this->isMethod('put') && $this->routeIs('edit.type')){
            return [
                'id'=>[
                    'required',
                    'numeric',
                    Rule::exists('types', 'id')
                ],
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('types', 'name')
                    ->ignore($this->id),
                ],
                'Category_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('categories', 'id')
                ]
            ];
        }
        if($this->isMethod('post') && $this->routeIs('add.type')){
            return [
                'name'=>[
                    'required',
                    'min:2',
                    'max:256',
                    Rule::unique('types', 'name')
                    ->ignore($this->id),
                ],
                'Category_id'=>[
                    'required',
                    'numeric',
                    Rule::exists('categories', 'id')
                ]
            ];
        }
    }
}
