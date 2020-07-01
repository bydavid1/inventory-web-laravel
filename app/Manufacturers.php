<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturers extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Products');
    }
}
