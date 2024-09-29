<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitcategory;

class Category extends Model
{

    use SoftDeletes;
    
    public $transformer = CategoryTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name'
    ];
    protected $hidden = [
        'pivot'
    ];


    public function visitCategories()
    {
        return $this->hasMany(Visitcategory::class, 'category_id', 'id'); 
    }
}
