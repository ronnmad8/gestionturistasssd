<?php

namespace App\Http\Controllers\Reserva;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Languages;
use App\Models\Hours;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ReservaTransformer;
use Carbon\Carbon;

class ReservaController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. ReservaTransformer::class)->only(['store','update','reserva', 'reservasvisita']);
        $this->middleware('auth:api')->except(['index','show','reserva','reservascliente','me','vendidas','enviaremailtest']);
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
        $data = Reserva::all();
        return $this->showAll($data);
    }



    public function reserva($id)
    {
        $id ?? 0; 

        $data = Reserva::select('reservas.*')
        ->where('reservas.id', $id )
        ->first();

        return $this->showOne($data);
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
    *     path="/reservas",
    *     tags={"reservaos"},
    *     summary="Crear reservao",

    * @OA\RequestBody(
    *    required=true,
    *    description="Post reservao",
    *    @OA\JsonContent(
    *       required={"nombre","precio", "identidad"},
    *       @OA\Property(property="nombre", type="string", format="text", example="_"),
    *       @OA\Property(property="precio", type="string", format="text", example="1"),
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
            'name' => 'required',
            'price' => 'required',
            'entity_id' => 'required',
        ];

        $this->validate($request, $rules);
        
        $data = $request->all();
        $reserva = Reserva::create($data);

        return $this->showOne($reserva, 201);
    }


    
    /**
     * Display the specified resource.
     *
     * @param  \App\Reserva  $reserva
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
  

    public function show(Reserva $reserva)
    {
        return $this->showOne($reserva);
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
    *       @OA\Property(property="language_id", type="string", format="text", example="0"),
    *       @OA\Property(property="visit_hours_id", type="string", format="text", example="0"),
    *       @OA\Property(property="persons", type="string", format="text", example="0"),
    *       @OA\Property(property="children", type="string", format="text", example="0"),
    *       @OA\Property(property="adults", type="string", format="text", example="0"),
    *       @OA\Property(property="fecha", type="string", format="text", example="2024-01-01"),
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
    public function update(Request $request, Reserva $reserva)
    {
        //$this->allowedAdminAction();
        
        $reserva->fill($request->only([
            'persons',
            'total',
            'language_id'
        ]));

        if ($reserva->isClean()) {
            return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
        }

        $reserva->save();

        // if ($request->hasFile('imagenreserva')) {
        //     $file = $request->file('imagenreserva');
        //     if($file != null){
        //         $namefile = $this->updatefile($file);
        //         $reserva->image = $namefile;
        //         $reserva->save();
        //     }
        // }

        return $this->showOne($reserva);
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
    *     path="/reservas/{id}",
    *     tags={"reservaos"},
    *     summary="Eliminar reservao",
    *     @OA\Parameter(
    *         description="Parámetro para editar reservao",
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
    public function destroy(Reserva  $reserva)
    {
        //$this->allowedAdminAction();
        
        $reserva->delete_at = date('Y-m-d H:i:s');
        $reserva->save();

        return $this->showOne($reserva);
    }

    public function vendidas($visitaid, $fecha, $horaid, $languageid)
    {
        $horaid ?? 1; 
        $languageid ?? 1;

        $numvendidas = Reserva::select('reservas.*')
        ->where('visit_hours_id', $horaid )
        ->where('visit_id', $visitaid )
        ->where('fecha', $fecha )
        ->where('language_id', $languageid )
        ->where('deleted_at', null)
        ->sum('persons');

        return $numvendidas;
    }


    public function edit($id)
    {
        //
    }
    

    public function create()
    {
        //
    }

    public function enviaremailtest(Request $request)
    {
        $data = $request->all();
        $email = $data['email'];
        $name = $data['name'];
        $dataemail = array(
            'name' => $name ?? '_',
            'email' => $email ?? '_',
            'fecha' => '', // $reserva->fecha->format('dd/mm/Y') ?? '_',
            'hora' => '', //$reserva->hora->format('H:i') ?? '_',
            'persons' => '', // $reserva->persons ?? 0,
            'adults' => '', // $reserva->adults ?? 0,
            'children' => '', // $reserva->children ?? 0,
            'idioma' => $idioma ?? '_', //traducir
            'codigo' => '', //$reserva->uuid ?? '_',
            'precio' => '', //$reserva->total ?? 0,
            'visita' => $visita ?? '_', //traducir
            );

            $subject = 'Reserva Confirmada';
            $viewName = 'emails.reserva';
            Mail::to($email)->send(new ContactMail($dataemail, $viewName, $subject));
    }


    public function asignarguias()
    {
        //buscar citas que no tienen guia asignado y que superan el limite de 72horas
        $now = Carbon::now();
        $limiteFecha = $now->subDays(3)->toDateString();
        $citas = Cita::Cita::where('guia_id', null)
        ->where('deleted_at', null)
        ->whereDate('fecha', '<=', $limiteFecha)
        ->get();

        foreach ($citas as $cita) {
            $guia = User::where('rol_id', 2)
            ->orderBy('cuota', 'asc')
            ->orderBy('id', 'asc')
            ->first();
            if ($guia) {
                $guia->cuota = $guia->cuota + 1;
                $guia->save();
                $cita->guia_id = $guia->id;
                $cita->save();


                $idioma = Languages::find($cita->language_id)->name;
                $hora = Hours::find($cita->hours_id)->hora;
                $visita = Visitlanguages::find($cita->visit_id)->where('language_id', $cita->language_id)->first()->name;
                $visit = Visit::find($cita->visit_id)->first();
                $puntoencuentro = $visit->puntoencuentro;
                $puntoencuentrotext = $visit->puntoencuentrotext;        
                $textostraducidos = TraductionService::getTraduction($cita->language_id);
                $reservas = Reserva::where('deleted_at', null)
                ->where('cita_id', $cita->id)
                ->get();

                MailService::sendEmailGuia($cita, $reservas, $hora, $visita, $idioma, $textostraducidos,
                $puntoencuentro, $puntoencuentrotext);
            }
        }
    }
   
}
