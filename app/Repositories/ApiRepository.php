<?php

namespace App\Repositories;

use App\Models\ {
    Description

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
    protected $promptRepository;

    /**
     * Create a new PromptRepository instance.
     *
     */
    public function __construct(Description $description, PromptRepository $repositoryPrompt)
    {
        $this->modelDescription = $description;
        $this->promptRepository = $repositoryPrompt;
    }

    /**
     * Make chat question.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function chatQuestion($request, $userId)
    {
       $description = Description::where('user_id', $userId)
                         ->first(); 

       $prompt  = str_replace('#prompt#', $request->prompt, $description->description); 

       return $this->promptRepository->execute($prompt);
    }    


}
