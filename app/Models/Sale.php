<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function customer() {
        return $this->hasOne(Customer::class);
    }

    public function invoice() {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }
}
