<?php

namespace App\Repositories;

use App\Models\ {
    Description,
    Prompt,
    Project

};
use App\Repositories\PromptRepository;

class ApiRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @param  \App\Models\Description $descriptiont
     */
    protected $modelDescription;
    protected $modelPrompt;
    protected $promptRepository;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Description $description, Prompt $prompt, PromptRepository $repositoryPrompt)
    {
        $this->modelDescription = $description;
        $this->modelPrompt = $prompt;
        $this->promptRepository = $repositoryPrompt;
    }

    /**
     * Make chat question.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function chatQuestion($request, $userId)
    {
        try {
            $description = Description::where('user_id', $userId)
                              ->first(); 

            $prompt  = str_replace('#chatprompt#', $request->prompt, $description->description); 

            return $this->promptRepository->execute($prompt);
        } catch (\Exception $e) {
            return $e;
        }  
       }
    
    /**
     * Prompt-execute.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function promptExecute($request)
    {
        try {
            $prompt = Prompt::where('token', $request->token)
                              ->firstOrFail(); 
 
            if ($request->prompt) {                  
               $prompt  = str_replace('#apiprompt#', is_array($request->prompt) ? json_encode($request->prompt) : $request->prompt, $prompt->content); 
            } else {
               $prompt = $prompt->content;              
            }

            return $this->promptRepository->execute($prompt);
        } catch (\Exception $e) {
            return $e;
        }       
    }

    /**
     * Project-execute.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function projectExecute($request)
    {
        try {
            $project = Project::where('token', $request->token)
                           ->with('prompts')
                           ->firstOrFail();

            if (count($project->prompts)) {             
                  foreach ($project->prompts as $key => $prompt) {
                     if ($key == 0) {
                        if ($request->prompt) $prompt = str_replace('#apiprompt#', is_array($request->prompt) ? json_encode($request->prompt) : $request->prompt, $prompt->content);
                        else $prompt = $prompt->content;
                     } else {
                        $prompt = str_replace('#beforeprompt#', $result, $prompt->content);
                     }

                     $result = $this->promptRepository->execute($prompt);
                  }

                  return $result;
            } else {
                  return null;
            }
        } catch (\Exception $e) {
            return $e;
        }          
    }    
}
