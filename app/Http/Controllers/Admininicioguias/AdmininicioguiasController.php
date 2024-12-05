<?php

namespace App\Http\Controllers\Admininicioguias;

use App\Models\Visit;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitlanguages;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\Mediafiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datetime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdmininicioguiasController extends Controller
{

   


    public function index()
    {
  
        return view('admininicioguias.index');

        
    }

}