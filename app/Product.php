<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'detail'
    ];

    public function type(){
        return $this -> belongsTo('App\type', 'id', 'type_id');
    }
}
