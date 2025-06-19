<?php

namespace App\Http\Controllers\Adminfacturacion;

use App\Models\Reserva;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\User;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Visit;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FacturacionExport;

class AdminfacturacionController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $admincitas = Reserva::select('reservas.*'
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = 1 and visitlanguages.visit_id = reservas.visit_id limit 1  ) as titulo ")
        , Visit::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = 1  and visitlanguages.visit_id = reservas.visit_id  limit 1) as descripcion ")
        , Visit::raw("(SELECT users.name FROM users WHERE users.id = reservas.guia_id  limit 1) as guia ")
        , Visit::raw("(SELECT users.name FROM users WHERE users.id = reservas.user_id  limit 1) as cliente ")
        , Visit::raw("(SELECT languages.name FROM languages WHERE languages.id = reservas.language_id  limit 1) as language ")
        , Visit::raw("(SELECT hours.hora FROM hours WHERE hours.id = reservas.visit_hours_id  limit 1) as hour ")
        )
        ->where('reservas.deleted_at', null)
        ->where('reservas.status', 1)
        ->get();

        $visits= Visit::select('visits.*')->get();
        $guias= User::select('users.*')->where('rol_id', 2)->get();
        $meses= [
            0 => 'enero',
            1 => 'febrero',
            2 => 'marzo',
            3 => 'abril',
            4 => 'mayo',
            5 => 'junio',
            6 => 'julio',
            7 => 'agosto',
            8 => 'septiembre',
            9 => 'octubre',
            10 => 'noviembre',
            11 => 'diciembre'
        ];

        return view('adminfacturacion.index', compact(['admincitas', 'visits','guias','meses' ]));
    }

    
    public function excelfacturacion($mes)
    {

        $meses= [
            0 => 'enero',
            1 => 'febrero',
            2 => 'marzo',
            3 => 'abril',
            4 => 'mayo',
            5 => 'junio',
            6 => 'julio',
            7 => 'agosto',
            8 => 'septiembre',
            9 => 'octubre',
            10 => 'noviembre',
            11 => 'diciembre'
        ];

        $filtAdmincitasTable = Reserva::select('reservas.total as cantidad', 'reservas.id as ref' 
        , Visit::raw("(SELECT CONCAT(users.name,' ', users.surname, ' - ', users.email) FROM users WHERE users.id = reservas.guia_id  limit 1) as guia ")
        , Visit::raw("(SELECT CONCAT(users.name,' ', users.surname, ' - ', users.email)  FROM users WHERE users.id = reservas.user_id  limit 1) as cliente ")
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = 1 and visitlanguages.visit_id = reservas.visit_id limit 1  ) as visita ")
        , Visit::raw("(SELECT languages.name FROM languages WHERE languages.id = reservas.language_id  limit 1) as idioma ")
        , 'reservas.fecha'
        , Visit::raw("(SELECT hours.hora FROM hours WHERE hours.id = reservas.visit_hours_id  limit 1) as hora ")
        )
        ->where('reservas.deleted_at', null)
        ->where('reservas.status', 1)
        ->whereMonth('reservas.fecha', '=', $mes)
        ->get();

        $filtAdmincitas = $filtAdmincitasTable->toArray();

        return Excel::download(new FacturacionExport($filtAdmincitas), 'facturacion-'.$meses[$mes].'.xlsx');
    }


    

}