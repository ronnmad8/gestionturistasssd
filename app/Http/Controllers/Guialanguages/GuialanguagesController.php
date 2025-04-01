<?php

namespace App\Http\Controllers\Guialanguages;

use App\Models\User;
use App\Models\Disponibility;
use App\Models\Guialanguages;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\GuialanguagesTransformer;
use Carbon\Carbon;

class GuialanguagesController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. GuialanguagesTransformer::class)->only(['languagesdiasemana']);
        //$this->middleware('auth:api')->only(['hoursdiasemana']);
    }


    

    public function languagesdiasemana($diasemana)
    {
        $diasemana ?? 1; 

        $data = Guialanguages::select('guialanguages.*')
        //->leftjoin('disponibilities', 'guialanguages.user_id', '=', 'disponibilities.user_id')
        //->where('disponibilities.diasemana', $diasemana )
        ->get();
        
        return $this->showAll($data);
    }

    

}
