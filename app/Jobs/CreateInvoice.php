<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PDF;

class CreateInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $view;
    protected $path;
    protected $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($view, $path, $fileName)
    {
        $this->view = $view;
        $this->path = $path;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        PDF::loadHTML($this->view)->save(public_path($this->path) . $this->fileName . '.pdf');
    }
}
