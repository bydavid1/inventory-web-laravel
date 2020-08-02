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

    public function purchase_prices(){
        return $this->hasMany("App\Purchase_prices", 'product_id');
    }

    public function first_image(){
        return $this->hasOne("App\Images", 'product_id');
    }

    public function first_price(){
        return $this->hasOne("App\Prices", 'product_id');
    }
}
