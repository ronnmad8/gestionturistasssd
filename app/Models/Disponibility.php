<?php

namespace App\Models;

use App\Transformers\DisponibilityTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Franjashorarias;

class Disponibility extends Model
{

    use SoftDeletes;
    
    public $transformer = DisponibilityTransformer::class;

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
        return $this->hasMany(Franjashorarias::class, 'category_id', 'id'); 
    }
}
