<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topmodel;
use App\Models\Key;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SaveApiKeyRequest;
use App\Http\Requests\RemoveApiKeyRequest;

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
     * Get data auth-user.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getData(Request $request)
    {
        $user = User::with('keys.topmodel')->find(auth()->user()->id);
        $topmodels = Topmodel::get();

        return ['user' => $user, 'topmodels' => $topmodels];
    }    

    /**
     * Save auth-api_key.
     *
     * @return \Illuminate\View\View
     */
    public function saveApikey(SaveApiKeyRequest $request, Key $key)
    {
        $userKey = $key->userKeyTopmodel($request->topmodelId);                  

        if ($userKey) {
           $userKey->api_key = $request->apiKey;
           $userKey->active = $request->active;

           $userKey->save();

           $api_key = $userKey->api_key;
           $active = $userKey->active;
        } else {
           $key->user_id = auth()->user()->id; 
           $key->topmodel_id = $request->topmodelId;
           $key->api_key = $request->apiKey;
           $key->active = $request->active;

           $key->save();

           $api_key = $key->api_key;
           $active = $key->active;
        }          
        return ['userKeys' => $key->userKeys(), 'api_key' => $api_key, 'active' => $active, 'activeCheck' => $this->checkApikeyActive($key)];
    }  

    /**
     * Remove auth-api_key.
     *
     * @return \Illuminate\View\View
     */
    public function removeApikey(RemoveApiKeyRequest $request, Key $key)
    {                         
        $userKey = $key->userKeyTopmodel($request->topmodelId);                  
        
        $userKey->delete();

        return ['userKeys' => $key->userKeys(), 'api_key' => '', 'active' => '0', 'activeCheck' => $this->checkApikeyActive($key)];
    }     
    
    /**
     * Check active-auth-api_key.
     *
     * @return \Illuminate\View\View
     */
    //public function removeApikey(RemoveApiKeyRequest $request, Topmodel $topmodel)
    public function checkApikeyActive(Key $key) //+RemoveApiKeyRequest - validate
    {
        $userKeysActive = $key->userKeysActive();
        
        if (! count($userKeysActive)) {
           return ['icon' => 'error', 'text' => 'You do not have any activated keys! Add or activate a key!'];
        } else if (count($userKeysActive) > 1) {
           return ['icon' => 'error', 'text' => 'Several keys have been activated! Activate one of them!'];
        } else {
           return ['icon' => 'success', 'text' => 'The list of keys has been updated'];
        }
    }          

    /**
     * Change password auth-user.
     *
     * @return \Illuminate\View\View
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        $user->password = \Hash::make($request->password);
        $user->save();  
        
        auth()->logout();
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
