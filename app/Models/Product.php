<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function stock() {
        return $this->belongsToMany(Branch::class, 'stock')
            ->withPivot('stock')
            ->wherePivot('branch_id', 1);
    }

    public function branches() {
        return $this->belongsToMany(Branch::class, 'stock');
    }

    public function prices() {
        return $this->hasMany(Price::class);
    }

    public function price() {
        return $this->hasOne(Price::class);
    }

    public function photos() {
        return $this->hasMany(Photo::class, 'product_id');
    }

    public function photo() {
        return $this->hasOne(Photo::class, 'product_id');
    }

    public function suppliers() {
        return $this->belongsToMany(Supplier::class);
    }

    public function category() {
        return $this->belongsTo(Category::class)->withDefault(['name' => 'Desconocido']);
    }

    public function brand() {
        return $this->belongsTo(Brand::class)->withDefault(['name' => 'Desconocido']);
    }

    public function kardexReport() {
        return $this->hasMany(KardexReport::class);
    }

    /**
     * Update stock product
     *
     * @param  int $id
     * @param  int $quantity
     * @param  bool $sum
     * @return int $updatedStock
     */
    public static function updateStock($id, $quantity, $sum = false) {
        $product = self::find($id);
        foreach ($product->stock as $i) {
            $product->stock()->updateExistingPivot(1, [
                'stock' => $sum ? $i->pivot->stock + $quantity : $i->pivot->stock - $quantity
            ]);
        }

        $product->refresh();

        foreach ($product->stock as $i) {
            return $i->pivot->stock;
        }
    }
}
