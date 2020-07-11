<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{

    public function invoice(){
        return $this->hasOne('App\Invoices', 'sale_id');
    }
}
