<?php

namespace App\Models;

use App\Transformers\TextcontentsTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Textcontents extends Model
{

    use SoftDeletes;
    
    public $transformer = TextcontentsTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name',
    	'uuid',
        'content'
    ];



}
