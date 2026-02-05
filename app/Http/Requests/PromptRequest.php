<?php

namespace App\Http\Requests;

use App\Models\Project;

class PromptRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [           
            'idProject' => 'required|integer',
            'numberPrompt' => ['required', 'integer',
                function ($attribute, $value, $fail) {
                    $prompts = Project::find($this->input('idProject'))->prompts;
                    foreach ($prompts as $prompt) {
                       if ($prompt->number == $value && $prompt->id != $this->input('idPrompt')) {
                          $fail('This number already exists!'); 
                          break;
                       }
                    }
                },
            ],
            'titlePrompt' => 'required|string|min:3|max:100',
            'contentPrompt' => 'required|string|min:3|max:10000',
        ];
    }

    public function messages()
    {
          return [
            'idProject.required' => 'Field idProject must be filled in!',
            'idProject.integer' => 'Field idProject must be integer!',
            'numberPrompt.required' => 'Field Number must be filled in!',
            'numberPrompt.integer' => 'Field Number must be integer!',
            'titlePrompt.required' => 'Field Title must be filled in!',
            'titlePrompt.max' => 'Field Title must have a maximum of 100 characters!',
            'titlePrompt.min' => 'Field Title must have at least 3 characters!',            
            'contentPrompt.required' => 'Field Content must be filled in!',            
            'contentPrompt.max' => 'Field Content must have a maximum of 10000 characters!',
            'contentPrompt.min' => 'Field Content must have at least 3 characters!',
          ];
    }     
}
