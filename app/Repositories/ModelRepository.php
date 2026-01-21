<?php

namespace App\Repositories;

use App\Models\ {
    Topmodel,
    Bottommodel
};

class ModelRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     * @param  \App\Models\Topmodel $topmodel
     * @param  \App\Models\Bottommodel $bottommodel
     */
    protected $modelTop;
    protected $modelBottom;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Topmodel $topmodel, Bottommodel $bottommodel)
    {
        $this->modelTop = $topmodel;
        $this->modelBottom = $bottommodel;
    }

    /**
     * Get models.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModels()
    {              
       return Topmodel::with('bottommodels')
                      ->get();                      
    } 

    /**
     * Set models.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setModels($request)
    {              
       $this->modelTop->query()->update(['active' => '0']);
       $modelTop = $this->modelTop->find($request->selectedTopModelId);
       $modelTop->active = '1';
       $modelTop->save(); 

       $this->modelBottom->where('topmodel_id', $request->selectedTopModelId)->update(['active' => '0']);
       $modelBottom = $this->modelBottom->find($request->selectedBottomModelId);
       $modelBottom->active = '1';
       $modelBottom->save();
    } 
    
    /**
     * Get selected model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getSelectedModel()
    {              
       return Topmodel::where('active', '1')
              ->with('bottommodels', function ($query) {
                  return $query->where('active', '1');
              })->first();                                
    }      

}
