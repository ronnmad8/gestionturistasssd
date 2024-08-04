<?php

namespace App\Models;


use App\Models\Visit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Transformers\VisitdiasTransformer;
use Illuminate\Database\Eloquent\Model;

class Visitdias extends Model
{
    use SoftDeletes;

    public $transformer = VisitdiasTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'fecha'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function visit(){
        return $this->belongsTo(Visit::class);
    }


}
