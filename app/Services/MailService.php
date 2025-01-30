<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Languages;
use App\Models\Hours;
use App\Models\Visitlanguages;

use App\Transformers\PedidoTransformer;
use Illuminate\Support\Str;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class MailService
{

    public static function sendEmailGuia($reserva, $hora, $visita, $idioma, $textostraducidos, $puntoencuentro, $puntoencuentrotext)
    {
        $guiaemail = User::find($reserva->guia_id)->email;
        $cliente = User::find($reserva->user_id);
        $namecliente = ($cliente?->name ?? ' ') ." ". ($cliente?->surname ?? ' ');

        $dataemail = array(
            'textostraducidos' => $textostraducidos,
            'namecliente' => $namecliente ?? '_',
            'fecha' => $reserva->fecha ?? '_',
            'hora' => $hora ?? '_',
            'persons' => $reserva->persons ?? 0,
            'idioma' => $idioma ?? '_',
            'codigo' => $reserva->uuid ?? '_',
            'visita' => $visita ?? '_',
            'puntoencuentro' => $puntoencuentro ?? '_',
            'puntoencuentrotext' => $puntoencuentrotext ?? '_'
        );
        $subject = 'Reserva asignada';
        $viewName = 'emails.reservaguia';
        Mail::to($guiaemail)->send(new ContactMail($dataemail, $viewName, $subject));
    }


    public static function sendEmailAdmins($reserva, $hora, $visita, $idioma, $textostraducidos, $puntoencuentro, $puntoencuentrotext, $reasignation = false)
    {
        $guia = User::find($reserva->guia_id);
        $nameguia = ($guia->name ?? ' ') ." ". ($guia->surname ?? ' ');
        $cliente = User::find($reserva->user_id);
        $namecliente = ($cliente?->name ?? ' ') ." ". ($cliente?->surname ?? ' ');

        $dataemail = array(
            'textostraducidos' => $textostraducidos,
            'namecliente' => $namecliente ?? '_',
            'nameguia' => $nameguia ?? '_',
            'fecha' => $reserva->fecha ?? '_',
            'hora' => $hora ?? '_',
            'persons' => $reserva->persons ?? 0,
            'idioma' => $idioma ?? '_',
            'codigo' => $reserva->uuid ?? '_',
            'visita' => $visita ?? '_',
            'puntoencuentro' => $puntoencuentro ?? '_',
            'puntoencuentrotext' => $puntoencuentrotext ?? '_',
        );
        $subject = 'Reserva de ' . $namecliente . ' asignada a ' . $nameguia;
        if ($reasignation == true) {
            $subject = 'Reserva de ' . $namecliente . ' ¡reasignada! a ' . $nameguia;
        }

        $viewName = 'emails.reservaadmins';

        //listar emails de los admin
        Mail::to($_ENV['MAIL_ADMIN0'])->send(new ContactMail($dataemail, $viewName, $subject));
        // Mail::to($_ENV['MAIL_ADMIN1'])->send(new ContactMail($dataemail, $viewName, $subject));
        // Mail::to($_ENV['MAIL_ADMIN2'])->send(new ContactMail($dataemail, $viewName, $subject));
        // Mail::to($_ENV['MAIL_ADMIN3'])->send(new ContactMail($dataemail, $viewName, $subject));
    }

}

