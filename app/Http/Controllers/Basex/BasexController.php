<?php

namespace App\Http\Controllers\Sector;

use App\Models\Basex;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BasexController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
    * @OA\Get(
    *     method="index",
    *     path="/basex",
    *     tags={"basexes"},
    *     summary="Mostrar basesx",
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
        $data = Basex::all();
        return $this->showAllWp($data);
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }


    public function create()
    {
        //
    }
}
