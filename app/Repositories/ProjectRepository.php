<?php

namespace App\Repositories;

use App\Models\ {
    Project,
    Prompt
};

class ProjectRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @param  \App\Models\Project $project
     */
    protected $modelProject;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Project $project)
    {
        $this->modelProject = $project;
    }

    /**
     * Get items from Project-model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getProjects()
    {
       return Project::where('user_id', auth()->user()->id)
                     ->orderBy('updated_at', 'desc')
                     ->get(); 
    }

    /**
     * Store item to Project-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeProject($request)
    {
       $project = $this->modelProject;

       $project->user_id = \Auth::user()->id;
       $project->title = $request->titleProject;
       $project->token = \Str::random(30);

       $project->save();
       
       return $project->id;
    }
    
    /**
     * Delete all prompts of project.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteProjectPrompts($idProject)
    {
       Prompt::where('project_id', $idProject)->delete();
    }     

    /**
     * Update item to Project-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateProject($project, $request)
    {
       $project->title = $request->titleProject;

       $project->save(); 
    }    
}
