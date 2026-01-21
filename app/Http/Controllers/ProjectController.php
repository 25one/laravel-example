<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    protected $projectRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProjectRepository $repository)
    {
        $this->projectRepository = $repository;
    }

    /**
     * Show projects.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->projectRepository->getProjects();
    }

    /**
     * Delete item from projects.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy(Project $project)
    {
       $this->authorize('manage', $project);

       try {
         \DB::transaction(function () use ($project) {
            $project->delete();

            $this->projectRepository->deleteProjectPrompts($project->id);
         });
       } catch (\Exception $e) {
         return $e;
       }

       return $this->index();       
    } 

    /**
     * Store a newly created project in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function store(ProjectRequest $request)
    {
       return $this->projectRepository->storeProject($request);
    }  

    /**
     * Edit-view for selected project.
     *
     * @param  ...
     * @return \Illuminate\Http\Response
     */      
    public function show(Project $project)
    {
       $this->authorize('manage', $project);

       //$project->load(['user', 'prompts']); //...if required later...

       $project->load(['promptsActive']);

       return $project;
    }  

    /**
     * Update selected prompt in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function update(ProjectRequest $request, Project $project)
    {
       $this->authorize('manage', $project);

       $this->projectRepository->updateProject($project, $request);

       return $this->index();
    } 
    
}
