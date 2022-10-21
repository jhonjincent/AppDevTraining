<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'detail', 'department', 'company',
    ];

    public function owner(){
        return $this->hasOne('App\Owner');
    }

    public function attachment(){
        return $this->hasOne('App\Attachment');
    }

    public function comment(){
        return $this->hasOne('App\Comment');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
