<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custattachment extends Model
{
    protected $fillable = [
        'customer_id', 'path'
    ];
}
