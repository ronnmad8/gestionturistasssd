<?php

namespace App\Models;

use App\Transformers\IsolanguagesTransformer;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isolanguages extends Model
{
    use SoftDeletes;

    public $transformer = IsolanguagesTransformer::class;

    protected $fillable = [
    	'name',
        'iso',
        'iso_code'


    ];


    public function isoIsolanguages()
    {
        return $this->hasMany(Isolanguages::class);
    }

}
