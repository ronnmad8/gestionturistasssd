<?php

namespace App\Models;


use App\Transformers\TextcommentsTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visit;

class Textcomments extends Model
{

    use SoftDeletes;
    
    public $transformer = TextcommentsTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name',
    	'uuid',
        'content',
        'titulo',
        'name',
        'visit_id',
    ];
    protected $hidden = [
        'pivot'
    ];


    public function visit(){
        return $this->belongsTo(Visit::class);
    }

}
