<?php

namespace App\Http\Requests;

class WidgetChatRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'prompt' => 'required|string|min:3|max:100',
        ];
    }

    public function messages()
    {
          return [
            'prompt.required' => 'Field Question must be filled in!',
            'prompt.max' => 'Field Question must have a maximum of 100 characters!',
            'prompt.min' => 'Field Question must have at least 3 characters!',            
          ];
    }     
}
