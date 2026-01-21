<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt;
use App\Repositories\PromptRepository;
use App\Http\Requests\PromptRequest;
use App\Services\AI\OpenAI;
use App\Services\AI\GenAI;

class PromptController extends Controller
{
    protected $promptRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromptRepository $repository)
    {
        $this->promptRepository = $repository;
    }

    /**
     * Show prompts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($idProject)
    {
        return $this->promptRepository->getPrompts($idProject);
    }

    /**
     * Delete item from prompts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy(Prompt $prompt)
    {
       $idProject = $prompt->project_id;

       $prompt->delete();

       return $this->index($idProject);
    } 

    /**
     * Store a newly created prompt in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function store(PromptRequest $request)
    {
       $this->promptRepository->storePrompt($request);

       return $this->index($request->idProject);
    }  

    /**
     * Edit-view for selected prompt.
     *
     * @param  ...
     * @return \Illuminate\Http\Response
     */      
    public function show(Prompt $prompt)
    {
       return $prompt;
    }  

    /**
     * Update selected prompt in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function update(PromptRequest $request, Prompt $prompt)
    {
       $this->promptRepository->updatePrompt($prompt, $request);

       return $this->index($prompt->project_id);
    } 
    
    /**
     * Change active for prompt
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changeActivePrompt(Request $request)
    {       
       $this->promptRepository->promptChangeActive($request);

       return $this->index($request->idProject);
    }

    /**
     * LLM(OpenAI, Genai...)
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function executePrompt(Request $request)
    {
       return $this->promptRepository->execute($request->prompt);
    }     
}
