<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCompra extends Mailable
{
    use Queueable, SerializesModels;
    public $title = "Conformación de Compra";
    public $codigo;
    public $venta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo,$venta)
    {
        //
        $this->title = $this->title;
        $this->codigo = $codigo;
        $this->venta = $venta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->title;
        $codigo   = $this->codigo;
        $venta = $this->venta;

        return $this->view('mails.invoice', compact('codigo','venta'))->subject($title);
    }
}
