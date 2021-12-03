<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class OtherServicesRequest extends FormRequest
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

    public function Rules()
    {
        return [];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function validationRules()
    {
        return [

            'title'          => 'required',
            'description'    => 'required',
            'image'          => 'required',
            'icon'           => 'required',
        ];
    }

    public function validateData()
    {
        $validation = Validator::make(request()->all(), $this->validationRules());
        if ($validation->fails()) {
            return [
                false,
                $validation->errors()
            ];
        }
        return [true, null];
    }
}