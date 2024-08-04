<?php

namespace App\Transformers;

use App\Models\Franjashorarias;
use League\Fractal\TransformerAbstract;

class FranjashorariasTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Franjashorarias $franjashorarias)
    {

        /**
         * init_hours_id
         * end_hours_id
         */	


        return [
            'id' => (int)$franjashorarias->id,
            'init_hours_id' => (int)$franjashorarias->init_hours_id,
            'end_hours_id' => (int)$franjashorarias->end_hours_id,

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'init_hours_id' => 'init_hours_id',
            'end_hours_id' => 'end_hours_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'init_hours_id' => 'init_hours_id',
            'end_hours_id' => 'end_hours_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
