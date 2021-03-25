<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    public function products()
    {
        return $this->belongsTo('App\Products');
    }
}
