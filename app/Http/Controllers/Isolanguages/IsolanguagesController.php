<?php

namespace App\Http\Controllers\Isolanguages;

use App\Models\Isolanguages;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\IsolanguagesTransformer;


class IsolanguagesController extends ApiController
{
    

    public function __construct()
    {
        // $this->middleware('transform.input:'. IsolanguagesTransformer::class)->only(['store','update']);
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
    *     path="/Isolanguages",
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
        $data = Isolanguages::all();
        return $this->showAllWp($data);
    }

    public function isolanguages($iso)
    {
        $id ?? 'es'; 

        $data = Isolanguages::select('isolanguages.*', 'languages.id as languageid')
        ->leftjoin('languages','languages.iso', 'isolanguages.iso')
        ->where('languages.iso', $iso )
        ->get();
        
        return $this->showAll($data);
    }

    
}
