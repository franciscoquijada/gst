<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Request_oc;
use App\Bank;

class SolicitudCreada extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Solicitud de Orden de Compra Creada";
    public $solicitud;
    public $bank;
    public $status;
    public $cat;
    public $pay;
    public $ca;
    public $solic;
    public $oc;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($e_solicitud)
    {
        $this->solicitud = $e_solicitud;

        $b=Bank::find($e_solicitud->attr['supplier']->bank_id);
        $c = Request_oc::with('costo','req_status','categoria','pago','account','user')->find($e_solicitud->id);

        $this->bank = $b->name;
        $this->oc = $c->costo->name;
        $this->status = 'Pendiente';
        $this->cat = $c->categoria->name;
        $this->pay = $c->pago->name;
        $this->ca = $c->account->name;
        $this->solic = $c->user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.solicitud_creada');
    }
}
