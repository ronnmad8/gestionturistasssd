<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Visit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Transformers\VisittagsTransformer;
use Illuminate\Database\Eloquent\Model;

class Visittags extends Model
{
    use SoftDeletes;

    public $transformer = VisittagsTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'tags_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function tags(){
        return $this->belongsTo(Tag::class);
    }

    public function visit(){
        return $this->belongsTo(Visit::class);
    }


}
