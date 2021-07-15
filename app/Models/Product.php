<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function stock() {
        return $this->belongsToMany(Branch::class, 'stock');
    }

    public function prices() {
        return $this->hasMany(Price::class);
    }

    public function images() {
        return $this->hasMany(Photo::class, 'product_id');
    }

    public function photo() {
        return $this->hasOne(Photo::class, 'product_id');
    }

}
