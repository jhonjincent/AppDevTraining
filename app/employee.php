<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'position', 'date_hired'
    ];
}
