<?php

namespace App\Http\Controllers\Adminvisits;

use App\Models\Visit;
use App\Models\Visittags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;

class AdminvisitsController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //lista de visitas
        $adminvisits = Visit::all()->take(8);
        
        // $visitsadmin= Visit::select('visits.*')
        // //->join('visithours','visits.id','visits.visit_id')
        // ->orderByDesc('visits.id')
        // ->simplePaginate(10);

        //$centros= Centros::select('centros.*')->where('centros.empleados','F')->get();
        //$cursos= Cursos::select('cursos.*')->get();
    

        return view('adminvisits.index', compact(['adminvisits']));
    }


    public function visitsfilt($c_id)
    {
        
        $clientes= Cliente::select('clientes.*', 'centros.name as centro')
        ->join('centros','centros.id','clientes.centros_id')
        ->where('clientes.centros_id', $c_id )
        ->orderByDesc('clientes.id')
        ->simplePaginate(10);

        $visitlanguages= Visitlanguages::select('visitlanguages.*')->get();

        return view('adminvisits.index', compact(['visitlanguages']));

    }


    

    // public function autorizacion($code)
    // {
    //     //autorizacion cliente 
    //     //->join('autorizacion_clientes', 'autorizacion_clientes.cliente_id','clientes.id')

    //     $hoy = date('Y-m-d H:i:s');

    //     $cliente= Cliente::select('clientes.*')
    //     ->where('clientes.code', $code)
    //     ->where('clientes.caducidad','>', $hoy )
    //     //->where('clientes.estado_id', '2' )
    //     ->first();

    //     return view('cliente.autorizacion', compact(['cliente']));
    // }



 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function updatevisit(Request $request)
    {

        $visit = Visit::findOrFail($request->id);
        $visit->cuandomin = $request->input('cuandomin');
        $visit->cancelacion = $request->input('cancelacion');
        $visit->temporada = $request->input('temporada');
        $visit->mascotas = $request->input('mascotas');
        $visit->accesibilidad = $request->input('accesibilidad');
        $visit->duracionmin = $request->input('duracionmin');
        $visit->recomendado = $request->input('recomendado');
        $visit->preciohoramin = $request->input('preciohoramin');
        $visit->precio = $request->input('precio');
        $visit->puntoencuentro = $request->input('puntoencuentro');
        $visit->name = $request->input('name');
        $visit->nummax = $request->input('nummax');
        $visit->nummin = $request->input('nummin');

        $visit->save();
        return $request;
    }


    // public function visitasupdate(Request $request)
    // {
    //     ////actualizar
    //     $id = $request->input('id');
    //     $alu = Alumno::findOrFail($id);
    //     $alu->nombre = $request->input('nombre');
    //     $alu->apellido1 = $request->input('apellido1');
    //     $alu->apellido2 = $request->input('apellido2');
    //     $alu->curso_id = $request->input('curso_id');

    //     $alu->save();
    //     return  $id ;
    // }


  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AutorizacionCliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function createvisita(Request $request)
    {
        $hoy = date('Y-m-d H:i:s');

             
        $visit = new Visit();

        $visit->cuandomin = $request->input('cuandomin');
        $visit->cancelacion = $request->input('cancelacion');
        $visit->temporada = $request->input('temporada');


        $cliente->fecha_autorizacion = new Datetime();

        $visit->save();

        return [true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }


    


    // public function formulario()
    // {
    //     $centros= Centros::select('centros.*')->where('centros.empleados','F')->get();
    //     $cursos= Cursos::select('cursos.*')->get();

    //     return view('cliente.formulario', compact(['centros', 'cursos']));
    // }


    public function inicio()
    {

        $visittags = Visittags::select('visittags.*')->get();
        
        // foreach($visittags as $visittag){
        //     $conc++;
        //     $c= Cliente::select('clientes.id')->where('clientes.centros_id', $conc)->groupBy('id')->get()->count();
        //     $aa = array('valor'=> $c, 'id'=> $ce["id"], "name"=>$ce["name"], "cont"=>$conc);
        //     array_push( $cuentaclientes , $aa );
        // }

  
        return view('adminvisits.inicio', compact(
            'visittags'
        ));

        
    }

}