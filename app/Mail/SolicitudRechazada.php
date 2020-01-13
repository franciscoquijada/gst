<?php

namespace App\Mail;

use App\Request_oc;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudRechazada extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Orden de Compra Rechazada";
    public $valores;
    public $detalles;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($values)
    {
        $this->valores = $values;
        $this->detalles = Request_oc::find($values->req_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.solicitud_rechazada');
    }
}
