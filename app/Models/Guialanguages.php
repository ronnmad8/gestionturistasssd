<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Disponibility;

class Guialanguages extends Model
{

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'language_id',
    ];
    protected $hidden = [
        'pivot'
    ];


    public function language()
    {
        return $this->belongsTo(Disponibility::class, 'user_id', 'user_id');
    }

}
