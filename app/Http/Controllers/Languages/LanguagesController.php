<?php

namespace App\Http\Controllers\Languages;

use App\Models\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\LanguagesTransformer;


class LanguagesController extends ApiController
{
    

    public function __construct()
    {
        // $this->middleware('transform.input:'. LanguagesTransformer::class)->only(['store','update']);
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
    *     path="/Languages",
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
        $data = Languages::all();
        return $this->showAllWp($data);
    }


    
}
