<?php

namespace App\Listeners;

use Throwable;
use App\Events\SendMail;
// use Illuminate\Support\Facades\Mail;
use App\Mail\RequestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        try {
            Mail::to($event->data->to)->send(
                new RequestMail($event->data)
            );
        } catch (\Throwable $th) {
            //logger
            return true;
        }
    }
}
