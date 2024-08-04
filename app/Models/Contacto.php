<?php

namespace App\Models;

use App\Transformers\ContactoTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{

    use SoftDeletes;
    
    public $transformer = ContactoTransformer::class;

    protected $fillable = [
    	'email',
    	'phone',
        'name',
    	'entity_id'

    ];
    protected $hidden = [
        'pivot'
    ];


}
