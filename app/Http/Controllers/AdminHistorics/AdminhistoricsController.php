<?php

namespace App\Http\Controllers\Adminhistorics;

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
use App\Models\Historics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminhistoricsController extends Controller
{

   


    public function index()
    {        
        $adminhistorics = Historics::select('historics.*')
        ->orderByDesc('historics.id')
        ->get();

        return view('adminhistorics.index', compact(['adminhistorics' ]));
    }

    


    

}