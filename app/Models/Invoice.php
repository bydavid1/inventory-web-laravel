<?php

namespace App\Models;

use App\Jobs\CreateInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\View;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function invoiceable() {
        return $this->morphTo();
    }

    public static function invoiceToPDF($products, $object, $customer, $fileName) {

        //Render invoice
        $view = View::make('pages.pdf.invoice', compact('object', 'products', 'customer'))->render();
        //Creating PDF
        CreateInvoice::dispatch($view, $fileName);
        return $view;
    }
}
