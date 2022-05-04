<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $title = "Recuperar contraseña";
    public $nombre;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $url)
    {
        $this->title = $this->title;
        $this->nombre = $nombre;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->title;
        $nombre   = $this->nombre;
        $url = $this->url;
        return $this->view('mails.recuperar_password', compact('nombre','url'))->subject($title);
    }
}
