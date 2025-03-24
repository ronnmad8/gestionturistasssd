<?php

namespace App\Http\Controllers\Pedido;

use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Languages;
use App\Models\Hours;
use App\Models\Visitlanguages;
use App\Models\Visit;
use App\Models\Cita;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\PedidoTransformer;
use Illuminate\Support\Str;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use App\Services\TraductionService;
use App\Services\MailService;

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
                    $reserva["user_id"] = $user->id;
                    $reserva["visit_id"] = (int)$r["visit"]["id"];
                    $reserva["uuid"] = Str::uuid();
                      
                    $cita = Cita::where('fecha', $reserva->fecha)
                    ->where('hours_id', $reserva->visit_hours_id)
                    ->where('visit_id', $reserva->visit_id)
                    ->where('language_id', $reserva->language_id)
                    ->first();
                    
                    if($cita != null){
                        $cita->clients = (int)$cita->clients + (int)$reserva->persons;
                        $cita->update();
                        $reserva["cita_id"] = $cita->id;
                    }
                    else{
                        $citanew = new Cita();
                        $citanew->fecha = $reserva->fecha;
                        $citanew->hours_id = $reserva->visit_hours_id;
                        $citanew->visit_id = $reserva->visit_id;
                        $citanew->language_id = $reserva->language_id;
                        $citanew->clients = (int)$reserva->persons ?? 0;
                        $visitcita = Visit::where('id', $citanew->visit_id)->first();
                        $citanew->max = (int)$visitcita->nummax ?? 0;
                        $citanew->min = (int)$visitcita->nummin ?? 0;
                        $citanew->save();
                        $reserva["cita_id"] = $citanew->id;
                    }

                    if($reserva->save()){
                        
                        $idioma = Languages::find($reserva->language_id)->name;
                        $hora = Hours::find($reserva->visit_hours_id)->hora;
                        $visita = Visitlanguages::find($reserva->visit_id)->where('language_id', $reserva->language_id)->first()->name;
                        $visit = Visit::find($reserva->visit_id)->first();
                        $puntoencuentro = $visit->puntoencuentro;
                        $puntoencuentrotext = $visit->puntoencuentrotext;
                        
                        $textostraducidos = TraductionService::getTraduction($reserva->language_id);
                        $textostraducidosadmins = TraductionService::getTraduction(1);
                        $reservasArray[] = array(
                            'fecha' => $reserva->fecha ?? '_',
                            'hora' => $hora ?? '_',
                            'persons' => $reserva->persons ?? 0,
                            'adults' => $reserva->adults ?? 0,
                            'children' => $reserva->children ?? 0,
                            'idioma' => $idioma ?? '_',
                            'codigo' => $reserva->uuid ?? '_',
                            'precio' => $reserva->total ?? 0,
                            'visita' => $visita ?? '_', 
                            'textostraducidos' => $textostraducidos,
                            'puntoencuentro' => $puntoencuentro ?? '#',
                            'puntoencuentrotext' => $puntoencuentrotext ?? '_',
                        );

                        MailService::sendEmailAdmins($reserva, $hora, $visita, $idioma, $textostraducidosadmins, $puntoencuentro, $puntoencuentrotext);
                    }
                }
            }

            if (!empty($reservasArray)) {
                $dataemail = array(
                    'textos' => $textostraducidos,
                    'name' => ($user->name ?? '_') ." ". ($user->surname ?? '_'),
                    'email' => $user->email ?? '_',
                    'reservas' => $reservasArray
                );
                $subject = 'Reserva Confirmada';
                $viewName = 'emails.reserva';
                Mail::to($user->email)->send(new ContactMail($dataemail, $viewName, $subject));
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
