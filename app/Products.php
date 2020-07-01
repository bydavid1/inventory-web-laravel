<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    public function prices(){
        return $this->hasMany("App\Prices", 'product_id');
    }

    public function images(){
        return $this->hasMany("App\Images", 'product_id');
    }

    public function purchases_prices(){
        return $this->hasMany("App\Purchases_prices", 'product_id');
    }
}
