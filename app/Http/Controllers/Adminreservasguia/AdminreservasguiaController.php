<?php

namespace App\Http\Controllers\Adminreservasguia;

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
use Illuminate\Support\Facades\Auth;
use App\Services\TraductionService;
use App\Services\MailService;

class AdminreservasguiaController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $guiaId = Auth::user()->id;
        $adminreservas = Reserva::with(['pedido', 'user', 'visit', 'language', 'hour'] )
        ->where('guia_id', $guiaId)
        ->orderByDesc('reservas.id')
        ->simplePaginate(10000);

        $hours= Hours::select('hours.*')->get();
        $categories= Category::select('categories.*')->get();
        $languages= Languages::with('isolanguages')->orderBy('id')->get();
        $tags= Tag::select('tags.*')->get();
        $hours= Hours::select('hours.*')->get();

        $diassemana = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo'
        ];

        return view('adminreservasguia.index', compact(['adminreservas', 'hours', 'languages', 'diassemana', 'categories', 'tags' ]));
    }




    public function rechazarreserva( Request $request )
    {
        try {
            $id = $request->input('id');
            if($id != null){
                $reserva = Reserva::findOrFail($id);

                $guiaold = User::where('rol_id', 2)
                ->where('id', $reserva->guia_id)->first();
                if ($guiaold) {
                    $guiaold->cuota = $guiaold->cuota + 1;
                    $guiaold->save();
                }
                //buscar guia con cuota menor  
                $guianew = User::where('rol_id', 2)
                ->orderBy('cuota', 'asc')
                ->orderBy('id', 'asc')
                ->first();
                if ($guianew) {
                    $reserva->guia_id = $guianew->id;
                }
                
                $reserva->save();
                
                //enviar correo a guia
                $nameguia = ($guianew->name ?? ' ') ." ". ($guianew->surname ?? ' ');
                $cliente = User::find($reserva->user_id);
                $namecliente = ($cliente?->name ?? ' ') ." ". ($cliente?->surname ?? ' ');
                $idioma = Languages::find($reserva->language_id)->name;
                $hora = Hours::find($reserva->visit_hours_id)->hora;
                $visita = Visitlanguages::find($reserva->visit_id)->where('language_id', $reserva->language_id)->first()->name;
                $textostraducidos = TraductionService::getTraduction($reserva->language_id);
                $textostraducidosadmin = TraductionService::getTraduction(1);
                $dataemail = array(
                    'textostraducidos' => $textostraducidos,
                    'namecliente' => $namecliente ?? '_',
                    'fecha' => $reserva->fecha ?? '_',
                    'hora' => $hora ?? '_',
                    'persons' => $reserva->persons ?? 0,
                    'idioma' => $idioma ?? '_',
                    'codigo' => $reserva->uuid ?? '_',
                    'visita' => $visita ?? '_',
                );
                
                MailService::sendEmailGuia($reserva, $hora, $visita, $idioma, $textostraducidos);
                MailService::sendEmailAdmins($reserva, $hora, $visita, $idioma, $textostraducidosadmin, true);
        
                return response()->json(['message' => 'Reserva rechazada con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al rechazar la reserva', 'message' => $e->getMessage()], 500);
        }
    }


    

}