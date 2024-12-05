<?php

namespace App\Http\Controllers\Adminguias;

use App\Models\Reserva;
use App\Models\Franjashorarias;
use App\Models\Guia;
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

class AdminguiasController extends Controller
{

    public function index()
    {        
        $adminguias = User::select('users.*')
        ->with('disponibilities')
        ->with('nodisponibilities')
        
        ->where('rol_id', 2)
        ->get() ?? new User();



        $hours= Hours::select('hours.*')->get();
        $franjashorarias= Franjashorarias::select('franjashorarias.*'
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.init_hours_id  limit 1) as hourinit ")
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.end_hours_id  limit 1) as hourend ")
        )->get();
        $diassemana = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo'
        ];
        //return [$adminguias ];
        return view('adminguias.index', compact(['adminguias', 'hours', 'diassemana', 'franjashorarias' ]));
    }


    public function setguia(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {

        $id = $request->input('id');
        if($id != null){
            $g = User::select('users.*')->where('rol_id', 1)->findOrFail($id);
        
            if ( $request->input('name') != null ) {
                $g->name = $request->input('name');
            }
            if ( $request->input('surname') != null ) {
                $g->surname = $request->input('surname');
            }
            if ( $request->input('telefono') != null ) {
                $g->telefono = $request->input('telefono');
            }
            if ( $request->input('state') != null ) {
                $g->state = $request->input('state');
            }
            if ( $request->input('city') != null ) {
                $g->city = $request->input('city');
            }
            if ( $request->input('postalcode') != null ) {
                $g->postalcode = $request->input('postalcode');
            }
            if ( $request->input('address') != null ) {
                $g->address = $request->input('address');
            }
            if ( $request->input('number') != null ) {
                $g->number = $request->input('number');
            }

            if($g->update()){
                return response()->json($g);
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

    public function deleteguia( Request $request )
    {
        try {
            $id = $request->input('id');
            if($id != null){
                \DB::beginTransaction();
                $user = User::findOrFail($id);
                $user->delete();
                \DB::commit();
        
                return response()->json(['message' => 'Eliminado con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al eliminar ', 'message' => $e->getMessage()], 500);
        }
    }




    

}