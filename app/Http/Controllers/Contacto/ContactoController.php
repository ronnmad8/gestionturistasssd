<?php

namespace App\Http\Controllers\Contacto;

use App\Models\Contacto;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\ContactoTransformer;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactoController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. ContactoTransformer::class)->only(['store','update']);
        $this->middleware('auth:api')->except(['index', 'show', 'contact']);
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
    *     path="/contactos",
    *     tags={"contactos"},
    *     summary="Crear contacto",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post contacto",
    *    @OA\JsonContent(
    *       required={"nombre","identidad"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    *       @OA\Property(property="telefono", type="string", format="text", example="123456789"),
    *       @OA\Property(property="email", type="string", format="text", example="_@_.com"),
    *       @OA\Property(property="identidad", type="string", format="text", example="1"),
    
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
        $contacto = Contacto::create($data);

        return $this->showOne($contacto);
    }


    /**
     * Display the specified resource.
     *
     * @param  Contacto  $contacto
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Get(
    *     method="show",
    *     path="/conatctos/{id}",
    *     tags={"contactos"},
    *     summary="Mostrar contacto ",
    *     @OA\Parameter(
    *         description="Parámetro necesario para la consulta de contacto",
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
    public function show(Contacto $contacto)
    {
        return $this->showOne($contacto);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Contacto  $contacto
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Put(
    *     method="update",
    *     path="/contactos/{id}",
    *     tags={"contactos"},
    *     summary="Modificar contacto",
    *     @OA\Parameter(
    *         description="Parámetro para editar contacto",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    * @OA\RequestBody(
    *    required=true,
    *    description="put contacto",
    *    @OA\JsonContent(
    *       required={"nombre"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    *       @OA\Property(property="email", type="string", format="text", example="_@_.com"),
    *       @OA\Property(property="telefono", type="string", format="text", example="123456789"),
    *       @OA\Property(property="identidad", type="string", format="text", example="1"),

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
    public function update(Request $request, Contacto $contacto)
    {
        //$this->allowedAdminAction();
        
        $contacto->fill($request->only([
            'name',
            'email',
            'phone',
        ]));

        if ($contacto->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $contacto->save();

        return $this->showOne($contacto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $contacto
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/contactos/{id}",
    *     tags={"contactos"},
    *     summary="Eliminar contacto",
    *     @OA\Parameter(
    *         description="Parámetro para editar contacto",
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
    public function destroy(Contacto $contacto)
    {
        //$this->allowedAdminAction();
        
        $contacto->delete();

        return $this->showOne($contacto);
    }



    public function index()
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function create()
    {
        //
    }


    public function contact(Request $request)
    {
        $rules = [
            'email' => 'required'
        ];

        $result = "false";

        //$this->validate($request, $rules);

        $data = $request->all();
        $email = $data["email"];

        Mail::to($email) // Email al que se enviará el correo
        ->send(new ContactMail($data));

        return response()->json(['result' => 'Correo enviado con éxito']);
    }

}
