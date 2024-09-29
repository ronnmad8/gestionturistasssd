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
use Illuminate\Support\Str;

class AdminvisitsController extends Controller
{

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $adminvisits= Visit::with(['visitcategories.category', 'visitlanguages', 'visittags.tags'] )
        ->orderByDesc('visits.id')
        ->simplePaginate(1000);

        $hours= Hours::select('hours.*')->get();
        $categories= Category::select('categories.*')->get();
        $languages= Languages::with('isolanguages')->orderBy('id') ->get();
        $tags= Tag::select('tags.*')->get();
        return view('adminvisits.index', compact(['adminvisits', 'hours', 'tags', 'categories', 'languages']));
    }


    // public function visitsfilt($c_id)
    // {
        
    //     $clientes= Cliente::select('clientes.*', 'centros.name as centro')
    //     ->join('centros','centros.id','clientes.centros_id')
    //     ->where('clientes.centros_id', $c_id )
    //     ->orderByDesc('clientes.id')
    //     ->simplePaginate(10);

    //     $visitlanguages= Visitlanguages::select('visitlanguages.*')->get();

    //     return view('adminvisits.index', compact(['visitlanguages']));
    // }



    public function updatevisit(Request $request)
    {
        $request->validate([
            'duracionmin' => 'required|numeric|min:1',
            'recomendado' => 'required|boolean',
            'precio' => 'required|numeric|min:0',
        ]);

        try {

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
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }

  
    function createvisit(Request $request)
    {
        $validated = $request->validate([
            'cuandomin' => 'integer',
            'cancelacion' => 'integer',
            'temporada' => 'integer',
            'mascotas' => 'integer',
            'accesibilidad' => 'integer',
            'duracionmin' => 'integer',
            'recomendado' => 'integer',
            'precio' => 'numeric',
            'puntoencuentro' => 'string|nullable',
            'puntoencuentrotext' => 'string|nullable',
            'name' => 'string|required',
            'nummax' => 'integer',
            'nummin' => 'integer',
            'visitcategories' => 'array|nullable',
            'visittags' => 'array|nullable',
            'visitlanguages' => 'array|nullable'
        ]);

        try {

        $visit = new Visit();

            $visit->uuid = Str::uuid()->toString();
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
                    foreach ($visitlanguages as $vl) {
                        $languageId = $vl['language_id'] ?? null; 
                        $name = $vl['name'] ?? null;
                        $descripcion = $vl['descripcion'] ?? null;

                        if($languageId != null){
                            $visit->visitlanguages()->create([
                                'language_id' => $languageId,
                                'name' => $name,
                                'descripcion' => $descripcion,
                            ]);
                        }
                    }
                }
                $visit->load('visitlanguages.languages');
                
                return response()->json($visit);
                }
            
            } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
            }
    }


    public function deletevisit( Request $request )
    {
        try {
            $id = $request->input('id');
            if($id != null){
                \DB::beginTransaction();
                $visita = Visit::with(['visitcategories.category', 'visitlanguages', 'visittags.tags'] )->findOrFail($id);
                $visita->visitlanguages()->delete();
                $visita->visittags()->delete();
                $visita->visitcategories()->delete();
    
                $visita->delete();
                \DB::commit();
        
                return response()->json(['message' => 'Visita eliminada con éxito'], 200);
            }
            return null;
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la visita', 'message' => $e->getMessage()], 500);
        }
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