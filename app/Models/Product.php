<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function prices(){
        return $this->hasMany("App\Models\Price", 'product_id');
    }

    public function images(){
        return $this->hasMany("App\Models\Photo", 'product_id');
    }

    public function first_image(){
        return $this->hasOne("App\Models\Photo", 'product_id');
    }

    public function first_price(){
        return $this->hasOne("App\Models\Price", 'product_id');
    }
}
