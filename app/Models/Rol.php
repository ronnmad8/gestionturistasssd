<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'uuid'

    ];
    protected $hidden = [
        'pivot'
    ];


}
