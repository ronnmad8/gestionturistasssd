<?php

namespace App\Models;

use App\Models\Visit;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Languages;
use App\Models\Hour;
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
    	return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function pedido()
    {
    	return $this->belongsTo(Pedido::class, 'pedido_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function language()
    {
    	return $this->belongsTo(Languages::class, 'language_id', 'id');
    }

    public function hour()
    {
    	return $this->belongsTo(Hours::class, 'visit_hours_id', 'id');
    }
}
