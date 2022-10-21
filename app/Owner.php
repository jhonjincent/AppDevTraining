<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'report_id', 'name', 'postedby',
    ];

    public function postedbyinfo(){
        return $this->belongsTo('App\User', 'postedby', 'id');
    }
}
