<?php

namespace App\Http\Controllers\Pedido;

use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Languages;
use App\Models\Hours;
use App\Models\Visitlanguages;
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
                    //revisar si la reserva pertenece a un pedido y ya tiene guia asignado
                    
                    $guia = User::where('rol_id', 2)
                    ->orderBy('cuota', 'asc')
                    ->orderBy('id', 'asc')
                    ->first();                    
                    //$guia = User::where('rol_id', 2)->inRandomOrder()->first(); //TODO implementar cola controlada

                    if ($guia) {
                        $reserva["guia_id"] = $guia->id;
                    }

                    if($reserva->save()){
                        //actualizar guia cuota
                        $guia->cuota = $guia->cuota + 1;
                        $guia->save();

                        $idioma = Languages::find($reserva->language_id)->name;
                        $hora = Hours::find($reserva->visit_hours_id)->hora;
                        $visita = Visitlanguages::find($reserva->visit_id)->where('language_id', $reserva->language_id)->first()->name;

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
                            'textostraducidos' => $textostraducidos
                        );

                        MailService::sendEmailGuia($reserva, $hora, $visita, $idioma, $textostraducidos);
                        MailService::sendEmailAdmins($reserva, $hora, $visita, $idioma, $textostraducidosadmins);

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

    // public static function sendEmailGuia($reserva, $hora, $visita, $idioma, $textostraducidos)
    // {
    //     $guiaemail = User::find($reserva->guia_id)->email;
    //     $cliente = User::find($reserva->user_id);
    //     $namecliente = ($cliente?->name ?? ' ') ." ". ($cliente?->surname ?? ' ');

    //     $dataemail = array(
    //         'textostraducidos' => $textostraducidos,
    //         'namecliente' => $namecliente ?? '_',
    //         'fecha' => $reserva->fecha ?? '_',
    //         'hora' => $hora ?? '_',
    //         'persons' => $reserva->persons ?? 0,
    //         'idioma' => $idioma ?? '_',
    //         'codigo' => $reserva->uuid ?? '_',
    //         'visita' => $visita ?? '_',
    //     );
    //     $subject = 'Reserva asignada';
    //     $viewName = 'emails.reservaguia';
    //     Mail::to($guiaemail)->send(new ContactMail($dataemail, $viewName, $subject));
    // }

    // public static function sendEmailAdmins($reserva, $hora, $visita, $idioma, $textostraducidos)
    // {
    //     $guia = User::find($reserva->guia_id);
    //     $nameguia = ($guia->name ?? ' ') ." ". ($guia->surname ?? ' ');
    //     $cliente = User::find($reserva->user_id);
    //     $namecliente = ($cliente?->name ?? ' ') ." ". ($cliente?->surname ?? ' ');

    //     $dataemail = array(
    //         'textostraducidos' => $textostraducidos,
    //         'namecliente' => $namecliente ?? '_',
    //         'nameguia' => $nameguia ?? '_',
    //         'fecha' => $reserva->fecha ?? '_',
    //         'hora' => $hora ?? '_',
    //         'persons' => $reserva->persons ?? 0,
    //         'idioma' => $idioma ?? '_',
    //         'codigo' => $reserva->uuid ?? '_',
    //         'visita' => $visita ?? '_',
    //     );
    //     $subject = 'Reserva de ' . $namecliente . ' asignada a ' . $nameguia;
    //     $viewName = 'emails.reservaadmins';

    //     //listar emails de los admin
    //     Mail::to($_ENV['MAIL_ADMIN0'])->send(new ContactMail($dataemail, $viewName, $subject));
    //     //Mail::to($_ENV['MAIL_ADMIN1'])->send(new ContactMail($dataemail, $viewName, $subject));
    //     //Mail::to($_ENV['MAIL_ADMIN2'])->send(new ContactMail($dataemail, $viewName, $subject));
    //     //Mail::to($_ENV['MAIL_ADMIN3'])->send(new ContactMail($dataemail, $viewName, $subject));
    // }


    // public static function getTraduction($language_id)
    // {
        
    //     $textos_es = [
    //         'visita' => 'Visita',
    //         'nueva_reserva' => 'Nueva reserva',
    //         'cliente' => 'Cliente',
    //         'guia' => 'Guía',
    //         'codigo' => 'Código',
    //         'idioma' => 'Idioma',
    //         'fecha' => 'Fecha',
    //         'hora' => 'Hora',
    //         'personas' => 'Personas',
    //         'precio' => 'Precio',
    //         'texto_confirmada' => 'Reserva confirmada',
    //         'texto_gracias' => 'Gracias por realizar tu reserva. Aquí tienes los detalles de tu pedido'
    //     ];
        
    //     $textos_en = [
    //         'visita' => 'Visit',
    //         'nueva_reserva' => 'New reservation',
    //         'cliente' => 'Client',
    //         'guia' => 'Guide',
    //         'codigo' => 'Code',
    //         'idioma' => 'Language',
    //         'fecha' => 'Date',
    //         'hora' => 'Time',
    //         'personas' => 'People',
    //         'precio' => 'Price',
    //         'texto_confirmada' => 'Reservation confirmed',
    //         'texto_gracias' => 'Thank you for making your reservation. Here are the details of your order'
    //     ];
        
    //     $textos_fr = [
    //         'visita' => 'Visite',
    //         'nueva_reserva' => 'Nouvelle réservation',
    //         'cliente' => 'Client',
    //         'guia' => 'Guide',
    //         'codigo' => 'Code',
    //         'idioma' => 'Langue',
    //         'fecha' => 'Date',
    //         'hora' => 'Heure',
    //         'personas' => 'Personnes',
    //         'precio' => 'Prix',
    //         'texto_confirmada' => 'Réservation confirmée',
    //         'texto_gracias' => 'Merci d\'avoir effectué votre réservation. Voici les détails de votre commande'
    //     ];
        
    //     $textos_de = [
    //         'visita' => 'Besuch',
    //         'nueva_reserva' => 'Neue Reservierung',
    //         'cliente' => 'Kunde',
    //         'guia' => 'Führer',
    //         'codigo' => 'Code',
    //         'idioma' => 'Sprache',
    //         'fecha' => 'Datum',
    //         'hora' => 'Zeit',
    //         'personas' => 'Personen',
    //         'precio' => 'Preis',
    //         'texto_confirmada' => 'Reservierung bestätigt',
    //         'texto_gracias' => 'Vielen Dank für Ihre Reservierung. Hier sind die Details Ihrer Bestellung'
    //     ];
        
    //     $textos_it = [
    //         'visita' => 'Visita',
    //         'nueva_reserva' => 'Nuova prenotazione',
    //         'cliente' => 'Cliente',
    //         'guia' => 'Guida',
    //         'codigo' => 'Codice',
    //         'idioma' => 'Lingua',
    //         'fecha' => 'Data',
    //         'hora' => 'Ora',
    //         'personas' => 'Persone',
    //         'precio' => 'Prezzo',
    //         'texto_confirmada' => 'Prenotazione confermata',
    //         'texto_gracias' => 'Grazie per aver effettuato la tua prenotazione. Ecco i dettagli del tuo ordine'
    //     ];
        
    //     $textos_pt = [
    //         'visita' => 'Visita',
    //         'nueva_reserva' => 'Nova reserva',
    //         'cliente' => 'Cliente',
    //         'guia' => 'Guia',
    //         'codigo' => 'Código',
    //         'idioma' => 'Idioma',
    //         'fecha' => 'Data',
    //         'hora' => 'Hora',
    //         'personas' => 'Pessoas',
    //         'precio' => 'Preço',
    //         'texto_confirmada' => 'Reserva confirmada',
    //         'texto_gracias' => 'Obrigado por fazer a sua reserva. Aqui estão os detalhes do seu pedido'
    //     ];
        
    //     $textos_el = [
    //         'visita' => 'Επίσκεψη',
    //         'nueva_reserva' => 'Νέα κράτηση',
    //         'cliente' => 'Πελάτης',
    //         'guia' => 'Ξεναγός',
    //         'codigo' => 'Κωδικός',
    //         'idioma' => 'Γλώσσα',
    //         'fecha' => 'Ημερομηνία',
    //         'hora' => 'Ώρα',
    //         'personas' => 'Άτομα',
    //         'precio' => 'Τιμή',
    //         'texto_confirmada' => 'Επιβεβαιωμένη κράτηση',
    //         'texto_gracias' => 'Ευχαριστούμε που κάνατε την κράτησή σας. Εδώ είναι οι λεπτομέρειες της παραγγελίας σας'
    //     ];
        
    //     $textos_pl = [
    //         'visita' => 'Wizyta',
    //         'nueva_reserva' => 'Nowa rezerwacja',
    //         'cliente' => 'Klient',
    //         'guia' => 'Przewodnik',
    //         'codigo' => 'Kod',
    //         'idioma' => 'Język',
    //         'fecha' => 'Data',
    //         'hora' => 'Godzina',
    //         'personas' => 'Osoby',
    //         'precio' => 'Cena',
    //         'texto_confirmada' => 'Rezerwacja potwierdzona',
    //         'texto_gracias' => 'Dziękujemy za dokonanie rezerwacji. Oto szczegóły twojego zamówienia'
    //     ];
        

    //     switch($language_id){
    //         case 1:
    //             $textostraducidos = $textos_es;
    //             break;
    //         case 2:
    //             $textostraducidos = $textos_en;
    //             break;
    //         case 3:
    //             $textostraducidos = $textos_fr;
    //             break;
    //         case 4:
    //             $textostraducidos = $textos_de;
    //             break;
    //         case 5:
    //             $textostraducidos = $textos_it;
    //             break;
    //         case 6:
    //             $textostraducidos = $textos_pt;
    //             break;
    //         case 7:
    //             $textostraducidos = $textos_el;
    //             break;
    //         case 8:
    //             $textostraducidos = $textos_pl;
    //             break;
    //         default:
    //             $textostraducidos = $textos_es;
    //             break;

    //     };


    //     return $textostraducidos;
    // }


    
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
