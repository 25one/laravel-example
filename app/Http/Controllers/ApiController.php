<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApiRepository;
use App\Http\Requests\WidgetChatRequest;
use App\Http\Requests\ApiPromptRequest;

class ApiController extends Controller
{
    protected $apiRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiRepository $repositoryApi)
    {
        //$this->middleware('auth');

        $this->apiRepository = $repositoryApi;
    }

    /**
     * Make chat-question.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function widgetChatQuestion(WidgetChatRequest $request)
    {
        //ajax - not try catch -> js-catch
        return $this->apiRepository->chatQuestion($request, \Auth::id());
    }

    /**
     * Make prompt-execute.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function apiPromptExecute(ApiPromptRequest $request)
    {        
        if ($request->type == 'prompt') 
            try { //not ajax
                return $this->apiRepository->promptExecute($request); //$request->type; $request->token; $request->prompt; 
            } catch (\Exception $e) {
                return $e->getMessage();
            } 
        if ($request->type == 'project') 
            try {
                return $this->apiRepository->projectExecute($request);
            } catch (\Exception $e) {
                return $e->getMessage();
            }             
    }    

}
