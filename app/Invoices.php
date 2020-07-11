<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    //
    protected $guarded = [];

    public function sale(){
        return $this->belongsTo('App\Sales', 'sale_id');
    }
}
