<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroCliente extends Mailable
{
    use Queueable, SerializesModels;
    public $title = "Bienvenido a Creattiva Datacenter";
    public $nombre;
    public $correo;
    public $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre,$correo,$pass)
    {
        //
        $this->title = $this->title;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->pass = $pass;
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
        $correo = $this->correo;
        $pass = $this->pass;

        return $this->view('mails.nuevo_cliente', compact('nombre','correo','pass'))->subject($title);
    }
}
