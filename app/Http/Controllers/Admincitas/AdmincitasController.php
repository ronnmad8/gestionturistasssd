<?php

namespace App\Http\Controllers\Admincitas;

use App\Models\Reserva;
use App\Models\Visit;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitlanguages;
use App\Models\Franjashorarias;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\User;
use App\Models\Cita;
use App\Models\Statuscitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\TraductionService;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class AdmincitasController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $admincitas = Cita::select('citas.*'
        , Cita::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = 1 and visitlanguages.visit_id = citas.visit_id limit 1  ) as titulo ")
        , Cita::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = 1  and visitlanguages.visit_id = citas.visit_id  limit 1) as descripcion ")
        , Cita::raw("(SELECT concat(users.name,' ',users.surname, ' ', users.email) FROM users WHERE users.id = citas.guia_id  limit 1) as guia ")
        , Cita::raw("(SELECT languages.name FROM languages WHERE languages.id = citas.language_id  limit 1) as language ")
        , Cita::raw("(SELECT hours.hora FROM hours WHERE hours.id = citas.hours_id  limit 1) as hour ")
        )
        ->where('citas.deleted_at', NULL)
        ->get();

        $visits= Visit::select('visits.*')->get();
        $statuscitas= Statuscitas::select('statuscitas.*')->get();
        $guias= User::select('users.*')->where('rol_id', 2)->get();
        $idiomas= Languages::select('languages.*')->get();
        $franjashorarias = Franjashorarias::select('franjashorarias.*'
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.init_hours_id  limit 1) as hourinit ")
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.end_hours_id  limit 1) as hourend ")
        )->get();

        return view('admincitas.index', compact(['admincitas', 'statuscitas', 'visits','guias','franjashorarias','idiomas']));
    }


    public function setstatus(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'id' => 'required'
        ]);

        try {
        $cancelada = 4; //status candelada
        $status = $request->input('status');
        $id = $request->input('id');
        if($id != null){
            $c = Cita::select('citas.*')->findOrFail($id);
        
            if ( $request->input('status') != null ) {
                $c->status = $request->input('status');
            }

            if($c->status == $cancelada){

                //enviar correo a clientes de las reservas de la cita
                $reservas = Reserva::select('reservas.*')->where('cita_id', $id)->get();
                foreach ($reservas as $reservaanulada) {
                    $fecha = $c->fecha;
                    $diasemana = date('w', strtotime($fecha));
                    $visita = Visitlanguages::find($c->visit_id)->where('language_id', $c->language_id)->first()->name;
                    $visit = Visit::find($c->visit_id)->first();
                    $puntoencuentro = $visit->puntoencuentro;
                    $puntoencuentrotext = $visit->puntoencuentrotext;
                    $textostraducidos = TraductionService::getTraduction($c->language_id);

                    $user = User::find($reservaanulada->user_id);
                    $hora = Hours::find($c->hours_id)->hora;
                    $dataemail = array(
                        'textos' => $textostraducidos,
                        'name' => ($user->name ?? '_') ." ". ($user->surname ?? '_'),
                        'email' => $user->email ?? '_',
                        'reserva' => $reservaanulada,
                        'visita_nombre' => $visita,
                        'hora' => $hora
                    );
                    $subject = 'Reserva Anulada';
                    $viewName = 'emails.reservaanulada';
                    Mail::to($user->email)->send(new ContactMail($dataemail, $viewName, $subject));
                    Mail::to("ronnmad@hotmail.es")->send(new ContactMail($dataemail, $viewName, $subject));//ontest
                
                }
            }
            
            $update = $c->update();
            if($update != null){
                return response()->json($c);
            }
            else{
                return null;
            }
        }
        return response()->json(['error' => 'Visit not found'], 404);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear registro', 'message' => $e->getMessage()], 500);
        }
    }
    

    

}