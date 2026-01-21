<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model {

    /**
     * Get the created_at.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prompts()
    {
        return $this->hasMany(Prompt::class)->orderBy('number');
    }
    
    public function promptsActive()
    {
        return $this->hasMany(Prompt::class)->where('active', '1')->orderBy('number');
    }      

}
