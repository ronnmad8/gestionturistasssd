<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;


class CategoryController extends ApiController
{
    

    public function __construct()
    {
        $this->middleware('transform.input:'. CategoryTransformer::class)->only(['store','update']);
        $this->middleware('auth:api')->except(['index', 'show', 'categories']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
    * @OA\Get(
    *     method="index",
    *     path="/categories",
    *     tags={"categorias"},
    *     summary="Mostrar categorias",
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
        $data = Category::select('categories.*')
        ->get();
        
        return $this->showAllWp($data);
    }

    public function categories($id)
    {
        $data = Category::select('categories.*'
        , Category::raw("(SELECT categoriestextcontents.content FROM categoriestextcontents WHERE categoriestextcontents.language_id = ".$id." and categoriestextcontents.category_id = categories.id limit 1  ) as content ")
        )
        ->get();
        
        return $this->showAllWp($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Post(
    *     method="store",
    *     path="/categories",
    *     tags={"categorias"},
    *     summary="Crear categoria",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post categoria",
    *    @OA\JsonContent(
    *       required={"nombre","idsector"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    *       @OA\Property(property="idsector", type="string", format="text", example="1"),
    *       @OA\Property(property="informacion", type="string", format="text", example="_"),

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
            'sector_id' => 'required'
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $category = Category::create($data);

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Get(
    *     method="show",
    *     path="/categories/{id}",
    *     tags={"categorias"},
    *     summary="Mostrar categoria ",
    *     @OA\Parameter(
    *         description="Parámetro necesario para la consulta de categorias",
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
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */

      /**
    * @OA\Put(
    *     method="update",
    *     path="/categories/{id}",
    *     tags={"categorias"},
    *     summary="Modificar categoria ",
    *     @OA\Parameter(
    *         description="Parámetro para editar categorias",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    * @OA\RequestBody(
    *    required=true,
    *    description="put categoria",
    *    @OA\JsonContent(
    *       required={"nombre","idsector"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    *       @OA\Property(property="idsector", type="string", format="text", example="1"),
    *       @OA\Property(property="informacion", type="string", format="text", example="_"),
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
    public function update(Request $request, Category $category)
    {
        //$this->allowedAdminAction();
        
        $category->fill($request->only([
            'name',
            'description',
            'sector_id',
        ]));

        if ($category->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $category->save();

        return $this->showOne($category);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/categories/{id}",
    *     tags={"categorias"},
    *     summary="Eliminar categoria",
    *     @OA\Parameter(
    *         description="Parámetro para editar categorias",
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
    public function destroy(Category $category)
    {
        //$this->allowedAdminAction();
        
        $category->delete();

        return $this->showOne($category);
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
