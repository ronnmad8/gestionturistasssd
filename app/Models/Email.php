<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $fillable = [
    	'email',
    	'telefono',
    	'fecha',
        'message',
        'phone',
        'name',

    ];
    protected $hidden = [
        'pivot'
    ];


}
