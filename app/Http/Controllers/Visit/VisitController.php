<?php

namespace App\Http\Controllers\Visit;

use App\Models\Visit;
use App\Models\Category;
use App\Models\Reserva;
use App\Models\Tag;
use App\Models\Visitlanguages;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\VisitFiltTransformer;
use Illuminate\Http\UploadedFile;


class VisitController extends ApiController
{
    

    public function __construct()
    {
        //$this->middleware('transformbasico.input:'.VisitTransformer::class)->only(['store','update']);
        //$this->middleware('auth:api')->except(['index', 'show']);
    }


    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    /**
    * @OA\Get(
    *     method="index",
    *     path="/visits",
    *     tags={"visits"},
    *     summary="Mostrar visitas",
    *     @OA\Response(
    *         response=200,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */

    public function index(Visit $visit)
    {
        
        $data = Visit::all();
        return $this->showAllWP($data);
        
    }
    

    
    public function recommended($idlang)
    {
        $idlang ?? 1; 

        $data = Visit::select('visits.*'
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang." and visitlanguages.visit_id = visits.id limit 1  ) as titulo ")
        , Visit::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang."  and visitlanguages.visit_id = visits.id  limit 1) as descripcion ")
        )
        ->where('visits.recomendado', 1 )
        ->get();
        
        return $this->showAllBasic($data);
    }



    public function searchbasic(Request $request)
    {
        
        $search = $request->input('search');
        $search = strtolower($search);

        $searchfilt = Visitlanguages::select('visitlanguages.*');
        $searchfilt =  $searchfilt->where(function ($query) use ($search) {
            $query->whereRaw(strtolower('visitlanguages.name LIKE ? OR visitlanguages.descripcion LIKE ?'), ["%{$search}%", "%{$search}%"]);
        });
        $searchfilt = $searchfilt->pluck('visit_id')->toArray();
        $searchfilt = array_values(array_unique($searchfilt));

        $data = Visit::select('visits.*',
        Visitlanguages::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.visit_id = visits.id and visitlanguages.language_id = ".$idlang."  limit 1) as titulo"),
        Visitlanguages::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.visit_id = visits.id and visitlanguages.language_id = ".$idlang."  limit 1) as descripcion")
        )
        ->orWhere(function ($query) use ($searchfilt) {
            if(!empty($searchfilt)){
                $query->whereIn('visits.id', $searchfilt);
            }
        })
        ->get();
        
        return $this->showAllBasic($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Post(
    *     method="store",
    *     path="/visits",
    *     tags={"visits"},
    *     summary="Crear ",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post ",
    *    @OA\JsonContent(
    *       required={"name","preciohoramin", "duracionmin"},
    *       @OA\Property(property="cuandomin", type="string", format="text", example="1"),
    *       @OA\Property(property="cancelacion", type="string", format="text", example="1"),
    *       @OA\Property(property="temporada", type="string", format="text", example="1"),
    *       @OA\Property(property="mascotas", type="string", format="text", example="1"),
    *       @OA\Property(property="accesibilidad", type="string", format="text", example="1"),
    *       @OA\Property(property="duracionmin", type="string", format="text", example="1"),
    *       @OA\Property(property="preciohoramin", type="string", format="text", example="1"),
    *       @OA\Property(property="puntoencuentro", type="string", format="text", example=""),
    *       @OA\Property(property="name", type="string", format="text", example=""),
    *       @OA\Property(property="nummax", type="string", format="text", example="1"),
    
    *    ),
    * ),

    *     @OA\Response(
    *         response=201,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'preciohoramin' => 'required',
            'duracionmin' => 'required'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        
        $Visit = Visit::create($data);

        // if ($request->hasFile('imagenVisit')) {
        //     $file = $request->file('imagenVisit');
            
        //     if($file != null){
        //         $namefile = $this->updatefile($file);
        //         $Visit->image = $namefile;
        //         $Visit->save();
        //     }
        // }

        return $this->showOne($Visit, 201);
        
    }

    
    
    /**
     * Display the specified resource.
     *
     * @param  Visit  $Visit
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Get(
    *     method="show",
    *     path="/entities/{id}",
    *     tags={"entidades"},
    *     summary="Mostrar detalle",
    *     @OA\Parameter(
    *         description="Parámetro necesario ",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */


    public function show(Visit $Visit)
    {
        return $this->showOneFilt($Visit);
    }



    public function visitdetail($id, $langid)
    {
        $id ?? 1; 
        $langid ?? 1; 

        $data = Visit::select('visits.*'
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = ".$langid." and visitlanguages.visit_id = visits.id limit 1  ) as titulo ")
        , Visit::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = ".$langid."  and visitlanguages.visit_id = visits.id  limit 1) as descripcion ")
        )
        ->where('visits.id', $id )
        ->first();

        return $this->showOne($data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Put(
    *     method="update",
    *     path="/visitas/{id}",
    *     tags={"visitas"},
    *     summary="Modificar ",
    *     @OA\Parameter(
    *         description="Parámetro para editar ",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    * @OA\RequestBody(
    *    required=true,
    *    description="put ",
    *    @OA\JsonContent(
    *       required={"name"},
    *       @OA\Property(property="nombre", type="string", format="text", example="1"),
    *       @OA\Property(property="lat", type="string", format="text", example="1"),
    *       @OA\Property(property="lon", type="string", format="text", example="1"),
    *       @OA\Property(property="idcategoria", type="string", format="text", example="1"),
    *       @OA\Property(property="idsector", type="string", format="text", example="1"),
    *       @OA\Property(property="informacion", type="string", format="text", example="_"),
    *       @OA\Property(property="urlweb", type="string", format="text", example="_"),
    *       @OA\Property(property="direccion", type="string", format="text", example="_"),
    *       @OA\Property(property="imagen", type="string", format="text", example="_"),
    
    *    ),
    * ),

    *     @OA\Response(
    *         response=201,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function update(Request $request,Visit $Visit)
    {

        $Visit->fill($request->only([
            'titulo',
            'descripcion',
            'cuandomin',
            'cancelacion',
            'temporada',
            'mascotas',
            'accesibilidad',
            'duracionmin',
            'preciohoramin',
            'puntoencuentro',
            'name',
            'nummax'
        
        ]));

        if ($Visit->isClean() && !$request->hasFile('imagenVisit') ) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $Visit->save();

        if ($request->hasFile('imagenVisit') ) {
            $file = $request->file('imagenVisit');
            if($file != null){
                $namefile = $this->updatefile($file);
                $Visit->image = $namefile;
                $Visit->save();
            }
        }

        $e = Visit::find($Visit->id);

        return $this->showOne($e);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/visits/{id}",
    *     tags={"visits"},
    *     summary="Eliminar",
    *     @OA\Parameter(
    *         description="Parámetro para editar",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    
    *     @OA\Response(
    *         response=200,
    *         description="Respuesta Ok."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function destroy(Visit $visit)
    {

        $reservas = $visit->reservas;
        foreach ($reservas as $reserva) {
            $reserva->deleted_at = date('Y-m-d H:i:s');
            $reserva->save();
        }

        $visit->deleted_at = date('Y-m-d H:i:s');
        $visit->save();

        return $this->showOne($visit);
    }



    public function edit($id)
    {
        //
    }
    
    public function create()
    {
        //
    }








}
