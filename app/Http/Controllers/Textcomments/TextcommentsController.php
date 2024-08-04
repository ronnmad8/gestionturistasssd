<?php

namespace App\Http\Controllers\Textcomments;

use App\Models\Textcomments;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\TextcommentsTransformer;

class TextcommentsController extends ApiController
{

    public function __construct()
    {
        $this->middleware('transform.input:'. TextcommentsTransformer::class)->only(['index']);
        //$this->middleware('auth:api')->except(['index']);
    }


    /**
     * Display the specified resource.
     *
     * @param  Textcomments  $textcontent
     * @return \Illuminate\Http\Response
     */



    /**
    * @OA\Get(
    *     method="index",
    *     path="/textcomments",
    *     textcomments={"textcomments"},
    *     summary="Mostrar textcomments",
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

         $data = Textcomments::select('textcomments.*')
         ->where('textcomments.language_id', $id)
         ->get();

         return $this->showAllWp($data);
     }
    
    
}
