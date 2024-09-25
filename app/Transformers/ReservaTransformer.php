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
    	 * uuid,
    	 * language_id,
         * fecha,
         * visit_hours_id
         * persons
         * children
         * adults
         * total
         * titulo
         * descripcion
         * mediafilee
         */

        return [
            'id' => (int)$reserva->id,
            'uuid' => (int)$reserva->uuid,
            'visit_id' => (int)$reserva->visit_id,
            'language_id' => (int)$reserva->language_id,
            'fecha' => (string)$reserva->fecha,
            'visit_hours_id' => (int)$reserva->visit_hours_id,
            'persons' => (int)$reserva->persons,
            'children' => (int)$reserva->children,
            'adults' => (int)$reserva->adults,
            'total' => (int)$reserva->total,
            'status' => (int)$reserva->status,
            'paymentmethod' => (int)$reserva->paymentmethod,
            'private' => (int)$reserva->private,
            'titulo' => $reserva->titulo,
            'descripcion' => $reserva->descripcion,
            'mediafile' => $reserva->mediafile,
            'hora' => $reserva->hora

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'uuid' => 'uuid',
            'visit_id' => 'visit_id',
            'language_id' => 'language_id',
            'fecha' => 'fecha',
            'visit_hours_id' => 'visit_hours_id',
            'persons' => 'persons',
            'children' => 'children',
            'adults' => 'adults',
            'total' => 'total',
            'status' => 'status',
            'paymentmethod' => 'paymentmethod',
            'private' => 'private',
            'titulo' => 'titulo',
            'descripcion' => 'descipcion',
            'mediafile' => $reserva->mediafile,
            'hora' => $reserva->hora
         ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'language_id' => 'language_id',
            'fecha' => 'fecha',
            'visit_id' => 'visit_id',
            'visit_hours_id' => 'visit_hours_id',
            'persons' => 'persons',
            'children' => 'children',
            'adults' => 'adults',
            'total' => 'total',
            'status' => 'status',
            'paymentmethod' => 'paymentmethod',
            'private' => 'private',
            'titulo' => 'titulo',
            'descripcion' => 'descipcion',
            'mediafile' => $reserva->mediafile,
            'hora' => $reserva->hora
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


   
    







}
