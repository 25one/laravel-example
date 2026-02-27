<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Key extends Model {

    /**
     * Get the api_key.
     *
     * @param  string  $value
     * @return string
     */
    public function getApiKeyAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set the api_key.
     *
     * @param  string  $value
     * @return string
     */
    public function setApiKeyAttribute($value)
    {
        $this->attributes['api_key'] = encrypt($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topmodel()
    {
        return $this->belongsTo(Topmodel::class);
    }  
    
    public function userKeyTopmodel($topmodelId)
    {
        return $this->where('user_id', auth()->user()->id)
                    ->where('topmodel_id', $topmodelId)
                    ->first();
    } 
    
    public function userKeys()
    {
        return $this->where('user_id', auth()->user()->id)
                    ->get();
    } 
    
    public function userKeysActive()
    {
        return $this->where('user_id', auth()->user()->id)
                    ->where('active', '1') 
                    ->get();
    }     

}
