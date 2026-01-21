<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Description;
use App\Repositories\DescriptionRepository;
use App\Http\Requests\DescriptionRequest;

class DescriptionController extends Controller
{
    protected $projectRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DescriptionRepository $repository)
    {
        $this->descriptionRepository = $repository;
    }

    /**
     * Show projects.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->descriptionRepository->getDescription();
    }

    /**
     * Delete item from description.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy(Description $description)
    {
       $this->authorize('manage', $description);

       $description->delete();       

       return $this->index();       
    } 

    /**
     * Store a newly created description in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function store(DescriptionRequest $request)
    {
       $this->descriptionRepository->storeDescription($request);

       return $this->index();
    }  

    /**
     * Edit-view for selected description.
     *
     * @param  ...
     * @return \Illuminate\Http\Response
     */      
    public function show(Description $description)
    {
       $this->authorize('manage', $description);

       //$project->load(['user', 'prompts']); //...if required later...

       //$project->load(['promptsActive']);

       return $description;
    }  

    /**
     * Update selected prompt in storage.
     *
     * @return \Illuminate\Http\Response
     */      
    public function update(DescriptionRequest $request, Description $description)
    {
       $this->authorize('manage', $description);

       $this->descriptionRepository->updateDescription($description, $request);

       return $this->index();
    } 
    
}
