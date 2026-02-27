<?php

namespace App\Http\Middleware;

use Closure;

class KeyReceived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
       
        if ($user && count($user->keysActive)) {
            $keyActiveFirst = $user->keysActive->first();
            $request->merge(['variantAI' => $keyActiveFirst->topmodel->model]);
            $request->merge(['api_key' => $keyActiveFirst->api_key]);
            return $next($request);
        }
        
        if ($user && $user->demo_count) {
            $request->merge(['variantAI' => 'OpenAI']); //...then...
            $request->merge(['api_key' => config('services.ai_api_key.openai')]); //...then...
            return $next($request);            
        }

        return response()->json(['message' => 'You no longer have demo tokens. Add api_key to your profile to access the model'], 500);        
    }
}
