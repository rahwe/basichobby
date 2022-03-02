<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    protected $fillable = ['title', 'description', 'user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }



    public function tags(){
        return $this->belongsToMany('App\Tag');
    }


    
}
