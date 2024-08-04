<?php

namespace App\Transformers;

use App\Models\Reserva;
use League\Fractal\TransformerAbstract;

class ReservaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static  function transform(Reserva $reserva)
    {
        /**
         * id,
    	 * total,
    	 * totalfinal,
         * user_id,
         * created
         */

        return [
            'id' => (int)$reserva->id,
            'user_id' => (int)$reserva->visit_id,
            'total' => (float)$reserva->language_id,
            'totalfinal' => (float)$reserva->language_id,
            'created' => (string)$reserva->created

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'user_id' => 'user_id',
            'total' => 'total',
            'totalfinal' => 'totalfinal',
            'created' => 'created'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'user_id' => 'user_id',
            'total' => 'total',
            'totalfinal' => 'totalfinal',
            'created' => 'created'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


   
    







}
