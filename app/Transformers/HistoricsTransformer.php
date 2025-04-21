<?php

namespace App\Transformers;

use App\Models\Historics;
use League\Fractal\TransformerAbstract;

class HistoricsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Historics $historics)
    {

        /**
         * fecha,
         * data
         * 
         */	


        return [
            'id' => (int)$historics->id,
            'fecha' => (string)$historics->fecha,
            'data' => (string)$basex->data,
            'fechaCreacion' => (string)$basex->created_at,
            'fechaActualizacion' => (string)$basex->updated_at,
            'fechaEliminacion' => isset($basex->deleted_at) ? (string) $basex->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('historics.show', $basex->id),
                ]
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'fecha' => 'fecha',
            'data' => 'data',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'fecha' => 'fecha',
            'data' => 'data',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
