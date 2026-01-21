<?php

namespace App\Repositories;

use App\Models\ {
    Project,
    Prompt
};
use App\Repositories\ModelRepository;
use App\Services\AI\OpenAI;
use App\Services\AI\GenAI;

class PromptRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @param  \App\Models\Project $project
     * @param  \App\Models\Prompt $prompt 
     */
    protected $modelProject;
    protected $modelPrompt;
    protected $modelRepository;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Project $project, Prompt $prompt, ModelRepository $repositoryModel)
    {
        $this->modelProject = $project;
        $this->modelPrompt = $prompt;
        $this->modelRepository = $repositoryModel;

    }

    /**
     * Get items from Prompt-model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getPrompts($idProject)
    {
       return Project::with('prompts')
                     ->findOrFail($idProject);
    }

    /**
     * Store item to Prompt-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storePrompt($request)
    {
       $this->modelPrompt->project_id = $request->idProject;
       $this->modelPrompt->number = $request->numberPrompt;
       $this->modelPrompt->title = $request->titlePrompt;
       $this->modelPrompt->content = $request->contentPrompt;
       $this->modelPrompt->token = \Str::random(30);

       $this->modelPrompt->save(); 
    } 
    
    /**
     * Update item to Prompt-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updatePrompt($prompt, $request)
    {
       $prompt->number = $request->numberPrompt;
       $prompt->title = $request->titlePrompt;
       $prompt->content = $request->contentPrompt;

       $prompt->save(); 
    }
    
    /**
     * Change active for prompt
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function promptChangeActive($request)
    {   
       $prompt = $this->modelPrompt->find($request->id);

       $prompt->active == '1' ? $prompt->active = '0' : $prompt->active = '1';

       $prompt->save();
    } 
    
    /**
     * LLM(OpenAI, Genai...)
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function execute($prompt)
    {       
         $selectedModel = $this->modelRepository->getSelectedModel();

         $classAI = 'App\Services\AI\\' . $selectedModel->model;

         try {
            $llm = new $classAI();

            $llm->variantAI = $selectedModel->model;
            $llm->variantModel = $selectedModel->bottommodels->first()->model;
            $llm->prompt = $prompt;

            return $llm->funcGet();
         } catch (\Exception $e) {
            return $e->getMessage();
         }
    }     

}
