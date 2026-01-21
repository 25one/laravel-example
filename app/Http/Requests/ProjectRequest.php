<?php

namespace App\Http\Requests;

class ProjectRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'titleProject' => 'required|string|min:3|max:100',
        ];
    }

    public function messages()
    {
          return [
            'titleProject.required' => 'Field Title must be filled in!',         
            'titleProject.max' => 'Field Title must have a maximum of 100 characters!',
            'titleProject.min' => 'Field Title must have at least 3 characters!',
          ];
    }     
}
