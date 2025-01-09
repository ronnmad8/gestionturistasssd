<?php

namespace App\Models;

use App\Transformers\DisponibilitiesTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Franjashorarias;
use App\Models\Guialanguages;
use App\Models\Guiavisits;

class Disponibility extends Model
{

    use SoftDeletes;
    
    public $transformer = DisponibilitiesTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'franjahoraria_id',
    	'diasemana'
    ];
    protected $hidden = [
        'pivot'
    ];


    public function franjashorarias()
    {
        return $this->hasMany(Franjahorarias::class); 
    }

    public function guialanguages()
    {
        return $this->hasMany(Guialanguages::class, 'user_id', 'user_id'); 
    }

    public function guiavisits()
    {
        return $this->hasMany(Guiavisits::class, 'user_id', 'user_id'); 
    }
}
