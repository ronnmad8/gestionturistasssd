<?php

namespace App\Http\Controllers\Adminvisits;

use App\Models\Visit;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitlanguages;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
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
        //$adminvisits = Visit::all()->take(8);
        
        $adminvisits= Visit::with(['visitcategories.category', 'visitlanguages', 'visittags.tags'] )
        ->orderByDesc('visits.id')
        ->simplePaginate(100);

        $hours= Hours::select('hours.*')->get();
        $categories= Category::select('categories.*')->get();
        $languages= Languages::with('isolanguages')->orderBy('id') ->get();
        $tags= Tag::select('tags.*')->get();


        return view('adminvisits.index', compact(['adminvisits', 'hours', 'tags', 'categories', 'languages']));
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
        $request->validate([
            'duracionmin' => 'required|numeric|min:1',
            'recomendado' => 'required|boolean',
            'precio' => 'required|numeric|min:0',
        ]);

        $id = $request->input('id');
        if($id != null){
            $visit = Visit::with(['visitcategories.category', 'visitlanguages', 'visittags.tags'] )->findOrFail($id);
            $visit->cuandomin = $request->input('cuandomin', 0);
            $visit->cancelacion = $request->input('cancelacion', 0);
            $visit->temporada = $request->input('temporada', 0);
            $visit->mascotas = $request->input('mascotas', 0);
            $visit->accesibilidad = $request->input('accesibilidad', 0);
            $visit->duracionmin = $request->input('duracionmin', 0);
            $visit->recomendado = $request->input('recomendado', 0);
            $visit->precio = $request->input('precio', 0);
            $visit->puntoencuentro = $request->input('puntoencuentro', '');
            $visit->puntoencuentrotext = $request->input('puntoencuentrotext', '');
            $visit->name = $request->input('name', '');
            $visit->nummax = $request->input('nummax', 0);
            $visit->nummin = $request->input('nummin',0);
            $visit->preciohoramin = 0; 
            if ($visit->duracionmin > 0) {
                $visit->preciohoramin = round($visit->precio / ($visit->duracionmin / 60), 2);
            } 
            if ($visit->save()) {
                $visitcategories = $request->input('visitcategories', []); 
                if (!empty($visitcategories)) {
                    $visit->visitcategories()->delete();
                    foreach ($visitcategories as $category) {
                        $visit->visitcategories()->create(['category_id' => $category]);
                    }
                }
                $visit->load('visitcategories.category');

                $visittags = $request->input('visittags', []); 
                if (!empty($visittags)) {
                    $visit->visittags()->delete();
                    foreach ($visittags as $tag) {
                        $visit->visittags()->create(['tags_id' => $tag]);
                    }
                }
                $visit->load('visittags.tags');

                $visitlanguages = $request->input('visitlanguages', []); 
                if (!empty($visitlanguages)) {
                    //$visit->visitlanguages()->delete();
                    $existingLanguages = $visit->visitlanguages()->get();
                    $frontendLanguageIds = collect($visitlanguages)->pluck('language_id')->filter()->all();
                    foreach ($visitlanguages as $vl) {
                        $languageId = $vl['language_id'] ?? null; 
                        $name = $vl['name'] ?? null;
                        $descripcion = $vl['descripcion'] ?? null;

                        if($languageId != null){
                            $existingLanguage = $existingLanguages->firstWhere('language_id', $languageId);
                            if ($existingLanguage) {
                                // Si la relación ya existe, actualizar el nombre y la descripción
                                $existingLanguage->update([
                                    'name' => $name,
                                    'descripcion' => $descripcion,
                                ]);
                            }
                            else {
                                $visit->visitlanguages()->create([
                                    'language_id' => $languageId,
                                    'name' => $name,
                                    'descripcion' => $descripcion,
                                ]);
                            }
                        }
                    }
                    $visit->visitlanguages()->whereNotIn('language_id', $frontendLanguageIds)->delete(); // delete no se actualicen
                }
                $visit->load('visitlanguages.languages');
                
                return response()->json($visit);
            }
            else{
                return null;
            }
        }
        return response()->json(['error' => 'Visit not found'], 404);
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
        return $visit;

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