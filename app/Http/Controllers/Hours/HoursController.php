<?php

namespace App\Http\Controllers\Hours;

use App\Models\Hours;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\HoursTransformer;


class HoursController extends ApiController
{
    

    public function __construct()
    {
        // $this->middleware('transform.input:'. HoursTransformer::class)->only(['store','update']);
        // $this->middleware('auth:api')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
    * @OA\Get(
    *     method="index",
    *     path="/hours",
    *     tags={"horas"},
    *     summary="Mostrar horas",
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
        $data = Hours::all();
        return $this->showAllWp($data);
    }


    
}
