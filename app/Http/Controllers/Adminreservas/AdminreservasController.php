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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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


        $diassemana = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo'
        ];

        return view('adminreservas.index', compact(['adminreservas', 'hours', 'languages', 'diassemana', 'categories', 'tags', 'users', 'guias'  ]));
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