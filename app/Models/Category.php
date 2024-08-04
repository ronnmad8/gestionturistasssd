<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
