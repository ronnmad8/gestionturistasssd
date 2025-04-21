<?php

namespace App\Models;
use App\Transformers\HistoricsTransformer;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historics extends Model
{
    use SoftDeletes;

    public $transformer = HistoricsTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'data'
    ];
    


}
