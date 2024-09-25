<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\VisitTransformer;
use App\Transformers\VisitFiltTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\visitcategories;
use App\Models\Visittags;
use App\Models\Visithours;
use App\Models\Visitdias;
use App\Models\Visitlanguages;


class Visit extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $transformer = VisitFiltTransformer::class;
    public $transformerbasico = VisitTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'cuandomin',
    	'cancelacion', 
    	'temporada',
    	'mascotas',
        'accesibilidad', 
        'duracionmin', 
        'preciohoramin', 
        'name',
        'nummax',
        'recomendado',
        'titulo',
        'descripcion',
        'reservas',
        'titulo',
        'descripcion',
        'image',
        'precio'
    
    ];
    protected $hidden = [
        'pivot'
    ];


    public function visitcategories()
    {
        return $this->hasMany(Visitcategory::class);
    }

    public function visittags()
    {
        return $this->hasMany(Visittags::class);
    }

    public function mediafiles()
    {
        return $this->hasMany(Mediafiles::class);
    }

    public function visithours()
    {
        return $this->hasMany(Visithours::class);
    }

    public function visitdias()
    {
        return $this->hasMany(Visitdias::class);
    }

    public function visitlanguages()
    {
        return $this->hasMany(Visitlanguages::class);
    }




}
