<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_items extends Model
{
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
