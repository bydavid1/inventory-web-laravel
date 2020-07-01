<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Products');
    }
}
