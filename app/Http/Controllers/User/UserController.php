<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Reserva;
use App\Models\Languages;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        $this->middleware('auth:api')->except(['index', 'show','store', 'update','destroy', 'verify', 'resend','reservarcliente','reservasclinteall' ]);
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
    * @OA\Get(
    *     method="index",
    *     path="/users",
    *     tags={"users"},
    *     summary="Mostrar todos los usuarios",
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
        //$this->allowedAdminAction();
        
        $data = User::all();

        return $this->showAll($data);
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
    *     path="/users",
    *     tags={"users"},
    *     summary="Crear usuarios",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post user",
    *    @OA\JsonContent(
    *       required={"nombre","email","password"},
    *       @OA\Property(property="nombre", type="string", format="text", example="nombre"),
    *       @OA\Property(property="email", type="string", format="text", example="nombre@dominio.com"),
    *       @OA\Property(property="informacion", type="string", format="text", example="12345678"),

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
        //$this->allowedAdminAction();

        $result = false;
        $campos = $request->all();

        if($campos['email'] != null && $campos['password'] != null ){

            $data = User::select('users.*')
            ->where('users.email', $campos['email'] )
            ->first();
            
            if($data == null){
                $campos['password'] = bcrypt($request->password);
                $usuario = User::create($campos);
                $usuario->rol = 1;
                if($usuario != null){
                    $result = true;
                }
            }
        }

        return response()->json( $result , 200);
    }


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $result = false;

        return response()->json( $result , 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //$this->allowedAdminAction();

        return $this->showOne($user);
        
    }




    public function changedata(Request $request)
    {
        //$this->allowedAdminAction();

        $reglas = [
            'email' => 'email|unique:users,email',
            'password' => 'min:6|confirmed'
        ];

        $userlogin = auth()->user();
        $user = new User();
        //$this->validate($request, $reglas);
        
        if($userlogin != null){
            $user = User::select('users.*')->where('id', $userlogin->id )->first();

            if ($request->has('name') && $user->name != $request->name) {
                $user->name = $request->name;
            }
            if ($request->has('email') && $user->email != $request->email) {
                //$user->verified = User::USUARIO_NO_VERIFICADO;
                $user->email = $request->email;
            }
            if ($request->has('telefono') && $user->telefono != $request->telefoo) {
                $user->telefono = $request->telefono;
            }
            if ($request->has('surname') && $user->surname != $request->surname) {
                $user->surname = $request->surname;
            }
            if ($request->has('prefijo') && $user->prefijo != $request->prefijo) {
                $user->prefijo = $request->prefijo;
            }
            if ($request->has('state') && $user->state != $request->state) {
                $user->state = $request->state;
            }
            if ($request->has('country') && $user->country != $request->country) {
                $user->country = $request->country;
            }
            if ($request->has('city') && $user->city != $request->city) {
                $user->city = $request->city;
            }
            if ($request->has('number') && $user->number != $request->number) {
                $user->number = $request->number;
            }
            if ($request->has('address') && $user->address != $request->address) {
                $user->address = $request->address;
            }
            if ($request->has('particular') && $user->particular != $request->particular) {
                $user->particular = $request->particular;
            }
            if ($request->has('postalcode') && $user->postalcode != $request->postalcode) {
                $user->postalcode = $request->postalcode;
            }
    
            // if ($request->has('password')) {
            //     $user->password = bcrypt($request->password);
            // }
    
            if ($user->isDirty() ) {
                //return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
                $user->update();
            }
            
    
        }

        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //$this->allowedAdminAction();

        $user->delete();

        return $this->showOne($user);
    }


    /**
    * @OA\Get(
    *     method="me",
    *     path="/me",
    *     tags={"users"},
    *     summary="Mostrar usuarios",
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
    public function me()
    {
        //$this->allowedAdminAction();

        $user = auth()->user();
        return $this->showOne($user);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::USUARIO_VERIFICADO;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }

    public function resend(User $user)
    {
        if ($user->esVerificado()) {
            return $this->errorResponse('Este usuario ya ha sido verificado.', 409);
        }

        retry(5, function() use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('El correo de verificación se ha reenviado');

    }




    public function reservascliente($idlang, $idpedido)
    {
        $user = auth()->user();
        $iso = Languages::select('languages.iso')->where('id', $idlang)->first()->iso;
        if($user != null){
            $data = Reserva::select('reservas.*'
            //, 'visit.*'
            , Reserva::raw("(SELECT mediafiles.url FROM mediafiles WHERE mediafiles.visit_id = reservas.visit_id  and mediafiles.order = 1  limit 1) as mediafile ")
            , Reserva::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang." and visitlanguages.visit_id = reservas.visit_id  limit 1  ) as titulo ")
            , Reserva::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang."  and visitlanguages.visit_id = reservas.visit_id  limit 1) as descripcion ")
            , Reserva::raw("(SELECT isolanguages.title FROM isolanguages WHERE isolanguages.language_id = ".$idlang."  and isolanguages.iso = '".$iso."'  limit 1) as nombreidioma ")
            , Reserva::raw("(SELECT hours.hora FROM hours WHERE hours.id = reservas.visit_hours_id limit 1) as hora ")
            )
            ->where('reservas.user_id', $user->id )
            ->where('reservas.pedido_id', $idpedido )
            ->get();
            
            return $data;

            return $this->showAllWp($data);
        }
        return null;
    }

    public function reservasclienteall($idlang)
    {
        $user = auth()->user();
        if($idlang == null){
            $idlang = 1;
        }
        if($user != null){
            $data = Reserva::select('reservas.*'
            , Reserva::raw("(SELECT COALESCE(mediafiles.url,'') FROM mediafiles WHERE mediafiles.visit_id = reservas.visit_id  and mediafiles.order = 1  limit 1) as mediafile ")
            , Reserva::raw("(SELECT COALESCE(visitlanguages.name,'') FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang." and visitlanguages.visit_id = reservas.visit_id  limit 1  ) as titulo ")
            , Reserva::raw("(SELECT COALESCE(visitlanguages.descripcion,'') FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang."  and visitlanguages.visit_id = reservas.visit_id  limit 1) as descripcion ")
            , Reserva::raw("(SELECT COALESCE(hours.hora,'') FROM hours WHERE hours.id = reservas.visit_hours_id limit 1) as hora ")
            )
            ->where('reservas.user_id', $user->id )
            ->get();

            return $this->showAllWp($data);
        }
        return null;
    }

    public function pedidocliente($idlang, $idpedido)
    {
        $user = auth()->user();
        if($user != null){
            $data = Reserva::select('pedidos.*')
            ->where('pedidos.user_id', $user->id )
            ->get();
            
            return $this->showAllWp($data);
        }
        return null;
    }
    

}
