<?php

namespace App\Http\Controllers\Adminclientes;

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

class AdminclientesController extends Controller
{

   


    public function index()
    {        
        $adminclientes = User::select('users.*')
        ->where('rol_id', 1)
        ->orderByDesc('users.id')
        ->simplePaginate(10000);

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

        return view('adminclientes.index', compact(['adminclientes', 'hours', 'diassemana' ]));
    }

    // public function getdisponibility($id)
    // {        
    //     try {
    //         $disponibilities = Disponibilities::select('disponibilities.*')->where('admin_id', $id)
    //         ->orderByDesc('id')
    //         ->simplePaginate(10000);

    //         return response()->json($disponibilities);
    //     }
    //     catch (\Exception $e) {
    //         return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
    //     }
    // }



    public function setcliente(Request $request)
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




    public function deletecliente( Request $request )
    {
        try {
            $id = $request->input('id');
            if($id != null){
                \DB::beginTransaction();
                $reserva = Reserva::findOrFail($id);
                $reserva->delete();
                \DB::commit();
        
                return response()->json(['message' => 'Registro eliminada con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al eliminar ', 'message' => $e->getMessage()], 500);
        }
    }


    

}