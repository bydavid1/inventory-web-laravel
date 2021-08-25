<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function invoice() {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    public function items() {
        return $this->hasMany(PurchaseItem::class);
    }
}
