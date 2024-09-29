<?php

namespace App\Models;

use App\Transformers\IsolanguagesTransformer;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitlanguages;
use App\Models\Isolanguages;

class Languages extends Model
{
    use SoftDeletes;

    public $transformer = LanguagesTransformer::class;

    protected $fillable = [
    	'name',
        'iso',
        'iso_code'


    ];


    public function isolanguages()
    {
        return $this->hasMany(Isolanguages::class, 'language_id');
    }

    public function visitlanguages()
    {
        return $this->hasMany(Visitlanguages::class);
    }

}
