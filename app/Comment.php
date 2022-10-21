<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'report_id', 'com', 'commentby'
    ];

    public function commentbyinfo(){
        return $this->belongsTo('App\User', 'commentby', 'id');
    }
}
