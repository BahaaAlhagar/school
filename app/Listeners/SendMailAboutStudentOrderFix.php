<?php

namespace App\Listeners;

use App\Mail\StudentOrderFixedMail;
use Illuminate\Support\Facades\Mail;

class SendMailAboutStudentOrderFix
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to('admin@example.com')
            ->queue(new StudentOrderFixedMail());
    }
}
