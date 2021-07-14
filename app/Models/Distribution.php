<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribution extends Model
{
    use HasFactory;
    use SoftDeletes;

    //Allow mass assigment
    protected $guarded = [];

    public function prices()
    {
        return $this->hasMany(Price::class, 'distribution_id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
