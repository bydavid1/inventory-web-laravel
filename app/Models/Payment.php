<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    //Allow mass assigment
    protected $guarded = [];

    public function sale() {
        return $this->hasOne(Sale::class);
    }
}
