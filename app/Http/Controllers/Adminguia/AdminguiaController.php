<?php

namespace App\Http\Controllers\Adminguia;

use App\Models\Reserva;
use App\Models\Franjashorarias;
use App\Models\Guia;
use App\Models\Visit;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitlanguages;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminguiaController extends Controller
{

    public function index($id)
    {        
        $adminguia = User::select('users.*')
        ->with('disponibilities')
        ->with('nodisponibilities')
        ->with('guialanguages')
        ->with('guiavisits')
        ->where(function ($query) {
            $query->where('rol_id', 2)
                  ->orWhere('rol_id', 4);
        })
        ->where('id', $id)
        ->first() ?? new User();

        $hours= Hours::select('hours.*')->get();
        $franjashorarias= Franjashorarias::select('franjashorarias.*'
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.init_hours_id  limit 1) as hourinit ")
        , Hours::raw("(SELECT hours.hora FROM hours WHERE hours.id = franjashorarias.end_hours_id  limit 1) as hourend ")
        )->get();
        $diassemana = [
            0 => 'lunes',
            1 => 'martes',
            2 => 'miércoles',
            3 => 'jueves',
            4 => 'viernes',
            5 => 'sábado',
            6 => 'domingo'
        ];
        $idiomas = [
            0 => 'español',
            1 => 'inglés',
            2 => 'francés',
            3 => 'alemán',
            4 => 'italiano',
            5 => 'portugués',
            6 => 'griego',
            7 => 'polaco'
        ];
        $visitas= Visit::select('visits.id'
        , Visit::raw("(SELECT visitlanguages.name FROM visitlanguages WHERE language_id = 1 and visit_id = visits.id  limit 1) as nombrevisita "))
        ->get();


        return view('adminguia.index', compact(['adminguia', 'hours', 'diassemana', 'franjashorarias', 'idiomas', 'visitas' ]));
    }

    public function getdisponibility($id)
    {        
        try {
            $disponibilities = Disponibilities::select('disponibilities.*')->where('admin_id', $id)
            ->orderByDesc('id')
            ->simplePaginate(10000);

            return response()->json($disponibilities);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la visita', 'message' => $e->getMessage()], 500);
        }
    }



    public function setguia(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {

        $id = $request->input('id');
        if($id != null){
            $g = User::select('users.*')
            ->where(function ($query) {
                $query->where('rol_id', 2)
                      ->orWhere('rol_id', 4);
            })
            ->findOrFail($id);
        
            if ( $request->input('name') != null ) {
                $g->name = $request->input('name');
            }
            if ( $request->input('surname') != null ) {
                $g->surname = $request->input('surname');
            }
            if ( $request->input('telefono') != null ) {
                $g->telefono = $request->input('telefono');
            }
            if ( $request->input('state') != null ) {
                $g->state = $request->input('state');
            }
            if ( $request->input('city') != null ) {
                $g->city = $request->input('city');
            }
            if ( $request->input('postalcode') != null ) {
                $g->postalcode = $request->input('postalcode');
            }
            if ( $request->input('address') != null ) {
                $g->address = $request->input('address');
            }
            if ( $request->input('number') != null ) {
                $g->number = $request->input('number');
            }

            if($g->update()){

                if ( $request->input('disponibilities') != null ) {
                    $currentDisponibilities = $g->disponibilities()->where('user_id', $id)->get();
                    $currentIds = $currentDisponibilities->map(function ($item) {
                        return [
                            'franjahoraria_id' => $item->franjahoraria_id,
                            'diasemana' => $item->diasemana
                        ];
                    })->toArray();

                    $newDisponibilities = collect($request->input('disponibilities'));
                    $newIds = $newDisponibilities->map(function ($item) {
                        return [
                            'franjahoraria_id' => $item['franjahoraria_id'],
                            'diasemana' => $item['diasemana']
                        ];
                    })->toArray();

                    $toDelete = $currentDisponibilities->filter(function ($item) use ($newIds) {
                        return !in_array(
                            ['franjahoraria_id' => (int)$item->franjahoraria_id, 'diasemana' => (int)$item->diasemana],
                            $newIds
                        );
                    });
                    
                    $toAdd = $newDisponibilities->filter(function ($item) use ($currentIds) {
                        return !in_array(
                            ['franjahoraria_id' => (int)$item['franjahoraria_id'], 'diasemana' => (int)$item['diasemana']],
                            $currentIds
                        );
                    });
                    
                    foreach ($toDelete as $disponibility) {
                        $disponibility->delete();
                    }
                    foreach ($toAdd as $disponibility) {
                        $g->disponibilities()->create($disponibility);
                    }

                }

                if ($request->input('nodisponibilities') != null) {
                    
                    $currentNoDisponibilities = $g->nodisponibilities()->where('user_id', $id)->get();
                    $currentNoIds = $currentNoDisponibilities->map(function ($item) {
                        return [
                            'user_id' => $item->user_id,
                            'fecha' => $item->fecha
                        ];
                    })->toArray();
                
                    $newNoDisponibilities = collect($request->input('nodisponibilities')); 
                    $newNoIds = $newNoDisponibilities->map(function ($item) {
                        return [
                            'user_id' => $item['user_id'],
                            'fecha' => $item['fecha']
                        ];
                    })->toArray();

                    $toNoDelete = $currentNoDisponibilities->filter(function ($item) use ($newNoIds) {
                        return !in_array(
                            ['user_id' => (int) $item->user_id, 'fecha' => $item->fecha],
                            $newNoIds
                        );
                    });
                
                    $toNoAdd = $newNoDisponibilities->filter(function ($item) use ($currentNoIds) {
                        return !in_array(
                            ['user_id' => (int) $item['user_id'], 'fecha' => $item['fecha']],
                            $currentNoIds
                        );
                    });
                
                    foreach ($toNoDelete as $nodisponibility) {
                        $nodisponibility->delete();
                    }
                
                    foreach ($toNoAdd as $addnodisponibility) {
                        $g->nodisponibilities()->create($addnodisponibility);
                    }
                }

                if ($request->input('guialanguages') != null) {
                    
                    $currentGuialanguages = $g->guialanguages()->where('user_id', $id)->get();
                    $currentGuialanguagesIds = $currentGuialanguages->map(function ($item) {
                        return [
                            'user_id' => $item->user_id,
                            'language_id' => $item->language_id
                        ];
                    })->toArray();
                
                    $newGuialanguages = collect($request->input('guialanguages')); 
                    $newGuialanguagesIds = $newGuialanguages->map(function ($item) {
                        return [
                            'user_id' => $item['user_id'],
                            'language_id' => $item['language_id']
                        ];
                    })->toArray();

                    $toGuialanguagesDelete = $currentGuialanguages->filter(function ($item) use ($newGuialanguagesIds) {
                        return !in_array(
                            ['user_id' => (int) $item->user_id, 'language_id' => (int)$item->language_id],
                            $newGuialanguagesIds
                        );
                    });
                
                    $toGuialanguagesAdd = $newGuialanguages->filter(function ($item) use ($currentGuialanguagesIds) {
                        return !in_array(
                            ['user_id' => (int) $item['user_id'], 'language_id' => (int)$item['language_id']],
                            $currentGuialanguagesIds
                        );
                    });
                
                    foreach ($toGuialanguagesDelete as $deleteguialanguages) {
                        $deleteguialanguages->delete();
                    }
                
                    foreach ($toGuialanguagesAdd as $addguialanguages) {
                        $g->guialanguages()->create($addguialanguages);
                    }
                }

                if ($request->input('guiavisits') != null) {

                    $currentGuiavisits = $g->guiavisits()->where('user_id', $id)->get();
                    $currentGuiavisitsIds = $currentGuiavisits->map(function ($item) {
                        return [
                            'user_id' => $item->user_id,
                            'visit_id' => $item->visit_id
                        ];
                    })->toArray();
                
                    $newGuiavisits = collect($request->input('guiavisits')); 
                    $newGuiavisitsIds = $newGuiavisits->map(function ($item) {
                        return [
                            'user_id' => $item['user_id'],
                            'visit_id' => $item['visit_id']
                        ];
                    })->toArray();


                    $toGuiavisitsDelete = $currentGuiavisits->filter(function ($item) use ($newGuiavisitsIds) {
                        return !in_array(
                            ['user_id' => (int) $item->user_id, 'visit_id' => (int)$item->visit_id],
                            $newGuiavisitsIds
                        );
                    });
                
                    $toGuiavisitsAdd = $newGuiavisits->filter(function ($item) use ($currentGuiavisitsIds) {
                        return !in_array(
                            ['user_id' => (int) $item['user_id'], 'visit_id' => (int)$item['visit_id']],
                            $currentGuiavisitsIds
                        );
                    });
                
                    foreach ($toGuiavisitsDelete as $deleteguiavisits) {
                        $deleteguiavisits->delete();
                    }
                
                    foreach ($toGuiavisitsAdd as $addguiavisits) {
                        $g->guiavisits()->create($addguiavisits);
                    }
                }



                return response(true);
            }
            else{
                return null;
            }
        }
        return response()->json(['error' => 'not found'], 404);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear registro', 'message' => $e->getMessage()], 500);
        }
    }




    

}