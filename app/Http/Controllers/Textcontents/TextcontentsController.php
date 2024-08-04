<?php

namespace App\Http\Controllers\Textcontents;

use App\Models\Textcontents;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\TextcontentsTransformer;

class TextcontentsController extends ApiController
{

    public function __construct()
    {
        $this->middleware('transform.input:'. TextcontentsTransformer::class)->only(['index']);
        //$this->middleware('auth:api')->except(['index']);
    }


    /**
     * Display the specified resource.
     *
     * @param  Textcontents  $textcontent
     * @return \Illuminate\Http\Response
     */



    /**
    * @OA\Get(
    *     method="index",
    *     path="/textcontents",
    *     textcontents={"textcontents"},
    *     summary="Mostrar textcontents",
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
     public function index($id)
     {
         $id ?? 1; 

         $data = Textcontents::select('textcontents.*')
         ->where('textcontents.language_id', $id)
         ->get();

         return $this->showAllWp($data);
     }
    
    
}
