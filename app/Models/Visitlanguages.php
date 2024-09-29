<?php

namespace App\Models;


use App\Models\Visit;
use App\Models\Languages;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Transformers\VisitlanguagesTransformer;
use Illuminate\Database\Eloquent\Model;

class Visitlanguages extends Model
{
    use SoftDeletes;

    public $transformer = VisitlanguagesTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'language_id',
    	'name',
    	'descripcion'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function visit(){
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function languages(){
        return $this->belongsTo(Languages::class, 'language_id', 'id');
    }



}
