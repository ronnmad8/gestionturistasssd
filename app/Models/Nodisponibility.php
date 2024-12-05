<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Nodisponibility extends Model
{

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'fecha'
    ];
    protected $hidden = [
        'pivot'
    ];


}
