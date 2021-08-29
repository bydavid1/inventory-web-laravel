<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Kardex extends Model
{
    protected $table = 'kardex';

    public function type() {
        return $this->belongsTo('App\Kardex_tag');
    }
}
