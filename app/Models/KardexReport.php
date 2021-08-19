<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KardexReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function records() {
        return $this->hasMany(KardexItem::class);
    }
}
