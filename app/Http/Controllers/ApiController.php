<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApiRepository;
use App\Http\Requests\WidgetChatRequest;

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
        return $this->apiRepository->chatQuestion($request, \Auth::id());
    }

}
