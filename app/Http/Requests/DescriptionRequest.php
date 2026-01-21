<?php

namespace App\Http\Requests;

class DescriptionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'description' => 'required|string|min:3|max:1000',
        ];
    }

    public function messages()
    {
          return [
            'description.required' => 'Field Description must be filled in!',
            'description.max' => 'Field Description must have a maximum of 1000 characters!',
            'description.min' => 'Field Description must have at least 3 characters!',            
          ];
    }     
}
