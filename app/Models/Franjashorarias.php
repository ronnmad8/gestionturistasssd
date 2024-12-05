<?php

namespace App\Models;

use App\Transformers\FranjashorariasTransformer;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hours;

class Franjashorarias extends Model
{
    use SoftDeletes;

    public $transformer = FranjashorariasTransformer::class;

    protected $fillable = [
    	'init_hours_id',
    	'end_hours_id',

    ];

    public function inithours()
    {
        return $this->hasMany(Hours::class, 'init_hours_id', 'id'); 
    }

    public function endhours()
    {
        return $this->hasMany(Hours::class, 'end_hours_id', 'id'); 
    }


}
