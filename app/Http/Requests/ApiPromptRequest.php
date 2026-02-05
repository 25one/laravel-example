<?php

namespace App\Http\Requests;

//!!!answer error for CONSOLE COMMAND restful api
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiPromptRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'type' => 'required|in:prompt,project',
            'token' => 'required|string',
            //'prompt' => 'required',
        ];
    }

    public function messages()
    {
          return [
            'type.required' => 'Field Type must be filled in!',
            'type.in' => 'Field Type must be prompt or project!',
            'token.required' => 'Field Token must be filled in!',
            //'prompt.required' => 'Field Prompt must be filled in!',            
          ];
    }  
    
    //!!!answer error for CONSOLE COMMAND restful api
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }    
}
