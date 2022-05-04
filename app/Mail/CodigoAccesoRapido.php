<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoAccesoRapido extends Mailable
{
    use Queueable, SerializesModels;
    public $title = "Codigo Acceso Rápido";
    public $nombre;
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $code)
    {
        $this->title = $this->title;
        $this->nombre = $nombre;
        $this->code = $code;
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
        $code = $this->code;
        return $this->view('mails.codigo_acceso_rapido', compact('nombre','code'))->subject($title);
    }
}
