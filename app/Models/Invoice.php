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

    public static function getLastInvoiceNumber($invoiceType) {
        $lastInvoice = Invoice::latest()->where('invoice_type', $invoiceType)->first();
        $newNumber = 0;

        if ($lastInvoice) {
            $newNumber = str_pad($lastInvoice->invoice_num + 1, 10, '0', STR_PAD_LEFT);
        }else{
            $newNumber = str_pad('1', 10, '0', STR_PAD_LEFT); //first invoice
        }

        return $newNumber;
    }
}
