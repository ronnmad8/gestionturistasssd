<?php

namespace App\Models;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\PedidoTransformer;


class Pedido extends Model
{
    
    use SoftDeletes;
    use HasFactory;

    public $transformer = PedidoTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'user_id',
    	'total',
    	'totalfinal',
        'paymentmethod'
    ];
    
    protected $hidden = [
        'pivot'
    ];


    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }


}
