<?php

namespace App\Http\Controllers\Disponibilities;

use App\Models\User;
use App\Models\Disponibility;
use App\Models\Nodisponibility;
use App\Models\Guiavisits;
use App\Models\Guialanguages;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformers\DisponibilitiesTransformer;
use Carbon\Carbon;

class DisponibilitiesController extends ApiController
{


    public function __construct()
    {
        $this->middleware('transform.input:'. DisponibilitiesTransformer::class)->only(['franjasdiasemana', 'disponibilidades']);
        //$this->middleware('auth:api')->only(['hoursdiasemana']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function franjasdiasemana($diasemana)
    {
        $diasemana ?? 1; 

        $data = Disponibility::select('disponibilities.*'
        , 'franjashorarias.init_hours_id', 'franjashorarias.end_hours_id' 
        )
        ->leftjoin('franjashorarias', 'franjashorarias.id', '=', 'disponibilities.franjahoraria_id')
        ->where('disponibilities.diasemana', $diasemana )
        ->get();
        
        return $this->showAll($data);
    }

    public function disponibilities($visitaid, $month, $year)
    {

        $month = $month ?? Carbon::now()->month;
        $year = $year ?? Carbon::now()->year;
        
        if($visitaid != null){
            $startOfMonth = Carbon::createFromDate($year, $month, 1);
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
            $daysInMonth = $startOfMonth->daysInMonth; // Número de días en el mes
            $diasmes  = array();

            $daysWithDisponibilities = Disponibility::select('diasemana', 'user_id')
            ->whereHas('guiavisits', function ($query) use ($visitaid) {
                $query->where('visit_id', $visitaid);
            })
            ->orderBy('diasemana')->get();
            
            $nodaysDisponibilities = Nodisponibility::select('fecha', 'user_id')
            ->where('fecha', '>=', $startOfMonth)
            ->where('fecha', '<=', $endOfMonth)
            ->orderBy('fecha')->get();

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::createFromDate($year, $month, $day);
                $usuariosConDisponibilidadEseDia = [];
                foreach ($daysWithDisponibilities as $dayWD ) {
                    if ($currentDate->dayOfWeek == $dayWD->diasemana ) {
                        $usuariosConDisponibilidadEseDia[] = $dayWD->user_id;
                    }
                }
        
                $guiasDisponibles = 0;
                foreach ($usuariosConDisponibilidadEseDia as $usuarioConDisponibilidad)
                {
                    $isAvailable = true;
                    foreach ($nodaysDisponibilities as $dayNoD) {     
                        if ( $currentDate->toDateString() ==  $dayNoD->fecha && $usuarioConDisponibilidad == $dayNoD->user_id )
                        {
                            $isAvailable = false;
                            break;
                        }
                    }
                    if($isAvailable){
                        $guiasDisponibles++;
                    }
                }
                if ( $guiasDisponibles > 0 ) {
                    $diasmes[] = $day;     
                }
            }
            $diasmes = array_unique($diasmes);

            return array_values($diasmes);
        }
        return null;
    }

}
