<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Make to remove user account.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeAccount(Request $request)
    {
        $user = auth()->user();

        $user->delete();

        auth()->logout();
    }

}
