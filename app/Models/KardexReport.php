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

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function lastItem() {
        return $this->hasOne(KardexItem::class)->latest();
    }

    /**
     * Get las report where end_date is null.
     *
     * @param int $productId
     * @return \App\Models\KardexReport
     */
    public static function getOpenedReport($productId) {
        $report = KardexReport::where('product_id', $productId)->latest()->first();

        if ($report && $report->end_date == null) {
            return $report;
        }
    }
}
