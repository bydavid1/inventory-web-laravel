<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    public function prices(){
        return $this->hasMany("App\Models\Prices", 'product_id');
    }

    public function images(){
        return $this->hasMany("App\Models\Images", 'product_id');
    }

    public function purchase_prices(){
        return $this->hasMany("App\Models\Purchase_prices", 'product_id');
    }

    public function first_purchase_price(){
        return $this->hasOne("App\Models\Purchase_prices", 'product_id');
    }

    public function first_image(){
        return $this->hasOne("App\Models\Images", 'product_id');
    }

    public function first_price(){
        return $this->hasOne("App\Models\Prices", 'product_id');
    }
}
