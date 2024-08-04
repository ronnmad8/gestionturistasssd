<?php

namespace App\Transformers;

use App\Models\Contacto;
use League\Fractal\TransformerAbstract;

class ContactoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Contacto $contacto )
    {

        /**
         * name,
         * email
         * phone
         * entity_id
         */	


        return [
            'idcontacto' => (int)$contacto->id,
            'identidad' => (int)$contacto->entity_id,
            'nombre' => (string)$contacto->name,
            'email' => (string)$contacto->email,
            'telefono' => (string)$contacto->phone,
            'fechaCreacion' => (string)$contacto->created_at,
            'fechaActualizacion' => (string)$contacto->updated_at,
            'fechaEliminacion' => isset($contacto->deleted_at) ? (string) $contacto->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('contactos.show', $contacto->id),
                ]
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'idcontacto' => 'id',
            'nombre' => 'name',
            'email' => 'email',
            'telefono' => 'phone',
            'identidad' => 'entity_id',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'idcontacto',
            'name' => 'nombre',
            'email' => 'email',
            'phone' => 'telefono',
            'entity_id' => 'identidad',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
