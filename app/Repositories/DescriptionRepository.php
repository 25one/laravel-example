<?php

namespace App\Repositories;

use App\Models\ {
    Description

};

class DescriptionRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @param  \App\Models\Description $description
     */
    protected $modelDescription;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Description $description)
    {
        $this->modelDescription = $description;

    }

    /**
     * Get items from Description-model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getDescription()
    {
       return Description::where('user_id', auth()->user()->id)->get();
    }

    /**
     * Store item to Description-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storeDescription($request)
    {
       $this->modelDescription->user_id = auth()->user()->id;
       $this->modelDescription->description = $request->description;

       $this->modelDescription->save(); 
    } 
    
    /**
     * Update item to Description-model.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateDescription($description, $request)
    {
       $description->description = $request->description;

       $description->save(); 
    }
    
}
