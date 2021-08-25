<?php

namespace App\Jobs;

<<<<<<< HEAD
use Barryvdh\DomPDF\Facade as PDF;
=======
>>>>>>> database
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
<<<<<<< HEAD
=======
use PDF;
>>>>>>> database

class CreateInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $view;
<<<<<<< HEAD
    protected $path;
    protected $id;
=======
    protected $fileName;
>>>>>>> database
    /**
     * Create a new job instance.
     *
     * @return void
     */
<<<<<<< HEAD
    public function __construct($view, $path, $id)
    {
        $this->view = $view;
        $this->path = $path;
        $this->id = $id;
=======
    public function __construct($view, $fileName)
    {
        $this->view = $view;
        $this->fileName = $fileName;
>>>>>>> database
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
<<<<<<< HEAD
        PDF::loadHTML($this->view)->save(public_path($this->path) . $this->id . '.pdf');
=======
        PDF::loadHTML($this->view)->save(public_path('storage/invoices/') . $this->fileName . '.pdf');
>>>>>>> database
    }
}
