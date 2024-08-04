<?php

namespace App\Http\Controllers\Tags;

use App\Models\Tag;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\TagsTransformer;

class TagsController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. TagsTransformer::class)->only(['store','update']);
        $this->middleware('auth:api')->except(['index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


   
    /**
    * @OA\Get(
    *     method="index",
    *     path="/tags",
    *     tags={"tags"},
    *     summary="Mostrar tags",
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
    public function index()
    {
        $data = Tag::all();
        return $this->showAllWP($data);
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
    *     path="/tags",
    *     tags={"tags"},
    *     summary="Crear tag",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post tag",
    *    @OA\JsonContent(
    *       required={"nombre"},
    *       @OA\Property(property="nombre", type="string", format="text", example="1"),
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
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $tag = Tag::create($data);

        return $this->showOne($tag);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $contacto
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Get(
    *     method="show",
    *     path="/tags/{id}",
    *     tags={"tags"},
    *     summary="Mostrar tag ",
    *     @OA\Parameter(
    *         description="Parámetro necesario para la consulta de tag",
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
    public function show(Tag $tag)
    {
        return $this->showOne($tag);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */

      /**
    * @OA\Put(
    *     method="update",
    *     path="/tags/{id}",
    *     tags={"tags"},
    *     summary="Modificar tag",
    *     @OA\Parameter(
    *         description="Parámetro para editar tag",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    * @OA\RequestBody(
    *    required=true,
    *    description="put tag",
    *    @OA\JsonContent(
    *       required={"nombre"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    
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
    public function update(Request $request, Tag $tag)
    {
        //$this->allowedAdminAction();
        
        $tag->fill($request->only([
            'name'
        ]));

        if ($tag->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $tag->save();

        return $this->showOne($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $tag
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/tags/{id}",
    *     tags={"tags"},
    *     summary="Eliminar tag",
    *     @OA\Parameter(
    *         description="Parámetro para eliminar tag",
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
    public function destroy(Tag $tag)
    {
        //$this->allowedAdminAction();
        
        $tag->delete();

        return $this->showOne($tag);
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
