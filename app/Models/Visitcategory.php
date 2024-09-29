<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Visit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Transformers\VisitcategoryTransformer;
use Illuminate\Database\Eloquent\Model;

class Visitcategory extends Model
{
    use SoftDeletes;

    public $transformer = VisitcategoryTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'category_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function visit(){
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }


}
