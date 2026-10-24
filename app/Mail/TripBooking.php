<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TripBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.trip-booking')
            ->to(config('app.email'), config('app.name'))
            ->replyTo($this->request->text_email, $this->request->text_fname . " " . $this->request->text_lname)
            ->subject('Inquiry from ' . config('app.name'));
    }
}
