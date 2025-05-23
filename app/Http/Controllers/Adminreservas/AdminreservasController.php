<?php

namespace App\Http\Controllers\Adminreservas;

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
use App\Models\Cita;
use App\Models\Disponibility;
use App\Models\Nodisponibility;
use App\Models\Guia;
use App\Models\Guialanguages;
use App\Models\Configuraciones;
use App\Models\Guiavisits;
use App\Models\Franjashorarias;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use carbon\Carbon;
use App\Services\TraductionService;
use App\Services\MailService;
use Illuminate\Support\Facades\Mail;

class AdminreservasController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $adminreservas = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )
        ->orderByDesc('reservas.id')
        ->simplePaginate(10000);

        $hours= Hours::select('hours.*')->get();
        $categories= Category::select('categories.*')->get();
        $languages= Languages::with('isolanguages')->orderBy('id') ->get();
        $tags= Tag::select('tags.*')->get();
        $hours= Hours::select('hours.*')->get();
        $users= User::select('users.*')->where('rol_id', 1)->get();
        $guias= User::select('users.*')->where('rol_id', 2)->get();

        $visits= Visit::select('visits.*')->get();


        $diassemana = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo'
        ];

        return view('adminreservas.index', compact(['adminreservas','visits', 'hours', 'languages', 'diassemana', 'categories', 'tags', 'users', 'guias'  ]));
    }



    public function updatereserva(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'language_id' => 'required',
            'adults' => 'required|numeric|min:0',
            'children' => 'required|numeric|min:0',
        ]);

        try {

        $id = $request->input('id');
        if($id != null){
            $reserva = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )->findOrFail($id);
        
            if ( $request->input('user_id') != null ) {
                $reserva->user_id = $request->input('user_id');
            }
            if ( $request->input('language_id') != null ) {
                $reserva->language_id = $request->input('language_id');
            }
            if ( $request->input('adults') != null) {
                $reserva->adults = $request->input('adults');
            }
            if ( $request->input('children') != null ) {
                $reserva->children = $request->input('children');
            }
            if ( $request->input('private') != null ) {
                $reserva->private = $request->input('private');
            }
            if ( $request->input('status') != null ) {
                $reserva->status = $request->input('status');
            }

            $reserva->persons = $reserva->adults + $reserva->children;

            if($reserva->update()){
                return response()->json($reserva);
            }
            else{
                return null;
            }
        }
        return response()->json(['error' => 'Visit not found'], 404);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }

    public function setguia(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'guia_id' => 'required'
        ]);

        try {

        $id = $request->input('id');
        if($id != null){
            
            $reserva = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )->findOrFail($id);
        
            if ( $request->input('guia_id') != null ) {
                $reserva->guia_id = $request->input('guia_id');
            }
            
            if($reserva->update()){

                //actualizar las reservas con misma cita
                $reservas = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )
                ->where('deleted_at', null)
                ->where('cita_id', $reserva->cita_id)
                ->get();

                foreach ($reservas as $re) {
                    $re->guia_id = $guia->id;
                    $re->update();
                }

                $cita = Cita::where('id', $reserva->cita_id)->first();
                $cita->guia_id = $guia->id;
                $cita->update();

                return response()->json(true);
            }
            else{
                return null;
            }
        }
        return response()->json(['error' => 'Visit not found'], 404);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }


    public function setguiacita(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'guia_id' => 'required'
        ]);

        try {
            $id = $request->input('id');
            $guiaid = $request->input('guia_id');
            if($id != null){

                $cita = Cita::where('id', $id)->first();
                    $cita->guia_id = $guiaid;
                    $cita->update();
            
                //actualizar las reservas con misma cita
                $reservas = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )
                ->where('deleted_at', null)
                ->where('cita_id', $id)
                ->get();

                foreach ($reservas as $re) {
                    $re->guia_id = $guiaid;
                    $re->update();
                }

                return response()->json(true);
            }
            return response()->json(['error' => 'Cita not found'], 404);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }


    public function sorteo()
    {
        $diasretro= Configuraciones::where('name', 'sorteo')->first()->value; //dato de configuraciones => sorteo

        try 
        {
            $now = Carbon::now()->format('Y-m-d');
            $limiteFecha = Carbon::now()->addDays($diasretro)->format('Y-m-d');

            $citas = Cita::where('guia_id', null)
            ->where('deleted_at', null)
            ->whereColumn('clients', '>=', 'min')
            ->whereDate('fecha', '>=', $now)
            ->whereDate('fecha', '<=', $limiteFecha)
            ->get();

            $citasmin = Cita::where('guia_id', null)
            ->where('deleted_at', null)
            ->whereColumn('clients', '<', 'min')
            ->whereDate('fecha', '>=', $now)
            ->whereDate('fecha', '<=', $limiteFecha)
            ->get();


            foreach ($citas as $cita) {
                $fecha = Carbon::parse($cita->fecha)->format('Y-m-d');
                $diasemana = date('w', strtotime($fecha));
                $disponibilities = Disponibility::select('disponibilities.user_id' )
                ->join('franjashorarias', 'franjashorarias.id', 'disponibilities.franjahoraria_id')
                ->whereIn('disponibilities.user_id', function ($query) use ($cita) {
                    $query->select('user_id')
                        ->from('guialanguages')
                        ->where('language_id', $cita->language_id);
                })
                ->whereIn('disponibilities.user_id', function ($query) use ($cita) {
                    $query->select('user_id')
                        ->from('guiavisits')
                        ->where('visit_id', $cita->visit_id);
                })
                ->where('disponibilities.diasemana', $diasemana)
                ->where('franjashorarias.init_hours_id', '<=', (int)$cita->hours_id)
                ->where('franjashorarias.end_hours_id', '>=', (int)$cita->hours_id)
                ->distinct('disponibilities.user_id')
                ->pluck('disponibilities.user_id')
                ->toArray();

                $nodisponibilities = Nodisponibility::select('nodisponibilities.user_id')
                ->where('nodisponibilities.fecha', '=', $cita->fecha)
                ->pluck('user_id')
                ->toArray();

                $guia = User::where('rol_id', 2)
                ->whereNotIn('id', $nodisponibilities)
                ->orderBy('cuota', 'asc')
                ->orderBy('id', 'asc')
                ->first();

                if ($guia) {
                    $guia->cuota = ($guia->cuota ?? 0) + 1;
                    $guia->update();
                    $cita->guia_id = $guia->id;
                    $cita->update();

                    $reservas = Reserva::where('deleted_at', null)
                        ->where('cita_id', $cita->id)
                        ->get();

                    if ($reservas->isNotEmpty()) {
                        foreach ($reservas as $re) {
                            $re->guia_id = $guia->id;
                            $re->update();
                        }
                    }

                    //enviar email a guia
                    $fecha = $cita->fecha;
                    $diasemana = date('w', strtotime($fecha));
                    $visita = Visitlanguages::find($cita->visit_id)->where('language_id', $cita->language_id)->first()->name;
                    $visit = Visit::find($cita->visit_id)->first();
                    $hora = Hours::find($cita->hours_id)->hora;
                    $puntoencuentro = $visit->puntoencuentro;
                    $puntoencuentrotext = $visit->puntoencuentrotext;
                    $textostraducidos = TraductionService::getTraduction($cita->language_id);
                    $textostraducidosadmin = TraductionService::getTraduction(1);
                    $idioma = Languages::find($cita->language_id)->name;

                    MailService::sendEmailGuia($cita, $reservas, $hora, $visita, $idioma, $textostraducidos,$puntoencuentro, $puntoencuentrotext);
                }

            }


            //enviar correo a cliente por anulacion de cita
            if ($citasmin != null) {
              foreach ($citasmin as $cita) {
                $fecha = $cita->fecha;
                $diasemana = date('w', strtotime($fecha));
                $visita = Visitlanguages::find($cita->visit_id)->where('language_id', $cita->language_id)->first()->name;
                $visit = Visit::find($cita->visit_id)->first();
                $puntoencuentro = $visit->puntoencuentro;
                $puntoencuentrotext = $visit->puntoencuentrotext;
                $textostraducidos = TraductionService::getTraduction($cita->language_id);
                $reservaanulada = Reserva::where('deleted_at', null)
                ->where('cita_id', $cita->id)
                ->first();
                $user = User::find($reservaanulada->user_id);
                $hora = Hours::find($cita->hours_id)->hora;
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

            return response()->json(true);

        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }





    public function deletereserva( Request $request )
    {
        try {
            $id = $request->input('id');
            if($id != null){
                \DB::beginTransaction();
                $reserva = Reserva::findOrFail($id);
                $reserva->delete();

                \DB::commit();
        
                return response()->json(['message' => 'Reserva eliminada con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la visita', 'message' => $e->getMessage()], 500);
        }
    }


    

}