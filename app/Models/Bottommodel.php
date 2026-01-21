<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bottommodel extends Model {

    public function topmodel()
    {
        return $this->belongsTo(Topmodel::class);
    }

}
