<?php

namespace App\Http\Requests;

class SaveApiKeyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'apiKey' => 'required',
            'topmodelId' => 'required|integer',
            'active' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
          return [
            'apiKey.required' => 'Field Api Key must be filled in!',
            'topmodelId.required' => 'Field topmodel Id must be filled in!',
            'topmodelId.integer' => 'Field topmodel Id must be integer!',
            'active.required' => 'Field active must be filled in!',
            'active.in' => 'Field active must be only 0 or 1!',
          ];
    }     
}
