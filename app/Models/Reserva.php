<?php

namespace App\Models;

use App\Models\Visit;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ReservaTransformer;

class Reserva extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $transformer = ReservaTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'language_id',
    	'fecha',
    	'visit_hours_id',
    	'persons',
    	'children',
        'adults',
        'pedido_id',
        'total',
        'private',
        'pedido_id'
    ]; 
    

    protected $hidden = [
        'pivot'
    ];


    public function visit()
    {
    	return $this->belongsTo(Visit::class);
    }

    public function pedido()
    {
    	return $this->belongsTo(Pedido::class);
    }


}
