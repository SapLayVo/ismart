<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'content','content_not_mark', 'price','product_img','discount','category','country','trademark'
    ];

    function users(){
        return $this->belongsToMany('App\User');
    }
}
