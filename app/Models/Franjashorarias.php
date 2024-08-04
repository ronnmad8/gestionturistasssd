<?php

namespace App\Models;

use App\Transformers\FranjashorariasTransformer;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franjashorarias extends Model
{
    use SoftDeletes;

    public $transformer = FranjashorariasTransformer::class;

    protected $fillable = [
    	'init_hours_id',
    	'end_hours_id',

    ];



}
