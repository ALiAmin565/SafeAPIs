<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class StoreplanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'title'=>'required |max:255',
            'name'=>'required |max:255',
            'desc'=>'required',
            'discount'=>'required|in:0,1',
            'price'=>'required|integer |max:255',
            'percentage'=>'required|max:255',



        ];
    }


    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }



    // public function messages()

    // {

    //     // return [

    //     //     'title.required' => 'Title is required',

    //     //     'body.required' => 'Body is required'

    //     // ];

    // }

}
