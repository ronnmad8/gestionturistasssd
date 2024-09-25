<?php

namespace App\Http\Controllers\VisitFilt;

use App\Models\Visit;
use App\Models\Visitcategory;
use App\Models\Visitlanguages;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitdias;
use App\Models\Category;
use App\Models\Reserva;
use App\Models\Tag;
use App\Models\Franjashorarias;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\VisitFiltTransformer;
use DateTime;
use DateInterval;



class VisitFiltController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
  
    }


    

    /**
     * Get Reservas by Visit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Get(
    *     method="index",
    *     path="/visitfilt?search={search}",
    *     tags={"visit"},
    *     summary="Mostrar visitas con filtro",
    *     @OA\Parameter(
    *         description="Parámetro necesario para filtrar ",
    *         in="path",
    *         name="search",
    *         required=true,
    *         @OA\Schema(type="string"),
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



    public function index(Request $request)
    {

        $data = Visit::select('visits.*')
        ->get();
        
        return $this->showfAll($data);
    }

    public function search(Request $request)
    {
        $all = $request->input('all');
        if ($all == null){
            $all = 8;
        }


        /// search
        $search = $request->input('search');
        $search = strtolower($search);
        $searchfilt = Visitlanguages::select('visitlanguages.*');
        $searchfilt =  $searchfilt->where(function ($query) use ($search) {
            $query->whereRaw(strtolower('visitlanguages.name LIKE ? OR visitlanguages.descripcion LIKE ?'), ["%{$search}%", "%{$search}%"]);
        });
        
        $searchfilt = $searchfilt->pluck('visit_id')->toArray();
        $searchfilt = array_values(array_unique($searchfilt));

        /// precio 
        $preciomin = $request->input('precioMin');
        if($preciomin == null){$preciomin=0;}
        $preciofin = $request->input('precioFin');        
        if ($preciofin == null) {
            $preciofin =  (int)Visit::select('visits.preciohoramin')->max('visits.preciohoramin')  ;
        }

        //// duraciones
        $duraciones = $request->input('duracion');
        if(!is_array($duraciones)){
            $duraciones = json_decode($duraciones);
        }
        $duracionestramos = array(); 
        if($duraciones != null && is_array($duraciones)  ){
            $duracionestramos = ($duraciones); // 0-3, 3-5, 5-7, 7-0 => [3,5,7,0]
        }

        /// franjas 
        $franjashorarias = $request->input('franjashorarias');
        if(!is_array($franjashorarias)){
            $franjashorarias = json_decode($franjashorarias);
        }
        $franjashorariasid = array(); 
        if($franjashorarias != null && is_array($franjashorarias) ){
          $franjashorariasid = $franjashorarias; // 6-12, 12-17, 17-6
        }

        $franjasfilt = Franjashorarias::select('franjashorarias.*');
        if (is_array($franjashorariasid)) {
            $franjasfilt =  $franjasfilt->where(function ($query) use ($franjashorariasid) {
               $query->whereIn('franjashorarias.id', $franjashorariasid);
             });
        }
        $franjasfilt = $franjasfilt->get();

        $franjasvisitid = array();
        if ($franjasfilt != null) {
            foreach ($franjasfilt as $f) {
                $hoursfranjas = Visithours::select('visithours.*');
                $hoursfranjas =  $hoursfranjas->where('visithours.hours_id','>=', $f["init_hours_id"])
                ->where('visithours.hours_id','<=',$f["end_hours_id"]);
                $hoursfranjas = $hoursfranjas->pluck('visit_id')->toArray();
                $franjasvisitid = array_merge($franjasvisitid, $hoursfranjas);
            }
        }
        $franjasvisitid = array_values(array_unique($franjasvisitid));

        /// categorias
        $categories = $request->input('categories');
        if(!is_array($categories)){
            $categories = json_decode($categories);
        }
        $categoriesid = array(); 
        if($categories != null && is_array($categories) ){
            $categoriesid = $categories;
        }
        $categoriesfilt = Visitcategory::select('visitcategories.*');
        if (is_array($categoriesid)) {
            $categoriesfilt =  $categoriesfilt->where(function ($query) use ($categoriesid) {
               $query->whereIn('visitcategories.category_id', $categoriesid);
             });
        }
        $categoriesfilt = $categoriesfilt->pluck('visit_id')->toArray();
        $categoriesfilt = array_values(array_unique($categoriesfilt));

        /// idlang
        $idlang = $request->input('idlang') ?? 1 ;

        
        /// languages
        $languages = $request->input('languages');
        if(!is_array($languages) ){
            $languages = json_decode($languages);
        }
        $languagesid = array(); 
        if($languages != null && is_array($languages)){
            $languagesid = $languages;
        }

        $languagesfilt = Visitlanguages::select('visitlanguages.*');
        if (is_array($languagesid)) {
            $languagesfilt =  $languagesfilt->where(function ($query) use ($languagesid) {
               $query->whereIn('visitlanguages.language_id', $languagesid);
             });
        }
        $languagesfilt = $languagesfilt->pluck('visit_id')->toArray();
        $languagesfilt = array_values(array_unique($languagesfilt));
       
       
        ///// tags

        $tags = $request->input('tags');
        if(!is_array($tags) ){
            $tags = json_decode($tags);
        }
        $tagsid = array(); 
        if ($tags != null && is_array($tags)){
            $tagsid = $tags;
        }

        $tagsfilt = Visittags::select('visittags.*');
        if (is_array($tagsid)) {
            $tagsfilt =  $tagsfilt->where(function ($query) use ($tagsid) {
               $query->whereIn('visittags.tags_id', $tagsid);
             });
        }
        $tagsfilt = $tagsfilt->pluck('visit_id')->toArray();
        $tagsfilt = array_values(array_unique($tagsfilt));

        //fecha


        $fechaini = $request->input('fechaini');
        if($fechaini == null){$fechaini =  date('Y-m-d') ;}
        $fechafin = $request->input('fechafin');
        if($fechafin == null){
            $fechaActual = new DateTime();
            $fechaActual->add(new DateInterval('P1Y')); // Add one year
            $fechafin = $fechaActual->format('Y-m-d');
        }

        $diasfilt = Visitdias::select('visitdias.*');
        $diasfilt =  $diasfilt->where(function ($query) use ($fechaini, $fechafin) {
            $query->whereDate('visitdias.fecha','>=',$fechaini)
            ->whereDate('visitdias.fecha','<=',$fechafin);
        })->get();
        $diasfilt = $diasfilt->pluck('visit_id')->toArray();
        $diasfilt = array_values(array_unique($diasfilt));


        /// ordenar
        $ordenar = $request->input('ordenar');
        if($ordenar == null){$ordenar=1;}
        $orden = "visits.id";
        $direccionordenar = "desc";
        switch ($ordenar){
            case "1":
                $direccionordenar = "asc";
                $orden = "visits.id";
                break;
            case "2":
                $direccionordenar = "asc";
                $orden = "visits.preciohoramin";
                break;
            case "3":
                $direccionordenar = "desc";
                $orden = "visits.preciohoramin";
                break;
            case "4":
                $direccionordenar = "asc";
                $orden = "visits.duracionmin";
                break;
            case "5":
                $direccionordenar = "desc";
                $orden = "visits.duracionmin";
                break;
            default:
                $orden = "visits.id";
                $direccionordenar = "asc";
                break;
        }

        //// QUERY TOTAL DE FILTRADO ////////////////////////////////////////////////////////////////
        
        $data = Visit::select('visits.*'
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang." and visitlanguages.visit_id = visits.id limit 1  ) as titulo ")
        , Visit::raw("(SELECT visitlanguages.descripcion FROM visitlanguages WHERE visitlanguages.language_id = ".$idlang."  and visitlanguages.visit_id = visits.id  limit 1) as descripcion ")
        )
        ->Where(function ($query) use ($languagesfilt) {
            if(!empty($languagesfilt)){
                $query->whereIn('visits.id', $languagesfilt);
            }
        })
        ->Where(function ($query) use ($searchfilt) {
            if(!empty($searchfilt)){
                $query->whereIn('visits.id', $searchfilt);
            }
        })
        ->where(function ($query) use ($preciofin) {
            $query->where('visits.precio', "<=",  $preciofin );
        })
        ->where(function ($query) use ($preciomin) {
            $query->where('visits.precio', ">=",  $preciomin );
        })
        ->where(function ($query) use ($duracionestramos) {
            if(!empty($duracionestramos)){
                foreach ($duracionestramos as $limite) {
                    if($limite == 3){
                       $query->orWhere('visits.duracionmin', '>=', (0) )->Where('visits.duracionmin', '<=', (3*60) );
                    }
                    if($limite == 5){
                        $query->orWhere('visits.duracionmin', '>=', (3*60) )->Where('visits.duracionmin', '<=', (5*60) );
                    }
                    if($limite == 7){
                        $query->orWhere('visits.duracionmin', '>=', (5*60))->Where('visits.duracionmin', '<=', (7*60));
                    }
                    if($limite == 0){
                       $query->orWhere('visits.duracionmin', '>=', 0)->Where('visits.duracionmin', '<=', (24*60) );
                    }
                }
            }
        })
        ->where(function ($query) use ($franjasvisitid) {
            if(!empty($franjasvisitid)){
                $query->orWhereIn('visits.id', $franjasvisitid);
            }
        })
        ->where(function ($query) use ($categoriesfilt) {
            if(!empty($categoriesfilt)){
                $query->orWhereIn('visits.id', $categoriesfilt);
            }
        })
        ->where(function ($query) use ($tagsfilt) {
            if(!empty($tagsfilt)){
                $query->orwhereIn('visits.id', $tagsfilt);
            }
        })
        ->where(function ($query) use ($diasfilt) {
			if(!empty($diasfilt)){
                $query->orwhereIn('visits.id', $diasfilt);
            }
        })
        ->orderBy($orden , $direccionordenar)
        ->limit($all)
        ->get();

        
        return $this->showAll($data);
        //return $data;
    }


    public function hoursid()
    {
        $data = Hours::select('hours.*')
        ->get();

        return $this->showAll($data);
    }


}
