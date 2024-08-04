<?php

namespace App\Http\Controllers\Visitcategories;

use App\Models\Visitcategories;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\VisitcategoriesTransformer;

class VisitcategoriesController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. VisitcategoriesTransformer::class)->only(['store','destroy']);
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
    *     path="/visitcategories",
    *     categories={"visitcategories"},
    *     summary="Crear categorie de visita",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post categorie de visita",
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
        $yaexiste = Entitycategorie::where('visit_id', $data['visit_id'])->where('id', $data['id'])->first();

        if ($yaexiste) {
            return $this->errorResponse('Ya existe el categorie', 409);
        }
        $categorie = Entitycategorie::create($data);

        return $this->showOne($categorie);
    }


    /**
     * Display the specified resource.
     *
     * @param  Visitcategorie  $visitcategorie
     * @return \Illuminate\Http\Response
     */

    public function show(Visitcategorie $visitcategorie)
    {
        return $this->showOne($visitcategorie);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Visitcategorie $visitcategorie
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Visitcategorie $categorie)
    {
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $visitcategorie
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/visitcategories/{id}",
    *     categories={"visitcategories"},
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
    public function destroy(Visitcategorie $visitcategorie)
    {
        
        $visitcategorie->delete();

        return $this->showOne($visitcategorie);
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
