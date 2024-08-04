<?php

namespace App\Transformers;

use App\Models\Visitdias;
use League\Fractal\TransformerAbstract;

class VisitdiasTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Visitdias $visitdias)
    {

        /**
         * fecha
         * visit_id
         */	


        return [
            'id' => (int)$visitdias->id,
            'fecha' => (int)$visitdias->fecha,
            'visit_id' => (int)$visitdias->visit_id
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'fecha' => 'fecha', 
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'fecha' => 'fecha'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
