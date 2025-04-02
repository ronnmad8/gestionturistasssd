<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CitaTransformer;

class Cita extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $transformer = CitaTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'guia_id',
    	'visit_id',
        'status',
    	'language_id',
    	'hours_id',
    	'fecha',
    	'min',
    	'max',
    	'clients',
        'deleted_at',
        'created_at',
        'updated_at',

    ]; 
    


    public function visit()
    {
    	return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function language()
    {
    	return $this->belongsTo(Languages::class, 'language_id', 'id');
    }

    public function hour()
    {
    	return $this->belongsTo(Hours::class, 'hours_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'guia_id', 'id');
    }
}
