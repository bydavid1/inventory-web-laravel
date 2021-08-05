<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POS extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pos';
    public $timestamps = false;
}
