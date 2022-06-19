<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLeadResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $docName;
    public $docSurname;
    public $name;
    public $date;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_name, $_docName, $_docSurname, $_date, $_content)
    {
        //
        $this->name = $_name;
        $this->docName = $_docName;
        $this->docSurname = $_docSurname;
        $this->date=$_date;
        $this->content = $_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.newLeadResponse');
    }
}
