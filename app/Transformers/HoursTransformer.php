<?php

namespace App\Transformers;

use App\Models\Hours;
use League\Fractal\TransformerAbstract;

class HoursTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Hours $hours)
    {

        /**
         * hora
         */	


        return [
            'id' => (int)$hours->id,
            'hora' => (string)$hours->hora

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'hora' => 'hora'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'hora' => 'hora'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
