<?php

namespace App\Transformers;

use App\Models\Disponibility;
use League\Fractal\TransformerAbstract;

class DisponibilitiesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Disponibility $disponibilities)
    {

        /**
         * user_id
         * franjahoraria_id
         * diasemana
         * init_hours_id
         * end_hours_id,
         * languagesguia
         */	


        return [
            'id' => (int)$disponibilities->id,
            'user_id' => (int)$disponibilities->user_id,
            'franjahoraria_id' => (int)$disponibilities->franjahoraria_id,
            'diasemana' => (int)$disponibilities->diasemana,
            'init_hours_id' => (int)$disponibilities->init_hours_id,
            'end_hours_id' => (int)$disponibilities->end_hours_id,
            'guialanguages' => $disponibilities->guialanguages->pluck('language_id')->toArray()

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'user_id' => 'user_id',
            'franjahoraria_id' => 'franjahoraria_id',
            'diasemana' => 'diasemana',
            'init_hours_id' => 'init_hours_id',
            'end_hours_id' => 'end_hours_id',
            'guialanguages' => 'guialanguages'

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'user_id' => 'user_id',
            'franjahoraria_id' => 'franjahoraria_id',
            'diasemana' => 'diasemana',
            'init_hours_id' => 'init_hours_id',
            'end_hours_id' => 'end_hours_id',
            'guialanguages' => 'guialanguages'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
