<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="utopia API",
 *      version="1.0.0",
 *      description="API documentation for utopia ",
 *      @OA\Contact(
 *          email="info@utopia.com"
 *      )
 *  ),
 *  @OA\Server(
 *      description="utopia API",
 *      url="https://gestion.utopia.madrid/api/"
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * )
 */


class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

