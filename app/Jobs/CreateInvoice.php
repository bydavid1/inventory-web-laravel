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
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($view, $path, $id)
    {
        $this->view = $view;
        $this->path = $path;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdf = PDF::loadHTML($this->view)->save(public_path($this->path) . $this->id . '.pdf');
    }
}
