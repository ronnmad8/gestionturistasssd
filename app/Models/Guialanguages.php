<?php

namespace App\Models;

use App\Transformers\GuialanguagesTransformer;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guialanguages;

class Guialanguages extends Model
{

    use SoftDeletes;

    public $transformer = GuialanguagesTransformer::class;
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'language_id',
    ];





}
