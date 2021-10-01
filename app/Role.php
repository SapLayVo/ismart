<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    //
    function users(){
        return $this->hasMany('App\User');
    }
}
