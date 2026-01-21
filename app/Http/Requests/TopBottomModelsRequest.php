<?php

namespace App\Http\Requests;

class TopBottomModelsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'selectedTopModelId' => 'required',
            'selectedBottomModelId' => 'required',
        ];
    }

    public function messages()
    {
          return [
            'selectedTopModelId.required' => 'Field TopModelId must be filled in!',
            'selectedBottomModelId.required' => 'Field BottomModelId must be filled in!',
          ];
    }     
}
