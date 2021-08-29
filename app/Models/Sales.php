<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{

    public function invoice(){
        return $this->hasOne('App\Models\Invoices', 'sale_id');
    }
}
