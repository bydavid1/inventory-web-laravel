<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function distributions() {
        return $this->hasMany(Distribution::class, 'product_id');
    }

    public function images() {
        return $this->hasMany(Photo::class, 'product_id');
    }

    public function first_image() {
        return $this->hasOne(Photo::class, 'product_id');
    }

}
