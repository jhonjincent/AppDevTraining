<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'branch'
    ];

    public function address(){
        return $this -> hasOne('App\Address');
    }

    public function addresses(){
        return $this-> hasMany('App\Address');
    }

    public function custattachment(){
        return $this-> hasOne('App\Custattachment');
    }
}
