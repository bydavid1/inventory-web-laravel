<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    //Allow mass assigment
    protected $guarded = [];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }
}
