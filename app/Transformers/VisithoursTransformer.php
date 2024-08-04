<?php

namespace App\Transformers;

use App\Models\Visithours;
use League\Fractal\TransformerAbstract;

class VisithoursTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Visithours $visithours)
    {

        /**
         * hours_id
         * visit_id
         */	


        return [
            'id' => (int)$visithours->id,
            'hours_id' => (int)$visithours->hours_id,
            'visit_id' => (int)$visithours->visit_id
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'hours_id' => 'hours_id', 
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'hours_id' => 'hours_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
