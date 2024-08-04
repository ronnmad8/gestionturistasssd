<?php

namespace App\Transformers;

use App\Models\Basex;
use League\Fractal\TransformerAbstract;

class basexTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(basex $basex)
    {

        /**
         * name,
         * id
         * 
         */	


        return [
            'idbasex' => (int)$basex->id,
            'nombre' => (string)$basex->name,
            'fechaCreacion' => (string)$basex->created_at,
            'fechaActualizacion' => (string)$basex->updated_at,
            'fechaEliminacion' => isset($basex->deleted_at) ? (string) $basex->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('basexs.show', $basex->id),
                ]
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'idbasex' => 'id',
            'nombre' => 'name',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'idbasex',
            'name' => 'nombre',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
