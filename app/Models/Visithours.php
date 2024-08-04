<?php

namespace App\Models;

use App\Models\Hours;
use App\Models\Visit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Transformers\VisithoursTransformer;
use Illuminate\Database\Eloquent\Model;

class Visithours extends Model
{
    use SoftDeletes;

    public $transformer = VisithoursTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'hours_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function hours(){
        return $this->belongsTo(Hours::class);
    }

    public function visit(){
        return $this->belongsTo(Visit::class);
    }


}
