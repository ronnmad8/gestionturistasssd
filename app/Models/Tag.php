<?php

namespace App\Models;

use App\Transformers\TagsTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use SoftDeletes;

    public $transformer = TagsTransformer::class;

    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name'
    ];
    protected $hidden = [
        'pivot'
    ];


}