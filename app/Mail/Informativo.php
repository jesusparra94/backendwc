<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Informativo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.notificacion_servicios')
        ->subject('Conócenos | Somos WebCompany SpA')
        ->attach(public_path() . '/Web-Company-SpA-Planes-Hosting.pdf', [
            'mime' => 'application/pdf',
         ]);
    }
}
