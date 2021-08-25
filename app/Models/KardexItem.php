<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KardexItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function kardexReport() {
        return $this->belongsToMany(KardexReport::class);
    }
}
