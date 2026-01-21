<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topmodel extends Model {

    public function bottommodels()
    {
        return $this->hasMany(Bottommodel::class);
    }

}
