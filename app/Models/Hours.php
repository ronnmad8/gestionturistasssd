<?php

namespace App\Models;

use App\Transformers\HoursTransformer;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hours extends Model
{
    use SoftDeletes;

    public $transformer = HoursTransformer::class;

    protected $fillable = [
    	'hora'

    ];



}
