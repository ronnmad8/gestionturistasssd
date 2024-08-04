<?php

namespace App\Http\Controllers\Test;

use App\Models\Entity;
use App\Models\Product;
use App\Models\Contacto;
use App\Models\Red;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;
use App\Transformers\ContactoTransformer;
use App\Transformers\RedsTransformer;



class TestController extends ApiController
{



    public function __construct()
    {
       // $this->middleware('transform.input:'. ContactoTransformer::class)->only(['store','update']);
    }



    public function show(Redes  $redes)
    {
        
        return $this->showOne($redes);
    }


}
