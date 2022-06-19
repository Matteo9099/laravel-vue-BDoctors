<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReview extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public $doctorName;
    public $doctorSurname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_review, $_doctorName, $_doctorSurname)
    {
        //
        $this->review = $_review;
        $this->doctorName = $_doctorName;
        $this->doctorSurname = $_doctorSurname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.newReview');
    }
}
