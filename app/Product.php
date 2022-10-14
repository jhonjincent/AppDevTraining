<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'detail'
    ];

    public function type(){
        return $this -> hasOne('App\Type');
    }

    public function types(){
        return $this-> hasMany('App\Type');
    }

    public function attachment(){
        return $this-> hasOne('App\Attachment');
    }
}
