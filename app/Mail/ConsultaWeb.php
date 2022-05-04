<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultaWeb extends Mailable
{
    use Queueable, SerializesModels;
    public $nombre;
    public $email;
    public $telefono;
    public $mensaje;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre,$email,$telefono,$mensaje,$user)
    {
        //
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->mensaje = $mensaje;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $nombre = $this->nombre;
        $email = $this->email;
        $telefono = $this->telefono;
        $mensaje = $this->mensaje;
        $user = $this->user;

        return $this->view('mails.consulta_web', compact('nombre','email','telefono','mensaje','user'))->subject('Consulta desde Sitio Web | '.$email);
    }
}
