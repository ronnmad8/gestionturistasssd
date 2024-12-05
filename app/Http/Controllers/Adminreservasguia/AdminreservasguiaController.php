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
                \DB::beginTransaction();
                $reserva = Reserva::findOrFail($id);
                $guia = User::where('role', 'guia')
                ->where('id', '!=', $reserva->guia_id)
                ->inRandomOrder()->first();
                if ($guia) {
                    $reserva->guia_id = $guia->id; // Asignar guía a la reserva
                }
                else{
                    $reserva->guia_id = 0;
                }
            
                $reserva->save();

                \DB::commit();
        
                return response()->json(['message' => 'Reserva rechazada con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al rechazar la reserva', 'message' => $e->getMessage()], 500);
        }
    }


    

}