<?php

namespace App\Http\Controllers\Pedido;

use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\PedidoTransformer;
use Illuminate\Support\Str;

class PedidoController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. PedidoTransformer::class)->only(['store','update','pedido']);
        $this->middleware('auth:api')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * @OA\Get(
     *     method="index",
     *     path="/reservas",
     *     reservas={"reservas"},
     *     summary="Mostrar reservas",
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
        $data = Pedido::all();
        return $this->showAll($data);
    }



    public function pedido($idpedido)
    {
        $idpedido ?? 0; 
        $idlang = 1;

        $data = Pedido::with('reservas','reservas.visit')
        ->where('id', $idpedido )
        ->first();

        //return [$data];
        return $this->showOne($data);
    }
    


     /**
    * @OA\Post(
    *     method="store",
    *     path="/pedidos",
    *     tags={"pedidos"},
    *     summary="Crear pedido",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post pedido",
    *    @OA\JsonContent(
    *       required={"total","user_id"},
    *       @OA\Property(property="total", type="float", format="text", example="0"),
    *       @OA\Property(property="totalfinal", type="float", format="text", example="1"),
    *       @OA\Property(property="user_id", type="int", format="text", example="1"),
    
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
            'total' => 'required'
        ];

        // $this->validate($request, $rules);

        $pedido = null;
        $newpedido = $request->all();
        $user = auth()->user();
        if($user != null){
            $newpedido["user_id"] = $user->id;
        }
        $pedido = Pedido::create($newpedido);
        if($pedido != null){
            $reservasArray = []; 
            $reservas = $newpedido["reservas"];
            if($reservas != null){
                foreach($reservas as $r){
                    $reserva = new Reserva();
                    $reserva->fill($r);
                    $reserva["persons"] = (int)$r["children"] + (int)$r["adults"];
                    $reserva["pedido_id"] = $pedido->id;
                    $reserva["user_id"] = $pedido->user_id;
                    $reserva["visit_id"] = (int)$r["visit"]["id"];
                    $reserva["uuid"] = Str::uuid();


                    //revisar si la reserva pertenece a un pedido y ya tiene guia asignado

                    $guia = User::where('rol_id', 2)->inRandomOrder()->first();
                    if ($guia) {
                        $reserva["guia_id"] = $guia->id;
                    }

                    $reserva->save();
                    $reservasArray[] = $reserva; 
                }
            }    
            return $this->showOne($pedido, 201);
        }

        return null;
    }


    
    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Get(
    *     method="show",
    *     path="/reservas/{id}",
    *     reservas={"reservas"},
    *     summary="Mostrar reservas ",
    * @OA\Parameter(
    *         description="Parámetro necesario para la consulta de reservas",
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
  

    public function show(Pedido $pedido)
    {
        return $this->showOne($pedido);
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
    *     path="/reservas/{id}",
    *     tags={"reservas"},
    *     summary="Modificar reserva",
    *     @OA\Parameter(
    *         description="Parámetro para editar reserva",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(type="string"),
    *         @OA\Examples(example="int", value="1", summary="Introduce un número de id .")
    *     ),
    * @OA\RequestBody(
    *    required=true,
    *    description="put reserva",
    *    @OA\JsonContent(
    *       required={"user_id"},
    *       @OA\Property(property="user_id", type="string", format="text", example="0"),
    *       @OA\Property(property="total", type="string", format="text", example="0"),
    
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
    public function update(Request $request, Pedido $pedido)
    {
        //$this->allowedAdminAction();
        
        $reserva->fill($request->only([
            'total',
            'user_id'
        ]));

        if ($pedido->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $pedido->save();

        return $this->showOne($pedido);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */

       /**
    * @OA\Delete(
    *     method="destroy",
    *     path="/pedidos/{id}",
    *     tags={"pedidos"},
    *     summary="Eliminar pedido",
    *     @OA\Parameter(
    *         description="Parámetro para editar pedido",
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
    public function destroy(Pedido  $pedido)
    {
        //$this->allowedAdminAction();
        
        $pedido->delete_at = date('Y-m-d H:i:s');
        $pedido->save();

        return $this->showOne($pedido);
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
