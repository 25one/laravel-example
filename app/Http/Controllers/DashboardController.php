<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Repositories\PromptRepository;
use App\Repositories\ModelRepository;
use App\Repositories\DescriptionRepository;
use App\Http\Requests\TopBottomModelsRequest;

class DashboardController extends Controller
{
    protected $projectRepository;
    protected $promptRepository;
    protected $modelRepository;
    protected $descriptionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromptRepository $repositoryPrompt, ProjectRepository $repositoryProject, ModelRepository $repositoryModel, DescriptionRepository $repositoryDescription)
    {
        //$this->middleware('auth');

        $this->projectRepository = $repositoryProject; 
        $this->promptRepository = $repositoryPrompt;
        $this->modelRepository = $repositoryModel;
        $this->descriptionRepository = $repositoryDescription;      
    }

    /**
     * View 404-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view404()
    {
        return view('404');
    }

    /**
     * Show the list-projects-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listProjects()
    {
        $projects = $this->projectRepository->getProjects();

        return view('dashboard.list-projects', ['projects' => $projects]);
    }

    /**
     * Show the list-prompts-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listPrompts(Request $request)
    {
        try {
            $project = $this->promptRepository->getPrompts($request->idProject);

            return view('dashboard.list-prompts', ['project' => $project]);
        } catch (\Exception $e) {
            return redirect(route('404'));
        }        
    }

    /**
     * Show the widget-chat-description-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function description()
    {
        $description = $this->descriptionRepository->getDescription();

        return view('dashboard.description', ['description' => $description]);
    }

    /**
     * Show the api-settings-prompts-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function apiSettings()
    {
        return view('dashboard.api-settings');
    } 
    
    /**
     * Show the api-settings-page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        $models = $this->modelRepository->getModels();

        return view('dashboard.settings', compact('models'));
    } 
    
    /**
     * Change settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function makeSettings(TopBottomModelsRequest $request)
    {
       $this->modelRepository->setModels($request);

       return $this->modelRepository->getModels();
    }       
}
