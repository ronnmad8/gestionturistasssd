<?php

namespace App\Http\Controllers\Adminfacturacion;

use App\Models\Reserva;
use App\Models\Visit;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitlanguages;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    

    

}