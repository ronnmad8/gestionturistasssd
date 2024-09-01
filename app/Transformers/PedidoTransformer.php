<?php

namespace App\Transformers;

use App\Models\Pedido;
use League\Fractal\TransformerAbstract;

class PedidoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static  function transform(Pedido $pedido)
    {
        /**
         * id,
    	 * total,
    	 * totalfinal,
         * user_id,
         * created_at
         */

        return [
            'id' => (int)$pedido->id,
            'total' => (float)$pedido->total,
            'totalfinal' => (float)$pedido->totalfinal,
            'user_id' => (float)$pedido->user_id,
            'peymentmethod' => (float)$pedido->paymentmethod,
            'created_at' => (string)$pedido->created_at,
            'reservas' => $pedido->reservas
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'total' => 'total',
            'totalfinal' => 'totalfinal',
            'user_id' => 'user_id',
            'paymentmethod' => 'paymentmethod',
            'created_at' => 'created_at',
            'reservas' => 'reservas'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'total' => 'total',
            'totalfinal' => 'totalfinal',
            'user_id' => 'user_id',
            'paymentmethod' => 'paymentmethod',
            'created_at' => 'created_at',
            'reservas' => 'reservas'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


   
    







}
