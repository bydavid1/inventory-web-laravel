<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturers extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
