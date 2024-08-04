<?php

namespace App\Http\Controllers\Visithours;

use App\Models\Visithour;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\VisithoursTransformer;

class VisithoursController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. VisithoursTransformer::class)->only(['store','destroy']);
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
    *     path="/visithours",
    *     hours={"visithours"},
    *     summary="Crear hour de visita",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post hour de visita",
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
        $yaexiste = Visithours::where('visit_id', $data['visit_id'])->where('id', $data['id'])->first();

        if ($yaexiste) {
            return $this->errorResponse('Ya existe el hour', 409);
        }
        $hour = Entityhour::create($data);

        return $this->showOne($hour);
    }


    /**
     * Display the specified resource.
     *
     * @param  Visithours  $visithour
     * @return \Illuminate\Http\Response
     */

    public function show(Visithours $visithour)
    {
        return $this->showOne($visithour);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Visithours $visithour
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Visithours $visithours)
    {
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $visithours
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/visithours/{id}",
    *     hours={"visithours"},
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
    public function destroy(Visithour $visithour)
    {
        
        $visithour->delete();

        return $this->showOne($visithour);
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
