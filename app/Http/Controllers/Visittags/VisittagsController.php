<?php

namespace App\Http\Controllers\Visittags;

use App\Models\Visittag;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\VisittagsTransformer;

class VisittagsController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. VisittagsTransformer::class)->only(['store','destroy']);
        $this->middleware('auth:api')->only(['store', 'destroy']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        //
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
    *     path="/visittags",
    *     tags={"visittags"},
    *     summary="Crear tag de visita",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post tag de visita",
    *    @OA\JsonContent(
    *       required={"visit_id","id"},
    *       @OA\Property(property="id", type="int", format="text", example="1"),
    *       @OA\Property(property="visit_id", type="int", format="text", example="1"),
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
            'visit_id' => 'required',
            'id' => 'required'
        ];
        
        $this->validate($request, $rules);

        $data = $request->all();
        $yaexiste = Entitytag::where('visit_id', $data['visit_id'])->where('id', $data['id'])->first();

        if ($yaexiste) {
            return $this->errorResponse('Ya existe el tag', 409);
        }
        $tag = Entitytag::create($data);

        return $this->showOne($tag);
    }


    /**
     * Display the specified resource.
     *
     * @param  Visittag  $visittag
     * @return \Illuminate\Http\Response
     */

    public function show(Visittag $visittag)
    {
        return $this->showOne($visittag);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Visittag $visittag
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Visittag $tag)
    {
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $visittag
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/visittags/{id}",
    *     tags={"visittags"},
    *     summary="Eliminar ",
    *     @OA\Parameter(
    *         description="Parámetro para eliminar ",
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
    public function destroy(Visittag $visittag)
    {
        
        $visittag->delete();

        return $this->showOne($visittag);
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
