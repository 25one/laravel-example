<?php

namespace App\Http\Requests;

class RemoveApiKeyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'topmodelId' => 'required|integer',
        ];
    }

    public function messages()
    {
          return [
            'topmodelId.required' => 'Field topmodel Id must be filled in!',
            'topmodelId.integer' => 'Field topmodel Id must be integer!',
          ];
    }     
}
