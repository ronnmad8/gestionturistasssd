<?php

namespace App\Models;
use App\Transformers\BasexTransformer;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basex extends Model
{
    use SoftDeletes;

    public $transformer = BasexTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name'
    ];
    protected $hidden = [
        'pivot'
    ];


}
