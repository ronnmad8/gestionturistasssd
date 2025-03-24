<?php

namespace App\Transformers;

use App\Models\Cita;
use League\Fractal\TransformerAbstract;

class CitaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static  function transform(Cita $cita)
    {
        /**
         * id,
         * guia_id,
         * visit_id,
         * status,
    	 * language_id,
         * fecha,
         * hours_id
         * fecha
         * min
         * max
         * clients
         */

        return [
            'id' => (int)$cita->id,
            'guia_id' => (int)$cita->guia_id,
            'visit_id' => (int)$cita->visit_id,
            'status' => $cita->status,
            'language_id' => (int)$cita->language_id,
            'fecha' => $cita->fecha,
            'hours_id' => (int)$cita->hours_id,
            'min' => $cita->min,
            'max' => $cita->max,
            'clients' => $cita->clients

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'guia_id' => 'guia_id',
            'visit_id' => 'visit_id',
            'status' => 'status',
            'language_id' => 'language_id',
            'fecha' => 'fecha',
            'hours_id' => 'hours_id',
            'min' => 'min',
            'max' => 'max',
            'clients' => 'clients'

         ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'guia_id' => 'guia_id',
            'visit_id' => 'visit_id',
            'status' => 'status',
            'language_id' => 'language_id',
            'fecha' => 'fecha',
            'hours_id' => 'hours_id',
            'min' => 'min',
            'max' => 'max',
            'clients' => 'clients'

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


   
    







}
