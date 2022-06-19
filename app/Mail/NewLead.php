<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLead extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $doctorName;
    public $doctorSurname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_lead, $_doctorName, $_doctorSurname)
    {
        $this->lead = $_lead;
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
        return $this->view('Email.newLead');
    }
}
